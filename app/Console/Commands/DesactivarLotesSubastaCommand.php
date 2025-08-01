<?php

namespace App\Console\Commands;

use App\Jobs\DesactivarLotesExpirados;
use Illuminate\Console\Command;

class DesactivarLotesSubastaCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:desactivar-subasta-command';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Ejecuta el job para desactivar lotes';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $job = new DesactivarLotesExpirados();
    $job->handle();

    $this->info('Job DesactivarLotes ejecutado correctamente.');
  }
}
