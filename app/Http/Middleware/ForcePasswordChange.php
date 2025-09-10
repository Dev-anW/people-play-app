<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        
        if (auth()->check() && auth()->user()->email_verified_at === null) {
            
            if (!$request->routeIs('password.create') && !$request->routeIs('password.store') && !$request->routeIs('logout')) {
                return redirect()->route('password.create')
                                 ->with('warning', 'You must set a new password before you can continue.');
            }
        }
        return $next($request);
    }
}
