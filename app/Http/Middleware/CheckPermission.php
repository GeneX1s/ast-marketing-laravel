<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Check if the authenticated user has permission to access the current route segment.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect('/login');
        }

        // Load relationships if not loaded
        $user->loadMissing('role.permissionGroup.permissions');

        // Admin bypasses all permission checks
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Determine the current page segment
        $path = ltrim($request->path(), '/');
        $segment = $path === '' ? 'dashboard' : explode('/', $path)[0];

        // Always allow profile and settings pages
        $publicSegments = ['profil', 'pengaturan', 'logout'];
        if (in_array($segment, $publicSegments)) {
            return $next($request);
        }

        // Check permission
        if (!$user->hasPermission($segment)) {
            // If on dashboard but no access, redirect to first allowed page
            if ($segment === 'dashboard' || $path === '') {
                $pages = $user->getPermissionPages();
                if (!empty($pages) && $pages[0] !== 'dashboard') {
                    return redirect('/' . $pages[0]);
                }
            }

            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
