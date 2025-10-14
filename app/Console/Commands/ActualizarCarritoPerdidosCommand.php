<?php

namespace App\Console\Commands;

use App\Jobs\ActualizarCarritoPerdidos;
use Illuminate\Console\Command;

class ActualizarCarritoPerdidosCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:actualizar-carrito-perdidos-command';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Ejecuta el job para actualizar carrito luego de 24hs de cierre subasta';
  /**
   * Execute the console command.
   */
  public function handle()
  {
    $job = new ActualizarCarritoPerdidos();
    $job->handle();

    $this->info('Job ActualizarCarritoPerdidos ejecutado correctamente.');
  }
}
