<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Jika tidak login
        if (!$user) {
            return redirect()->route('login');
        }

        if ($request->is('dashboard')) {
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'client':
                    return redirect()->route('client.index');
                case 'freelancer':
                    return redirect()->route('freelancer.dashboard');
                default:
                    abort(403, 'Role tidak dikenali');
            }
        }

        // Jika role tidak termasuk yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
