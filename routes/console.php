<?php

use App\Jobs\DesactivarLotesExpirados;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new DesactivarLotesExpirados)->everyThirtySeconds();
// Schedule::job(new DesactivarLotesExpirados)->everyFiveSeconds();

// Schedule::job(new DesactivarLotesExpirados)->everyThirtySeconds();
// Schedule::job(new DesactivarLotesExpirados)->everyMinute();



// while true; do php artisan schedule:run; sleep 5; done

// Schedule::job(new DesactivarLotesExpirados)->everyFiveSeconds();

// Schedule::job(new DesactivarLotesExpirados)->everyMinute();
