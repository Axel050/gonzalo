<?php

namespace App\Services;

use App\Models\Adquirente;
use App\Models\User;
use App\Rules\RecaptchaRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AdquirenteService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }
  public function createAdquirente(array $data): Adquirente
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
      $destino = public_path("storage/imagenes/adquirentes/");
      $image->scale(width: 400);
      $image->save($destino . $filename);
    }


    $user = User::create([
      'name' => $data['nombre'],
      'email' => $data['mail'],
      "password" => bcrypt($data['password']),
    ]);


    if ($user) {

      $adquirente = Adquirente::create([
        'nombre' => $data['nombre'],
        'apellido' => $data['apellido'],
        'telefono' => $data['telefono'],
        // 'CUIT' => $data['CUIT'] ?? null,
        'comision' => 20,
        // 'domicilio' => $data['domicilio'],
        // 'banco' => $data['banco'] ?? null,
        // 'numero_cuenta' => $data['numero_cuenta'] ?? null,
        // 'CBU' => $data['CBU'] ?? null,
        // 'alias_bancario' => $data['alias_bancario'] ?? null,
        // 'foto' => $filename,
        'user_id' => $user->id,
        // "condicion_iva_id" => $data['condicion_iva_id'],
        "estado_id" =>  2,
      ]);
    }



    if ($adquirente) {
      $user->assignRole("adquirente");
    }

    info('Adquirente creado', ['id' => $adquirente->id]);

    return $adquirente;
  }



  protected function rules()
  {

    return  [
      'nombre' => 'required',
      'apellido' => 'required',
      'telefono' => 'required|unique:adquirentes,telefono',
      'mail' => 'required|email|unique:users,email',
      // 'CUIT' => 'unique:adquirentes,CUIT',
      'password' => 'required|string|confirmed|min:8',
      // 'g-recaptcha-response' => ['required', new RecaptchaRule()],

    ];
  }


  protected function messages()
  {
    return [
      "nombre.required" => "Ingrese nombre.",
      "apellido.required" => "Ingrese  apellido.",
      "telefono.required" => "Ingrese  telefono.",
      "telefono.unique" => "Telefono existente.",
      "CUIT.required" => "Ingrese  CUIT.",
      "CUIT.unique" => "CUIT existente.",
      "condicion_iva_id.required" => "Elija condicion.",
      "estado_id.required" => "Elija estado.",
      "mail.required" => "Ingrese  mail.",
      "mail.email" => "Mail invalido.",
      "mail.unique" => "Mail existente.",
      "password.confirmed" => "Confirme contraseña.",
      "password.required" => "Ingrese contraseña.",
      "password.min" => "Minimo 8 caracteres.",
    ];
  }
}
