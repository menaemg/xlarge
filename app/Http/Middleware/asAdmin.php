<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class asAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $rule = Auth::user()->rule;
        if ($rule > 2) {
            return $next($request);
        } else {
            $status = 0;
            $message = 'login as a admin frist';
            return jsonResponse($status, $message, Auth::user());
        }
    }
}
