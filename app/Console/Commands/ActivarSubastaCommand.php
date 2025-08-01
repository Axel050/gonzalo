<?php

namespace App\Console\Commands;

use App\Jobs\ActivarLotes;
use Illuminate\Console\Command;

class ActivarSubastaCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:activar-subasta-command';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Activar lotess';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $job = new ActivarLotes();
    $job->handle();
    $this->info('Job ActivarLotes ejecutado correctamente.');
  }
}
