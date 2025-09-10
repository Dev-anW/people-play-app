<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// 1. IMPORT THE CORRECT RESPONSE CLASS
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // 2. UPDATE THE RETURN TYPE HINT
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        // Now, this RedirectResponse is a valid return type because it's a
        // child of the Symfony Response class we imported.
        return redirect('/home');
    }
}