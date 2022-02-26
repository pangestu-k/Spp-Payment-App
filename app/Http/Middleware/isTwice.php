<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isTwice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->level == 'siswa') {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
