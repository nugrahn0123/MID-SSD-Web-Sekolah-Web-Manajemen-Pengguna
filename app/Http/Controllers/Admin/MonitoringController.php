<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BkCase;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\TeachingJournal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    public function index(): View
    {
        // ── PHP / Server Metrics ────────────────────────────────────────────
        $memUsed      = memory_get_usage(true);
        $memPeak      = memory_get_peak_usage(true);
        $memLimit     = $this->parseMemoryLimit(ini_get('memory_limit'));
        $memUsedPct   = $memLimit > 0 ? round($memUsed / $memLimit * 100, 1) : 0;

        $diskTotal    = disk_total_space(base_path());
        $diskFree     = disk_free_space(base_path());
        $diskUsed     = $diskTotal - $diskFree;
        $diskUsedPct  = $diskTotal > 0 ? round($diskUsed / $diskTotal * 100, 1) : 0;

        // CPU load (Unix only — null on Windows)
        $cpuLoad      = function_exists('sys_getloadavg') ? sys_getloadavg() : null;

        // ── Application Metrics ────────────────────────────────────────────
        $dbStats = [
            'users'    => User::count(),
            'students' => Student::count(),
            'classes'  => SchoolClass::count(),
            'journals' => TeachingJournal::count(),
            'bk_cases' => BkCase::count(),
            'logs'     => ActivityLog::count(),
        ];

        // Active users: anyone who has a log entry in the last 15 minutes
        $activeUsers = ActivityLog::where('created_at', '>=', now()->subMinutes(15))
            ->distinct('user_id')
            ->count('user_id');

        // Requests today (log entries = proxy for HTTP requests)
        $requestsToday = ActivityLog::whereDate('created_at', today())->count();

        // Recent errors from Laravel log file
        $recentErrors = $this->parseRecentErrors(20);

        // DB table sizes (MySQL / MariaDB)
        $tableSizes = $this->getTableSizes();

        // Uptime approximation via storage/app/.boot file
        $uptimeSeconds = $this->getUptimeSeconds();

        // ── vCPU Status (simulated — would come from real infra in prod) ───
        $vcpus = $this->vcpuDefinitions();

        return view('admin.monitoring.index', compact(
            'memUsed', 'memPeak', 'memLimit', 'memUsedPct',
            'diskTotal', 'diskFree', 'diskUsed', 'diskUsedPct',
            'cpuLoad',
            'dbStats', 'activeUsers', 'requestsToday',
            'recentErrors', 'tableSizes', 'uptimeSeconds',
            'vcpus'
        ));
    }

    // ── Private helpers ────────────────────────────────────────────────────

    private function parseMemoryLimit(string $limit): int
    {
        if ($limit === '-1') {
            return 512 * 1024 * 1024; // treat unlimited as 512 MB for display
        }
        $unit  = strtolower(substr($limit, -1));
        $value = (int) $limit;

        return match ($unit) {
            'g' => $value * 1024 * 1024 * 1024,
            'm' => $value * 1024 * 1024,
            'k' => $value * 1024,
            default => $value,
        };
    }

    private function parseRecentErrors(int $limit): array
    {
        $logFile = storage_path('logs/laravel.log');
        if (! file_exists($logFile)) {
            return [];
        }

        $lines  = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
        $errors = [];

        foreach (array_reverse($lines) as $line) {
            if (str_contains($line, '.ERROR') || str_contains($line, '.CRITICAL') || str_contains($line, '.WARNING')) {
                $errors[] = substr($line, 0, 200);
                if (count($errors) >= $limit) {
                    break;
                }
            }
        }

        return $errors;
    }

    private function getTableSizes(): array
    {
        try {
            $dbName = DB::connection()->getDatabaseName();
            $rows   = DB::select("
                SELECT table_name AS name,
                       ROUND((data_length + index_length) / 1024, 1) AS size_kb,
                       table_rows AS row_count
                FROM information_schema.tables
                WHERE table_schema = ?
                ORDER BY (data_length + index_length) DESC
            ", [$dbName]);

            return array_map(fn ($r) => (array) $r, $rows);
        } catch (\Throwable) {
            return [];
        }
    }

    private function getUptimeSeconds(): ?int
    {
        $marker = storage_path('app/.boot_time');

        if (! file_exists($marker)) {
            file_put_contents($marker, time());
        }

        return time() - (int) file_get_contents($marker);
    }

    private function vcpuDefinitions(): array
    {
        return [
            [
                'id'      => 1,
                'label'   => 'vCPU 1',
                'name'    => 'Web Jurnal Mengajar',
                'icon'    => 'bi-book',
                'color'   => 'primary',
                'desc'    => 'Menangani input & rekap jurnal mengajar guru.',
                'metric'  => TeachingJournal::count() . ' jurnal',
                'status'  => 'online',
            ],
            [
                'id'      => 2,
                'label'   => 'vCPU 2',
                'name'    => 'Web BK',
                'icon'    => 'bi-clipboard2-heart',
                'color'   => 'danger',
                'desc'    => 'Modul bimbingan konseling & data sensitif siswa.',
                'metric'  => BkCase::count() . ' kasus',
                'status'  => 'online',
            ],
            [
                'id'      => 3,
                'label'   => 'vCPU 3',
                'name'    => 'Web Data Kesiswaan',
                'icon'    => 'bi-mortarboard',
                'color'   => 'success',
                'desc'    => 'Manajemen data utama siswa, kelas & wali kelas.',
                'metric'  => Student::count() . ' siswa',
                'status'  => 'online',
            ],
            [
                'id'      => 4,
                'label'   => 'vCPU 4',
                'name'    => 'Akademik & Manajemen Pengguna',
                'icon'    => 'bi-people',
                'color'   => 'info',
                'desc'    => 'Akun, role, jadwal & data akademik sekolah.',
                'metric'  => User::count() . ' pengguna',
                'status'  => 'online',
            ],
            [
                'id'      => 5,
                'label'   => 'vCPU 5',
                'name'    => 'Database Server',
                'icon'    => 'bi-server',
                'color'   => 'warning',
                'desc'    => 'Penyimpanan terpusat (MySQL). Semua modul menggunakan DB ini.',
                'metric'  => ActivityLog::count() . ' log entries',
                'status'  => 'online',
            ],
            [
                'id'      => 6,
                'label'   => 'vCPU 6',
                'name'    => 'Load Balancer & Monitoring',
                'icon'    => 'bi-activity',
                'color'   => 'secondary',
                'desc'    => 'Nginx LB, backup, monitoring server & logging terpusat.',
                'metric'  => ActivityLog::whereDate('created_at', today())->count() . ' req hari ini',
                'status'  => 'online',
            ],
        ];
    }
}
