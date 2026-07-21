<?php

namespace App\Traits;

use App\Models\ActivityLog;

/**
 * Reusable trait untuk semua controller yang perlu mencatat aktivitas pengguna.
 * Dipanggil dengan $this->logActivity('action_code', 'deskripsi singkat').
 */
trait LogsActivity
{
    protected function logActivity(string $action, string $description): void
    {
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }
}
