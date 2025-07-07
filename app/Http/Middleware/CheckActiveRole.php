<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveRole
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (!auth()->user()) {
      return response()->view('livewire.auth.noautorizado', [], 403);
    }

    if (auth()->user()->hasRole('adquirente')) {
      return response()->view('livewire.auth.noautorizado', [], 403);
    }

    if (!auth()->user()?->hasActiveRole()) {

      $request->session()->invalidate();
      $request->session()->regenerateToken();

      return response()->view('livewire.auth.role-desactivated', [], 403);
    }


    return $next($request);
  }
}
