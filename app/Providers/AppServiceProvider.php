<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

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

    // VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
    //   return (new MailMessage)
    //     ->subject('Verifica tu email en CASABLANCA.AR')
    //     ->view('emails.verify-email', [  // Usa tu vista custom
    //       'url' => $url,
    //       'appName' => 'CASABLANCA.AR',
    //     ])
    //     ->text('emails.verify-text');
    // });

    // NEW
    Mail::extend('brevo', function (array $config) {
      return (new BrevoTransportFactory())->create(
        new Dsn(
          'brevo+api',
          'default',
          config('services.brevo.key')
        )
      );
    });
    // NEW

    VerifyEmail::toMailUsing(function ($notifiable, string $url) {
      return (new MailMessage)
        ->from(
          address: 'info@casablanca.ar',
          name: 'Casablanca'
        )
        ->subject('Verifica tu email')
        ->view('emails.verify-email', ['url' => $url])
        ->text('emails.verify-text', ['url' => $url])

        ->withSymfonyMessage(function ($message) {
          $message->getHeaders()->addTextHeader(
            'List-Unsubscribe',
            '<mailto:soporte@casablanca.ar?subject=unsubscribe>'
          );
        });
    });



    // ✅ RATE LIMITER API
    RateLimiter::for('api', function (Request $request) {
      return Limit::perMinute(60)->by(
        $request->user()?->id ?: $request->ip()
      );
    });
  }
}
