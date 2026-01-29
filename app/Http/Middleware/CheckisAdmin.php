<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIsAdmin
{
  public function handle(Request $request, Closure $next)
  {
    if (! auth()->check()) {
      return redirect()->route('login');
    }

    // 👤 adquirente → afuera SIN mensaje
    if (auth()->user()->hasRole('adquirente')) {
      return redirect()->route('home');
    }

    return $next($request);
  }
}
