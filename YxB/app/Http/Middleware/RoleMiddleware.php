<?php

namespace App\Http\Middleware;

use App\Enums\VendorApprovalStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        $user = auth()->user();

        if (!$user || $user->role !== $role) {
            abort(403);
        }

        if ($role === 'vendor') {
            if (!$user->vendorProfile || $user->vendorProfile->status !== VendorApprovalStatus::APPROVED->value) {
                abort(403);
            }
        }

        return $next($request);
    }
}
