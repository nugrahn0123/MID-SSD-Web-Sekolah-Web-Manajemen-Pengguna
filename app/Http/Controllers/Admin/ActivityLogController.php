<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = ActivityLog::with('user')
            ->when($request->user_id, fn ($query, $userId) => $query->where('user_id', $userId))
            ->when($request->action, fn ($query, $action) => $query->where('action', $action))
            ->when($request->date_from, fn ($query, $date) => $query->whereDate('created_at', '>=', $date))
            ->when($request->date_to, fn ($query, $date) => $query->whereDate('created_at', '<=', $date))
            ->latest('created_at')
            ->paginate(20)
            ->withQueryString();

        // Statistik monitoring: ringkasan hari ini per jenis aksi
        $todayStats = ActivityLog::query()
            ->selectRaw('action, COUNT(*) as total')
            ->whereDate('created_at', today())
            ->groupBy('action')
            ->orderByDesc('total')
            ->get();

        $totalToday   = $todayStats->sum('total');
        $totalAllTime = ActivityLog::count();

        return view('admin.activity-logs.index', [
            'logs'         => $logs,
            'users'        => User::orderBy('name')->get(),
            'actions'      => ActivityLog::query()->select('action')->distinct()->orderBy('action')->pluck('action'),
            'todayStats'   => $todayStats,
            'totalToday'   => $totalToday,
            'totalAllTime' => $totalAllTime,
        ]);
    }

    /**
     * Export seluruh log ke CSV (hanya admin).
     */
    public function export(Request $request): RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename = 'activity-logs-'.now()->format('Ymd-His').'.csv';

        $query = ActivityLog::with('user')
            ->when($request->date_from, fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($request->date_to,   fn ($q, $date) => $q->whereDate('created_at', '<=', $date))
            ->oldest('created_at');

        return response()->streamDownload(function () use ($query): void {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id', 'waktu', 'user', 'email', 'aksi', 'deskripsi', 'ip_address']);

            foreach ($query->cursor() as $log) {
                fputcsv($out, [
                    $log->id,
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user?->name ?? '-',
                    $log->user?->email ?? '-',
                    $log->action,
                    $log->description,
                    $log->ip_address,
                ]);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
