<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{

    public function handle($request, Closure $next,$role = 'admin')
    {

        if ($request->user()) {
            if ( $request->user()->role == $role) {
                dd('ciao');
                return route('admin');
            }
        }

        return $next($request);

    }
}
