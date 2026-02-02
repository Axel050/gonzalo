<?php

namespace App\Livewire\Admin\Lotes;

use App\Enums\LotesEstados;
use App\Livewire\Traits\UploadSecurity;
use App\Models\Caracteristica;
use App\Models\Contrato;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\TiposBien;
use App\Models\ValoresCataracteristica;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Modal extends Component
{


  use WithFileUploads;
  use  UploadSecurity;


  public $qr;
  public $destacado;

  public $historial;

  public $foto1, $foto2, $foto3, $foto4;
  public $foto5, $foto6, $foto7, $foto8;


  public $comitente;

  public $audio, $temp;


  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $contrato;
  public $contrato_id;
  public $nombre;

  public $descripcion;
  public $desc_extra;
  public $valuacion;
  public $base = 1;
  public $fraccion_min = 0;
  public $venta_directa;
  public $precio_venta_directa = 0;

  public $comitente_id;

  public $monedas = [];
  public $moneda_id;

  public $estados = [];
  public $tipos = [];
  public $tipo_bien_id;
  public $caracteristicas;

  public $adquirente_id, $subasta_id, $monto, $fecha, $fecha_devolucion, $estado;

  public $lote;
  public $titulo;

  public $formData = [];

  public $rules  = [
    'comitente_id' => 'required',
    'tipo_bien_id' => 'required|exists:tipos_biens,id',
    'titulo' => 'required',
    'valuacion' => 'required|numeric|min:1',
    'estado' => 'required',
    'fraccion_min' => 'required|numeric|min:1',
    'moneda_id' => 'required',
  ];



  #[On(['closeModalToQR'])]
  public function closeQrModal()
  {
    $this->qr = false;
  }

  #[On(['closeModalToView'])]
  public function closeHistory()
  {
    $this->historial = false;
  }

  public function updatedFoto1()
  {

    $this->resetErrorBag('foto1');
    try {

      if (
        $this->isDangerousExtension($this->foto1)  ||
        ! in_array($this->foto1->getMimeType(), [
          'image/jpeg',
          'image/png',
          'image/webp',
        ], true)
      ) {
        $this->addError('foto1', 'Tipo de archivo no permitido');
        $this->reset('foto1');
        return;
      }


      $this->validate(
        [
          'foto1' => 'required|file|max:20000|mimetypes:image/jpeg,image/png',

        ],
        ['foto1.max' => "Menor a 20mb"]


      );
    } catch (\Illuminate\Validation\ValidationException $e) {
      unlink($this->foto1->getRealPath());
      $this->addError('foto1', $e->validator->errors()->first('foto1'));
      $this->reset('foto1');
    }
  }



  protected function validateFoto(string $field): void
  {
    $this->resetErrorBag($field);

    try {
      $file = $this->{$field};

      if (! $file) {
        return;
      }

      if (
        $this->isDangerousExtension($file) ||
        ! in_array($file->getMimeType(), [
          'image/jpeg',
          'image/png',
          'image/webp',
        ], true)
      ) {
        $this->addError($field, 'Tipo de archivo no permitido');
        $this->reset($field);
        return;
      }

      $this->validate(
        [
          $field => 'file|max:20000|mimetypes:image/jpeg,image/png,image/webp',
        ],
        [
          "$field.max" => 'Menor a 20mb',
        ]
      );
    } catch (\Illuminate\Validation\ValidationException $e) {
      if ($this->{$field}) {
        @unlink($this->{$field}->getRealPath());
      }

      $this->addError($field, $e->validator->errors()->first($field));
      $this->reset($field);
    }
  }



  public function updatedFoto2()
  {
    $this->validateFoto('foto2');
  }
  public function updatedFoto3()
  {
    $this->validateFoto('foto3');
  }
  public function updatedFoto4()
  {
    $this->validateFoto('foto4');
  }

  public function updatedFoto5()
  {
    $this->validateFoto('foto5');
  }
  public function updatedFoto6()
  {
    $this->validateFoto('foto6');
  }
  public function updatedFoto7()
  {
    $this->validateFoto('foto7');
  }
  public function updatedFoto8()
  {
    $this->validateFoto('foto8');
  }


  protected function messages()
  {
    return [
      "comitente_id.required" => "Elija comitente.",
      "tipo_bien_id.required" => "Elija tipo.",
      'formData.*.required' => 'Este campo es obligatorio.',
      "titulo.required" => "Ingrese titulo",
      "estado.required" => "Elija estado ",
      "fraccion_min" => "Ingrese monto ",
      "valuacion" => "Ingrese monto ",
      "base" => "Ingrese base ",
      "foto1.required" => "Elija foto",
      "foto1.max" => "Menor a 13mb",
      'foto1.image' => "Elija una foto",
      "foto2.max" => "Menor a 13mb",
      'foto2.image' => "Elija una foto",
      "foto3.max" => "Menor a 13mb",
      'foto3.image' => "Elija una foto",
      "foto4.max" => "Menor a 13mb",
      'foto4.image' => "Elija una foto",
      'moneda_id.required' => "Elija moneda",
    ];
  }




  public function updatedTipoBienId($value, $key)
  {
    $tipo = TiposBien::find($value);

    // Obtener las características asociadas con el campo 'requerido' desde la tabla pivote
    $this->caracteristicas = $tipo ? $tipo->caracteristicas()->get() : [];

    // Resetear formData y reglas de validación
    $this->formData = [];

    $this->reset("rules");


    if ($this->lote->tipo_bien_id == $this->tipo_bien_id) {
      foreach ($this->caracteristicas as $index => $caracteristica) {
        $this->formData[$caracteristica->id] = '';


        if ($this->lote) {
          $valorCaracteristica = $this->lote->valoresCaracteristicas()
            ->where('caracteristica_id', $caracteristica->id)
            ->first();
          if ($valorCaracteristica) {
            $this->formData[$caracteristica->id] = $valorCaracteristica->valor;
          }
        }


        $model = 'formData.' . $caracteristica->id;

        $this->rules[$model] = $caracteristica->pivot->requerido ? 'required' : 'nullable';
      }
    } else {



      // Inicializar formData y configurar reglas de validación para características
      foreach ($this->caracteristicas as $caracteristica) {
        $model = 'formData.' . $caracteristica->id;
        $this->formData[$caracteristica->id] = '';

        // Añadir reglas según si es requerido
        $this->rules[$model] = $caracteristica->pivot->requerido ? 'required' : 'nullable';

        // // Ajustar reglas según el tipo de input
        // if ($caracteristica->tipo === 'number') {
        //   $this->rules[$model] .= '|numeric';
        // } elseif ($caracteristica->tipo === 'text') {
        //   $this->rules[$model] .= '|string';
        // }
        // Añadir más tipos según sea necesario (email, date, etc.)
      }
      // info(["Ellllllllllllllsssssssssssssssssssssssssss" => $this->caracteristicas->toArray()]);
    }
  }






  public function mount()
  {

    $this->estados = array_map(function ($estado) {
      return [
        'value' => $estado,
        'label' => LotesEstados::getLabel($estado),
      ];
    }, LotesEstados::all());


    $this->tipos = TiposBien::orderBy("nombre")->get();
    $this->monedas = Moneda::orderBy("titulo")->get();

    if ($this->method == "delete") {
      $this->lote = Lote::find($this->id);
      $this->id = $this->lote->id;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->lote = Lote::find($this->id);
      $this->destacado = $this->lote->destacado;
      $this->comitente_id =  $this->lote->comitente_id;


      $alias = $this->lote->comitente->alias?->nombre ?? '';

      $nombreCompleto = $this->lote->comitente->nombre . ' ' . $this->lote->comitente->apellido;

      $this->comitente = $alias ? $alias . ' - ' . $nombreCompleto : $nombreCompleto;


      $this->subasta_id =  $this->lote->ultimoContrato?->subasta_id;
      $this->moneda_id =  $this->lote->ultimoConLote?->moneda_id;
      $this->base =  (int)$this->lote->ultimoConLote?->precio_base;



      $this->contrato_id =  $this->lote->ultimo_contrato;
      $this->descripcion =  $this->lote->descripcion;
      $this->desc_extra =  $this->lote->desc_extra;
      $this->valuacion = (int)$this->lote->valuacion;
      $this->venta_directa =  $this->lote->venta_directa;
      $this->precio_venta_directa =  $this->lote->precio_venta_directa;
      $this->estado =  $this->lote->estado;
      $this->titulo =  $this->lote->titulo;
      $this->fraccion_min =  $this->lote->fraccion_min ?? ($this->base * 0.1);

      $this->foto1 =  $this->lote->foto1;
      $this->foto2 =  $this->lote->foto2;
      $this->foto3 =  $this->lote->foto3;
      $this->foto4 =  $this->lote->foto4;
      $this->foto5 =  $this->lote->foto5;
      $this->foto6 =  $this->lote->foto6;
      $this->foto7 =  $this->lote->foto7;
      $this->foto8 =  $this->lote->foto8;

      $this->tipo_bien_id =  $this->lote->tipo_bien_id;
      if ($this->tipo_bien_id) {
        $tipo = TiposBien::find($this->tipo_bien_id);
        $this->caracteristicas = $tipo ? $tipo->caracteristicas()->get() : [];

        $this->formData = [];
        foreach ($this->caracteristicas as $caracteristica) {
          $this->formData[$caracteristica->id] = '';

          // Buscar el valor de la característica en valores_cataracteristicas
          if ($this->lote) {
            $valorCaracteristica = $this->lote->valoresCaracteristicas()
              ->where('caracteristica_id', $caracteristica->id)
              ->first();
            if ($valorCaracteristica) {
              $this->formData[$caracteristica->id] = $valorCaracteristica->valor;
            }
          }

          // Configurar reglas de validación
          $model = 'formData.' . $caracteristica->id;
          $this->rules[$model] = $caracteristica->pivot->requerido ? 'required' : 'nullable';

          // if ($caracteristica->tipo === 'number') {
          //   $this->rules[$model] .= '|numeric';
          // } elseif ($caracteristica->tipo === 'text') {
          //   $this->rules[$model] .= '|string';
          // }
          // Añadir más tipos según sea necesario
        }
      }


      if ($this->method == "update") {
        $this->title = "Editar";
        $this->bg = "background-color: rgb(234 88 12)";
        $this->btnText = "Guardar";
      } else {
        $this->title = "Ver";
        $this->bg =  "background-color: rgb(31, 83, 44)";
      }
    }
  }


  public function validateImages()
  {
    if (!Storage::disk('public')->exists("imagenes/lotes/thumbnail/" . $this->foto1) && !$this->foto1 instanceof UploadedFile) {
      $this->addError('foto1', 'Elija foto');
      return false;
    }

    if ($this->foto2 && !Storage::disk('public')->exists("imagenes/lotes/thumbnail/" . $this->foto2) && !$this->foto2 instanceof UploadedFile) {
      $this->addError('foto2', 'Elija foto');
      return false;
    }

    if ($this->foto3 && !Storage::disk('public')->exists("imagenes/lotes/thumbnail/" . $this->foto3) && !$this->foto3 instanceof UploadedFile) {
      $this->addError('foto3', 'Elija foto');
      return false;
    }

    if ($this->foto4 && !Storage::disk('public')->exists("imagenes/lotes/thumbnail/" . $this->foto4) && !$this->foto4 instanceof UploadedFile) {
      $this->addError('foto4', 'Elija foto');
      return false;
    }

    if ($this->foto5 && !Storage::disk('public')->exists("imagenes/lotes/thumbnail/" . $this->foto5) && !$this->foto5 instanceof UploadedFile) {
      $this->addError('foto5', 'Elija foto');
      return false;
    }

    if ($this->foto6 && !Storage::disk('public')->exists("imagenes/lotes/thumbnail/" . $this->foto6) && !$this->foto6 instanceof UploadedFile) {
      $this->addError('foto6', 'Elija foto');
      return false;
    }
    if ($this->foto7 && !Storage::disk('public')->exists("imagenes/lotes/thumbnail/" . $this->foto7) && !$this->foto7 instanceof UploadedFile) {
      $this->addError('foto7', 'Elija foto');
      return false;
    }

    if ($this->foto8 && !Storage::disk('public')->exists("imagenes/lotes/thumbnail/" . $this->foto8) && !$this->foto8 instanceof UploadedFile) {
      $this->addError('foto8', 'Elija foto');
      return false;
    }

    return true;
  }


  protected function storeSafeMp3(
    UploadedFile $file,
    string $path,
    int $maxSizeMb = 15
  ): string {
    $ext  = strtolower($file->getClientOriginalExtension());
    $mime = $file->getMimeType();

    // 🔐 Solo mp3
    if ($ext !== 'mp3' || $mime !== 'audio/mpeg') {

      throw new \RuntimeException('Solo se permiten archivos MP3');
    }

    if ($file->getSize() > ($maxSizeMb * 1024 * 1024)) {

      throw new \RuntimeException('El archivo supera el tamaño permitido');
    }

    // Nombre seguro
    $filename = uniqid('audio_') . '.mp3';

    return $file->storeAs($path, $filename, 'public');
  }



  public function update()
  {

    if (!$this->lote) {
      $this->dispatch('loteNotExits');
    } else {
      if (!$this->foto1) {
        $this->validate(["foto1" => 'required']);
      }

      if (!$this->validateImages()) {
        return;
      }

      $this->validate();

      $this->imgStoreAndSave();

      DB::transaction(function () {
        $caracteristicaIds = $this->caracteristicas->pluck('id')->toArray();
        $formCaracteristicaIds = array_keys($this->formData);

        // Procesar las características enviadas en el formulario
        foreach ($caracteristicaIds as $caracteristicaId) {
          // Obtener el valor del formData para esta característica, o null si no existe
          $valor = $this->formData[$caracteristicaId] ?? null;

          // Asegurarse de que la característica es válida
          if (in_array($caracteristicaId, $caracteristicaIds)) {
            // Buscar el registro existente para el lote_id y caracteristica_id
            $existingRecord = ValoresCataracteristica::where('lote_id', $this->lote->id)
              ->where('caracteristica_id', $caracteristicaId)
              ->first();

            $tipo = Caracteristica::find($caracteristicaId)->tipo;

            if ($tipo == "file" && $valor instanceof UploadedFile) {
              // Si se subió un nuevo archivo, eliminar el archivo existente si lo hay
              if ($existingRecord && $existingRecord->valor) {
                Storage::disk('public')->delete('lotes/' . basename($existingRecord->valor));
              }


              try {
                $valor = $this->storeSafeMp3($valor, 'lotes', 15);
              } catch (\RuntimeException $e) {
                throw ValidationException::withMessages([
                  'formData.' . $caracteristicaId => $e->getMessage(),
                ]);
                // return;
              }

              // Generar el nombre del nuevo archivo y guardarlo
              // $filename = time() . '.' . $valor->getClientOriginalExtension();
              // $valor = $valor->storeAs("lotes", $filename, "public");
            } elseif (is_null($valor)) {
              // Si el valor es nulo, eliminar el archivo existente (si es tipo file) y establecer valor como null
              if ($tipo == "file" && $existingRecord && $existingRecord->valor) {
                Storage::disk('public')->delete('lotes/' . basename($existingRecord->valor));
              }
              $valor = null; // Establecer el valor como null para vaciar el campo
            }

            ValoresCataracteristica::updateOrCreate(
              [
                'lote_id' => $this->lote->id,
                'caracteristica_id' => $caracteristicaId,
              ],
              [
                'valor' => $valor,
              ]
            );
          }
        }

        // Eliminar registros de ValoresCataracteristica que no están en formData
        $recordsToDelete = ValoresCataracteristica::where('lote_id', $this->lote->id)
          ->whereNotIn('caracteristica_id', $formCaracteristicaIds)
          ->get();

        foreach ($recordsToDelete as $record) {
          // Si el registro es de tipo file, eliminar el archivo del almacenamiento
          $tipo = Caracteristica::find($record->caracteristica_id)->tipo;
          if ($tipo == "file" && $record->valor) {
            Storage::disk('public')->delete('lotes/' . basename($record->valor));
          }
        }

        // Eliminar los registros
        ValoresCataracteristica::where('lote_id', $this->lote->id)
          ->whereNotIn('caracteristica_id', $formCaracteristicaIds)
          ->delete();

        // Actualizar otros campos del lote si es necesario
        $this->lote->update([
          'tipo_bien_id' => $this->tipo_bien_id,
          // Otros campos aquí si es necesario, por ejemplo:
          // 'comitente_id' => $this->comitente_id,
        ]);
      });



      // dd($this->formData);
      $this->lote->valuacion = $this->valuacion;
      $this->lote->fraccion_min = $this->fraccion_min;
      $this->lote->estado = $this->estado;

      $this->lote->titulo = $this->titulo;
      $this->lote->descripcion = $this->descripcion;
      $this->lote->desc_extra = $this->desc_extra;
      $this->lote->destacado = $this->destacado;




      if ($this->lote->ultimoConLote) {

        $this->lote->ultimoConLote->moneda_id = $this->moneda_id;
        $this->lote->ultimoConLote->precio_base = $this->base;

        $this->lote->ultimoConLote?->save();
      }



      $this->lote->save();


      $this->dispatch("loteContrato");
      $this->dispatch("loteUpdated");
    }
  }


  protected function storeSafeFile(
    UploadedFile $file,
    string $path,
    array $allowedExtensions,
    array $allowedMimes,
    int $maxSizeMb = 10
  ): string {
    $ext  = strtolower($file->getClientOriginalExtension());
    $mime = $file->getMimeType();

    if (
      ! in_array($ext, $allowedExtensions, true) ||
      ! in_array($mime, $allowedMimes, true)
    ) {
      throw new \RuntimeException('Archivo no permitido');
    }

    if ($file->getSize() > ($maxSizeMb * 1024 * 1024)) {
      throw new \RuntimeException('Archivo demasiado grande');
    }

    // 🔐 nombre seguro
    $filename = uniqid('file_') . '.' . $ext;

    return $file->storeAs($path, $filename, 'public');
  }

  public function imgStoreAndSave()
  {
    $manager = new ImageManager(new Driver());
    $photos = [$this->foto1, $this->foto2, $this->foto3, $this->foto4, $this->foto5, $this->foto6, $this->foto7, $this->foto8];
    $filenames = [];
    $oldFilenames = [$this->lote->foto1, $this->lote->foto2, $this->lote->foto3, $this->lote->foto4, $this->foto5, $this->foto6, $this->foto7, $this->foto8];
    $basePathNormal = 'imagenes/lotes/normal/';
    $basePathThumbnail = 'imagenes/lotes/thumbnail/';
    $replacedFiles = []; // Almacena los nombres de archivo antiguos que serán reemplazados

    try {
      foreach ($photos as $index => $photo) {
        if ($photo instanceof UploadedFile) {
          // Process new uploaded image
          $filename = $this->processImage($manager, $photo, $index + 1, $basePathNormal, $basePathThumbnail);
          $filenames[$index] = $filename;
          // Guardar el nombre de archivo antiguo que será reemplazado
          if ($oldFilenames[$index]) {
            $replacedFiles[] = $oldFilenames[$index];
          }
        } elseif (is_null($photo) && $oldFilenames[$index]) {
          // Image was removed, set field to null and mark old file for deletion
          $filenames[$index] = null;
          $replacedFiles[] = $oldFilenames[$index];
        } else {
          // No change, keep existing filename
          $filenames[$index] = $oldFilenames[$index];
        }
      }

      // Actualizar nombres de archivo en el modelo
      foreach ($filenames as $index => $filename) {
        $this->lote->{'foto' . ($index + 1)} = $filename;
      }

      $this->lote->save();

      // Eliminar solo los archivos antiguos que fueron reemplazados o borrados
      $this->deleteOldFiles($replacedFiles, $basePathNormal, $basePathThumbnail);
    } catch (\Exception $e) {
      info('Error procesando imágenes: ' . $e->getMessage());
      throw new \Exception('No se pudieron procesar las imágenes.');
    }
  }


  private function deleteOldFiles(array $replacedFilenames, string $normalPath, string $thumbnailPath): void
  {
    foreach ($replacedFilenames as $filename) {
      if ($filename) {
        Storage::disk('public')->delete([
          $normalPath . $filename,
          $thumbnailPath . $filename,
        ]);
      }
    }
  }


  private function processImage(ImageManager $manager, UploadedFile $photo, int $index, string $normalPath, string $thumbnailPath): string
  {
    // $extension = $photo->getClientOriginalExtension();
    // $filename = uniqid("img_{$index}_") . '.' . $extension;
    $filename = uniqid("img_{$index}_") . '.png';

    // Leer la imagen una sola vez para optimizar
    $image = $manager->read($photo);

    // Procesar Normal: Máximo 1080x1080 manteniendo proporción
    // scaleDown asegura que si la imagen mide p.ej. 800x600, no la suba a 1080
    $imageNormal = clone $image;
    $imageNormal->scaleDown(width: 1080, height: 1080);

    // Procesar Miniatura: Máximo 250x250 manteniendo proporción
    $imageThumbnail = clone $image;
    $imageThumbnail->scaleDown(width: 250, height: 250);

    // Guardar imágenes usando Storage
    Storage::disk('public')->put($normalPath . $filename, (string) $imageNormal->encode());
    Storage::disk('public')->put($thumbnailPath . $filename, (string) $imageThumbnail->encode());

    return $filename;
  }



  public function deleteAudio($key)
  {
    info($this->formData[$key] ?? 'No existe');
    info($key);
    if (array_key_exists($key, $this->formData)) {
      unset($this->formData[$key]);
    }
    info($this->formData[$key] ?? 'No existe');
  }


  public function deleteImg($mod)
  {
    $this->reset($mod);
  }


  public function delete()
  {
    if (!$this->lote) {
      $this->dispatch('loteNotExits');
    } else {




      $motivo = $this->lote->puedeEliminarse();

      if ($motivo) {
        $mensajes = [
          'PUJAS'   => 'Lote tiene pujas registradas.',
          'CARRITO' => 'Lote está o estuvo en un carrito.',
          'ORDEN'   => 'Lote  asociado a una orden.',
          'CONTRATO'   => 'Lote  asociado a un contrato.',
        ];

        $this->addError('tieneDatos', $mensajes[$motivo]);
        return;
      }


      $this->deleteLoteImages($this->lote);

      $this->lote->valoresCaracteristicas()->delete();
      $this->lote->delete();
      $this->dispatch('loteDeleted');
    }
  }

  public function cerrar()
  {
    $this->dispatch("loteContrato");
    // $this->method = "";
  }



  protected function deleteLoteImages(Lote $lote): void
  {
    $paths = [
      'imagenes/lotes/normal/',
      'imagenes/lotes/thumbnail/',
    ];

    foreach (['foto1', 'foto2', 'foto3', 'foto4'] as $field) {
      if ($lote->$field) {
        foreach ($paths as $path) {
          Storage::disk('public')->delete($path . $lote->$field);
        }
      }
    }
  }



  public function render()
  {
    return view('livewire.admin.lotes.modal');
  }
}
