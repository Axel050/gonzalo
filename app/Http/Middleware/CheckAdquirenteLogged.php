<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdquirenteLogged
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {


    if (!auth()->user()?->hasActiveRole('adquirente')) {
      return response()->view('livewire.auth.noautorizado', [], 403);
    }


    return $next($request);
  }
}
