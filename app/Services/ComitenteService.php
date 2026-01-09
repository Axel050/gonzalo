<?php

namespace App\Services;

use App\Models\Comitente;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ComitenteService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }



  public function createComitente(array $data): Comitente
  {
    info(["DARA SER" => $data]);
    // CAPA 1: Validamos que 'foto' sea realmente una imagen (mimes:jpg,png,etc)


    $rules = array_merge($this->rules(), [
      'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
    ]);

    $validator = Validator::make($data, $rules, $this->messages());

    if ($validator->fails()) {
      info('Validación fallida en Service', ['errors' => $validator->errors()]);
      throw new ValidationException($validator);
    }

    $filename = '';

    if (isset($data['foto']) && $data['foto']) {
      $manager = new ImageManager(new Driver());

      try {

        $extension = 'jpg';
        $filename = Str::random(20) . '.' . $extension;
        $destino = public_path("storage/imagenes/comitentes/");

        if (!file_exists($destino)) {
          mkdir($destino, 0755, true);
        }


        if ($data['foto'] instanceof UploadedFile) {
          $image = $manager->read($data['foto']->getRealPath());
        } else {
          $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $data['foto']);
          $image = $manager->read(base64_decode($base64Data));
        }

        $image->scale(width: 400);


        // Esto convierte el archivo a un JPG real y elimina scripts PHP ocultos.
        $image->toJpeg(80)->save($destino . $filename);
      } catch (\Exception $e) {
        info('Error procesando imagen: ' . $e->getMessage());
        // Si alguien intenta subir un PHP "disfrazado", la librería fallará aquí
        throw new \Exception("El archivo proporcionado no es una imagen válida.");
      }
    }

    $comitente = Comitente::create([
      'nombre' => $data['nombre'],
      'apellido' => $data['apellido'],
      'mail' => $data['mail'],
      'telefono' => $data['telefono'],
      'CUIT' => $data['CUIT'] ?? null,
      'domicilio' => $data['domicilio'],
      'comision' => $data['comision'] ?? 20,
      'banco' => $data['banco'] ?? null,
      'numero_cuenta' => $data['numero_cuenta'] ?? null,
      'CBU' => $data['CBU'] ?? null,
      'alias_bancario' => $data['alias_bancario'] ?? null,
      'observaciones' => $data['observaciones'] ?? null,
      // 'foto' => $filename,
    ]);

    info('Comitente creado', ['id' => $comitente->id]);

    return $comitente;
  }




  public function createComitente2(array $data): Comitente
  {


    $validator = Validator::make($data, $this->rules(), $this->messages());
    if ($validator->fails()) {
      info('Validación fallida', ['errors' => $validator->errors()]);
      throw new ValidationException($validator);
    }



    $filename = '';

    // Manejar la subida de la imagen
    if (isset($data['foto']) && $data['foto']) {
      $manager = new ImageManager(new Driver());
      $image = $manager->read($data['foto']);

      // Determinar la extensión del archivo
      $extension = 'png'; // Extensión por defecto
      if ($data['foto'] instanceof UploadedFile) {
        $extension = $data['foto']->getClientOriginalExtension();
      } elseif (is_string($data['foto']) && preg_match('/^data:image\/(\w+);base64,/', $data['foto'], $matches)) {
        $extension = $matches[1] ?? 'png';
        $data['foto'] = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $data['foto']));
        $image = $manager->read($data['foto']);
      } else {
        throw new \InvalidArgumentException('Formato de imagen no soportado.');
      }

      $filename = time() . '.' . $extension;
      $destino = public_path("storage/imagenes/comitentes/");
      $image->scale(width: 400);
      $image->save($destino . $filename);
    }


    $comitente = Comitente::create([
      'nombre' => $data['nombre'],
      'apellido' => $data['apellido'],
      'mail' => $data['mail'],
      'telefono' => $data['telefono'],
      'CUIT' => $data['CUIT'] ?? null,
      'domicilio' => $data['domicilio'],
      'comision' => $data['comision'] ?? 20,
      'banco' => $data['banco'] ?? null,
      'numero_cuenta' => $data['numero_cuenta'] ?? null,
      'CBU' => $data['CBU'] ?? null,
      'alias_bancario' => $data['alias_bancario'] ?? null,
      'observaciones' => $data['observaciones'] ?? null,
      'foto' => $filename,
    ]);

    info('Comitente creado', ['id' => $comitente->id]);

    return $comitente;
  }

  protected function rules(): array
  {
    return [
      'nombre' => 'required|string|max:255',
      'apellido' => 'required|string|max:255',
      'telefono' => 'required|string|max:20|unique:comitentes,telefono',
      'mail' => 'required|email|unique:comitentes,mail',
      'domicilio' => 'required|string|max:255',
      'CUIT' => 'required|unique:comitentes,CUIT|string|max:20',
      'comision' => 'nullable|numeric',
      'banco' => 'nullable|string|max:255',
      'numero_cuenta' => 'nullable|string|max:255',
      'CBU' => 'nullable|string|max:255',
      'alias_bancario' => 'nullable|string|max:255',
      'observaciones' => 'nullable|string',
    ];
  }

  protected function messages(): array
  {
    return [
      'nombre.required' => 'Ingrese nombre.',
      'apellido.required' => 'Ingrese apellido.',
      'mail.required' => 'Ingrese mail.',
      'mail.email' => 'Mail inválido.',
      'mail.unique' => 'Mail existente.',
      'telefono.required' => 'Ingrese teléfono.',
      'telefono.unique' => 'Teléfono existente.',
      'CUIT.unique' => 'CUIT existente.',
      'CUIT.required' => 'Ingrese CUIT.',
      'domicilio.required' => 'Ingrese domicilio.',
      'comision.numeric' => 'Comisión inválida.',
    ];
  }
}
