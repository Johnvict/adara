<?php

namespace App\Http\Middleware;

use App\Traits\ResponseFormats;
use Closure;

class SuperAdminMiddleware
{
    use ResponseFormats;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user()->role;

        if ($user == "superadmin") {
            return $next($request);
        }

        return self::returnFailed("you're not authorized to perform this action");
    }
}
