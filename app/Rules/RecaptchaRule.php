<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class RecaptchaRule implements ValidationRule
{
  /**
   * Run the validation rule.
   *
   * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {

    $response = Http::asForm()->withOptions(['verify' => false])
      ->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => config('services.recaptcha.secret'),
        'response' => $value,
        'remoteip' => request()->ip(),
      ]);

    $result = $response->json();

    if (!($result['success'] ?? false)) {
      $fail('La verificación de reCAPTCHA falló. Por favor, intenta de nuevo.');
    }
  }
}
