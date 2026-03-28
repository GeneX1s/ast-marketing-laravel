<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait LogsActivity
{
    /**
     * Log an activity to the activity table.
     *
     * @param string $module   The module/page name (e.g., "Kampanye", "Manajemen User")
     * @param string $action   The action type (CREATE, UPDATE, DELETE)
     * @param string $description  Human-readable description of what happened
     * @param string $result   SUCCESS or FAILED
     */
    protected function logActivity(
        string $module,
        string $action,
        string $description,
        string $result = 'SUCCESS'
    ): void {
        try {
            Activity::create([
                'user' => Auth::user()?->email ?? 'System',
                'module' => $module,
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip(),
                'result' => $result,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }
}
