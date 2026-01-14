<?php

namespace App\Livewire\Traits;

use Illuminate\Http\UploadedFile;

trait UploadSecurity
{
  protected function isDangerousExtension(UploadedFile $file): bool
  {
    $ext = strtolower($file->getClientOriginalExtension());

    return in_array($ext, [
      'php',
      'php3',
      'php4',
      'php5',
      'phtml',
      'phar',
      'exe',
      'sh',
      'bat',
      'cmd',
      'js',
      'html',
      'htm',
    ], true);
  }

  protected function addUploadSecurityError(string $field): void
  {
    $this->addError(
      $field,
      'Tipo de archivo no permitido'
    );
  }
}
