<?php

namespace App\Livewire\Admin\Lotes;


use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\App;

class ModalQr extends Component
{
  public $id;

  public function downloadQr()
  {
    $url = route('lotes.show', ['id' => $this->id]);
    $svg = QrCode::size(400)->generate($url);

    $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($svg);

    $pdf = Pdf::loadView('livewire.admin.lotes.qr-pdf', [
      'qr' => $qrBase64,
      'url' => $url,
      'id' => $this->id
    ]);

    return response()->streamDownload(function () use ($pdf) {
      echo $pdf->output(); // contenido
    }, 'qr-lote-' . $this->id . '.pdf');
  }




  public function close()
  {
    // if ($this->index) {
    //   $this->dispatch("closeModalToIndex");
    // } else {
    $this->dispatch("closeModalToQR");
    // }
  }







  public function render()
  {

    $url = route('lotes.show', ['id' => $this->id]);
    $svg = QrCode::size(400)->generate($url);
    $qr = 'data:image/svg+xml;base64,' . base64_encode($svg);
    return view('livewire.admin.lotes.modal-qr', compact("qr"));
  }
}
