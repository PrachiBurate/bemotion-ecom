<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
   public function handle($request, Closure $next)
{
    if (!auth()->check()) {
        return redirect('/admin/login');
    }

    // ❌ REMOVE THIS CHECK
    // if (auth()->user()->is_admin != 1)

    return $next($request);
}
}