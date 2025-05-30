<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
  return view('livewire.auth.role-desactivated');
});

Route::get('/', function () {
  return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
  ->middleware(['auth', 'verified', 'active.role'])
  ->name('dashboard')
  ->can("dashboard-ver");

Route::middleware(['auth'])->group(function () {
  Route::redirect('settings', 'settings/profile');

  Route::get('settings/profile', Profile::class)->name('settings.profile');
  Route::get('settings/password', Password::class)->name('settings.password');
  Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
