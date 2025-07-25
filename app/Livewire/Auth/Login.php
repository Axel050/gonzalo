<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;



#[Layout('components.layouts.auth')]
class Login extends Component
{
  public $mail, $pas;

  #[Validate('required|string|email')]
  public string $email = '';

  #[Validate('required|string')]
  public string $password = '';

  public bool $remember = false;

  /**
   * Handle an incoming authentication request.
   */
  public function mount()
  {
    info("Mount");
    if (Session::has('prefill')) {
      $this->email = Session::get('prefill.mail');
      $this->password  = Session::get('prefill.pas');
      info(["eee" => $this->email]);
      info(["ppppp" => $this->password]);
      info(["xxx" => Session::get('prefill.mail')]);
    }
  }

  public function login(): void
  {
    $this->validate();

    $this->ensureIsNotRateLimited();

    if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
      RateLimiter::hit($this->throttleKey());

      throw ValidationException::withMessages([
        // 'email' => __('auth.failed'),
        'email' => "Datos incorrectos",
      ]);
    }

    RateLimiter::clear($this->throttleKey());
    Session::regenerate();

    $user  = Auth::user();

    // $user  = auth()->user();
    // info(["user" => $user]);
    // $user = $request->user();
    if ($user->hasRole('adquirente')) {
      // session()->forget('url.intended');
      $this->redirectIntended(default: route('adquirentes.perfil', absolute: false), navigate: false);
    } else {
      $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
  }

  /**
   * Ensure the authentication request is not rate limited.
   */
  protected function ensureIsNotRateLimited(): void
  {
    if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
      return;
    }

    event(new Lockout(request()));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
      'email' => __('auth.throttle', [
        'seconds' => $seconds,
        'minutes' => ceil($seconds / 60),
      ]),
    ]);
  }

  /**
   * Get the authentication rate limiting throttle key.
   */
  protected function throttleKey(): string
  {
    return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
  }
}
