<?php

use App\Jobs\ActivarLotes;
use App\Jobs\ActualizarCarritoPerdidos;
use App\Jobs\DesactivarLotesExpirados;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

//  php artisan app:desactivar-subasta-command   
//  php artisan app:actualizar-carrito-perdidos   

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new ActivarLotes)->everyMinute();
Schedule::job(new DesactivarLotesExpirados)->everyMinute();
Schedule::job(new ActualizarCarritoPerdidos)->daily();
// Schedule::job(new DesactivarLotesExpirados)->everyThirtySeconds();
// Schedule::job(new DesactivarLotesExpirados)->everyFifteenSeconds();
