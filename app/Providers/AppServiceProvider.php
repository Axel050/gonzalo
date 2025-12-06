<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void {}

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    // Carbon::setLocale('es');
    // setlocale(LC_TIME, 'es_ES.UTF-8');

    VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
      return (new MailMessage)
        ->subject('Verifica tu email en CASABLANCA.AR')
        ->view('emails.verify-email', [  // Usa tu vista custom
          'url' => $url,
          'appName' => 'CASABLANCA.AR',
        ]);
    });
  }
}
