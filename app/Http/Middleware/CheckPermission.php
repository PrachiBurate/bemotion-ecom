<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
 public function handle($request, Closure $next, $permission)
{
// dd(auth()->check(), auth()->user());

    $user = auth()->user();
    // ❌ Not logged in
    if (!$user) {
        return redirect('/admin/login');
    }

    //   Admin full access
    if ($user->is_admin == 1) {
        return $next($request);
    }

    // ❌ No role assigned
    if (!$user->role) {
        abort(403, 'No role assigned');
    }

    //   SAFE CHECK (DB level - BEST)
    $hasPermission = $user->role
        ->permissions()
        ->where('slug', $permission)
        ->exists();

    if (!$hasPermission) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
}
}
