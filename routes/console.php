<?php

use App\Jobs\ActivarLotes;
use App\Jobs\DesactivarLotesExpirados;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new ActivarLotes)->everyMinute();
Schedule::job(new DesactivarLotesExpirados)->everyMinute();
// Schedule::job(new DesactivarLotesExpirados)->everyThirtySeconds();
// Schedule::job(new DesactivarLotesExpirados)->everyFifteenSeconds();
