<?php

namespace App\Http\Controllers;

use App\Enums\CarritoLoteEstados;
use App\Enums\LotesEstados;
use App\Enums\OrdenesEstados;
use App\Livewire\LotesActivos;
use App\Models\Adquirente;
use App\Models\CarritoLote;
use App\Models\Garantia;
use App\Models\Lote;
use App\Models\Orden;
use App\Models\Subasta;
use App\Services\AdquirenteService;
use App\Services\AdquirenteServiceService;
use App\Services\SubastaService;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Livewire\Livewire;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Payment\PaymentRefundClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Invoice\Payment;

class MPController extends Controller
{
  protected $adquirenteService;

  public function __construct(AdquirenteService $adquirenteService)
  {
    $this->adquirenteService = $adquirenteService;
  }

  /**
   * Display a listing of the resource.
   */
  public function notification(Request $request)
  {
    info("📩 Notificación recibida:22222222222222222222222222222222222222 ");
    $data = $request->all();
    info("📩 Notificación recibida: ", $data);

    if (!isset($data['topic']) || $data['topic'] !== 'payment' || !isset($data['id'])) {
      return response('Ignored', 200);
    }

    $paymentId = $data['id'];

    MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
    $paymentClient = new PaymentClient();
    $payment = $paymentClient->get($paymentId);

    // info(["✅ Payment info" => $payment]);

    $externalRef = json_decode($payment->external_reference ?? '{}', true);

    // Detectamos qué tipo de pago es
    if (isset($externalRef['adquire']) && isset($externalRef['subasta']) && !isset($externalRef['orden_id'])) {
      $this->procesarGarantia($payment, $externalRef);
    } elseif (isset($externalRef['orden_id'])) {
      $this->procesarOrden($payment, $externalRef);
    } else {
      info("⚠️ External reference sin tipo definido: ", $externalRef);
    }

    return response('OK', 200);
  }

  private function procesarGarantia($payment, $externalRef)
  {
    $adquirenteId = $externalRef['adquire'] ?? null;
    $subastaId = $externalRef['subasta'] ?? null;
    $montoPago = $payment->transaction_amount ?? 0;

    if (!$adquirenteId || !$subastaId) {
      info("⚠️ External reference incompleto para garantía");
      return;
    }

    $garantia = Garantia::where('adquirente_id', $adquirenteId)
      ->where('subasta_id', $subastaId)
      ->first();

    if (!$garantia) {
      if (in_array($payment->status, ['pending', 'in_process', 'approved'])) {
        $garantia = new Garantia([
          'adquirente_id' => $adquirenteId,
          'subasta_id' => $subastaId,
          'monto' => $montoPago,
          'estado' => $this->determinarEstado($payment->status),
          'fecha' => now(),
          'payment_id' => $payment->id,
        ]);
        $garantia->save();
        info("💰 Nueva garantía creada (adq: $adquirenteId, sub: $subastaId)");
      }
    } else {
      $nuevoEstado = $this->determinarEstado($payment->status, $garantia);
      if ($garantia->estado !== $nuevoEstado) {
        $garantia->update([
          'estado' => $nuevoEstado,
          'payment_id' => $garantia->payment_id ?? $payment->id,
        ]);
        info("🔄 Garantía {$garantia->id} actualizada a {$nuevoEstado}");
      }
    }
  }



  private function procesarOrden($payment, $externalRef)
  {
    $ordenId = $externalRef['orden_id'] ?? null;
    info("999999999999999999999999999999999999999999");
    if (!$ordenId) {
      info("⚠️ Sin orden_id en external_reference");
      return;
    }

    $orden = Orden::with('lotes.lote')->find($ordenId);

    if (!$orden) {
      info("❌ Orden no encontrada (ID: {$ordenId})");
      return;
    }

    // 🔹 Determinar nuevo estado de la orden según Mercado Pago
    $nuevoEstado = match ($payment->status) {
      'approved' => OrdenesEstados::PAGADA,
      'pending', 'in_process' => OrdenesEstados::PENDIENTE,
      // 'rejected', 'cancelled' => OrdenesEstados::RECHAZADA,
      default => $orden->estado,
    };

    // 🔹 Actualizar la orden
    $orden->update([
      'estado' => $nuevoEstado,
      'fecha_pago' => $nuevoEstado === OrdenesEstados::PAGADA ? now() : null,
      'payment_id' => $payment->id,
      'envio_check' => $externalRef['conEnvio'] ?? 0,
      'monto_envio' => $externalRef['montoEnvio'] ?? 0,
    ]);

    info("🧾 Orden {$orden->id} actualizada a estado {$nuevoEstado}");

    // 🔹 Si la orden fue pagada, marcar los lotes como "pagados"
    if ($nuevoEstado === OrdenesEstados::PAGADA) {
      foreach ($orden->lotes as $ordenLote) {
        $lote = $ordenLote->lote;

        if ($lote && $lote->estado !== LotesEstados::PAGADO) {
          $lote->estado = LotesEstados::PAGADO;
          $lote->save();

          $carritoLote = CarritoLote::where('lote_id', $lote->id)
            ->whereHas('carrito', fn($q) => $q->where('adquirente_id', $orden->adquirente_id))
            ->where('estado', CarritoLoteEstados::EN_ORDEN) // Asumiendo que está en 'en_orden' antes del pago
            ->first();

          if ($carritoLote) {
            $carritoLote->update(['estado' => CarritoLoteEstados::PAGADO]); // Ajusta 'pagado' al estado deseado (ej. enum o string)
            info("✅ CarritoLote ID {$carritoLote->id} actualizado a 'pagado' para lote ID {$lote->id} (Orden #{$orden->id})");
          } else {
            info("⚠️ No se encontró CarritoLote para lote ID {$lote->id} y adquirente ID {$orden->adquirente_id}");
          }


          info("✅ Lote ID {$lote->id} marcado como 'PAGADO' (Orden #{$orden->id})");
        }
      }
      // 🔹 Enviar el mail al adquirente
      // $email = $orden->adquirente->user->email ?? null;

      // if ($email) {
      //   Mail::to($email)->queue(new OrdenPagadaMail($orden));
      //   info("📧 Email de confirmación enviado a {$email} (Orden #{$orden->id})");
      // }


      //       Mail::to($this->contrato->comitente?->mail)->send(new ContratoEmail($data)); ////ASI USO EN ONTRATOS VER MEJORAR CON COLAS CREO 
    }

    // 🔸 Si el pago fue rechazado, podés revertir el estado de los lotes
    if ($nuevoEstado === OrdenesEstados::RECHAZADA) {
      foreach ($orden->lotes as $ordenLote) {
        $lote = $ordenLote->lote;
        if ($lote && $lote->estado === LotesEstados::VENDIDO) {
          $lote->estado = LotesEstados::STANDBY; // o DISPONIBLE si querés reactivarlo
          $lote->save();

          info("🔄 Lote ID {$lote->id} devuelto a 'STANDBY' por rechazo de pago");
        }
      }
    }
  }


  private function procesarOrden33($payment, $externalRef)
  {
    $ordenId = $externalRef['orden_id'] ?? null;

    if (!$ordenId) {
      info("⚠️ Sin orden_id en external_reference");
      return;
    }

    $orden = Orden::with('lotes.lote')->find($ordenId);

    if (!$orden) {
      info("❌ Orden no encontrada (ID: {$ordenId})");
      return;
    }


    $nuevoEstado = match ($payment->status) {
      'approved' => OrdenesEstados::PAGADA,
      'pending', 'in_process' => OrdenesEstados::PENDIENTE,
      'rejected', 'cancelled' => OrdenesEstados::RECHAZADA,
      default => $orden->estado,
    };

    $orden->update([
      'estado' => $nuevoEstado,
      'fecha_pago' => $nuevoEstado === 'pagada' ? now() : null,
      'payment_id' => $payment->id,
    ]);

    info("🧾 Orden {$orden->id} actualizada a estado {$nuevoEstado}");

    // 🔹 Si la orden fue pagada, marcamos los lotes como "pagados"
    if ($nuevoEstado === 'pagada') {
      foreach ($orden->lotes as $ordenLote) {
        $lote = $ordenLote->lote;

        if ($lote && $lote->estado !== 'pagado') {
          $lote->estado = 'pagado';
          $lote->save();

          info("✅ Lote ID {$lote->id} marcado como 'pagado' (Orden #{$orden->id})");
        }
      }
    }

    // 🔸 Si el pago fue rechazado, podrías revertir el estado si querés:
    if ($nuevoEstado === 'rechazada') {
      foreach ($orden->lotes as $ordenLote) {
        $lote = $ordenLote->lote;
        if ($lote && $lote->estado === 'vendido') {
          $lote->estado = 'pendiente_pago';
          $lote->save();
          info("🔄 Lote ID {$lote->id} devuelto a 'pendiente_pago' por rechazo de pago");
        }
      }
    }
  }


  private function procesarOrden2($payment, $externalRef)
  {
    $ordenId = $externalRef['orden_id'] ?? null;

    if (!$ordenId) {
      info("⚠️ Sin orden_id en external_reference");
      return;
    }

    $orden = Orden::find($ordenId);

    if (!$orden) {
      info("❌ Orden no encontrada (ID: {$ordenId})");
      return;
    }

    $nuevoEstado = match ($payment->status) {
      'approved' => 'pagada',
      'pending', 'in_process' => 'pendiente',
      'rejected', 'cancelled' => 'rechazada',
      default => $orden->estado,
    };

    $orden->update([
      'estado' => $nuevoEstado,
      // 'fecha_pago' => $nuevoEstado === 'pagada' ? now() : null,
      // 'payment_id' => $payment->id,
    ]);

    info("🧾 Orden {$orden->id} actualizada a estado {$nuevoEstado}");
  }


  public function notificatio4444n(Request $request)
  {
    info("zzzzzzzzzzzzzzzzzzzzzzzzzz - Notificación recibida: ");
    $data = $request->all();
    info("GGGOOONNN - Notificación recibida: ", $data);

    if (isset($data['topic']) && $data['topic'] === 'payment' && isset($data['id'])) {
      $paymentId = $data['id'];

      MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
      $paymentClient = new PaymentClient();

      $payment = $paymentClient->get($paymentId);


      info(["payyyyy" => $payment]);

      $externalRef = json_decode($payment->external_reference ?? '{"adquire":1,"subasta":6}', true);
      $adquirenteId = $externalRef['adquire'] ?? 1;
      $subastaId = $externalRef['subasta'] ?? 6;
      $montoPago = $payment->transaction_amount ?? 200;

      // Buscar la garantía existente
      $garantia = Garantia::where('adquirente_id', $adquirenteId)
        ->where('subasta_id', $subastaId)
        ->first();

      if (!$garantia) {
        // Crear solo si el estado permite (no rejected/cancelled)
        if (in_array($payment->status, ['pending', 'in_process', 'approved'])) {
          $garantia = new Garantia();
          $garantia->adquirente_id = $adquirenteId;
          $garantia->subasta_id = $subastaId;
          $garantia->monto = $montoPago;
          $garantia->estado = $this->determinarEstado($payment->status);
          $garantia->fecha = now();
          $garantia->payment_id = $paymentId;
          $garantia->save();
          info("Nueva garantía creada para adquirente_id: {$adquirenteId}, subasta_id: {$subastaId}, payment_id: {$paymentId}, estado: {$garantia->estado}");
        } else {
          info("No se crea garantía para payment_id: {$paymentId} con estado: {$payment->status}");
        }
      } else {
        // Actualizar estado si existe y el estado cambia
        $nuevoEstado = $this->determinarEstado($payment->status, $garantia);
        if ($garantia->estado !== $nuevoEstado) {
          $garantia->estado = $nuevoEstado;
          if (!$garantia->payment_id) {
            $garantia->payment_id = $paymentId;
          }
          $garantia->save();
          info("Estado de garantía {$garantia->id} actualizado a '{$nuevoEstado}' para payment_id: {$paymentId}");
        }
      }
    }

    return response('OK', 200);
  }

  private function determinarEstado($status, $garantia = null)
  {
    return match ($status) {
      'approved' => 'pagado',
      'pending', 'in_process' => 'pendiente',
      'rejected', 'cancelled' => 'rechazado',
      default => $garantia ? $garantia->estado : 'pendiente',
    };
  }




  public function crearDevolucion($garantiaId)
  {
    try {
      // Buscar la garantía en la base de datos
      $garantia = Garantia::findOrFail($garantiaId);

      // Verificar que la garantía tenga un payment_id y esté en estado 'pagado'
      if (!$garantia->payment_id || $garantia->estado !== 'pagado') {
        info("No se puede procesar la devolución para la garantía {$garantiaId}. Estado: {$garantia->estado}, Payment ID: {$garantia->payment_id}");
        throw new \Exception("La garantía no está en estado pagado o no tiene un payment_id asociado.");
      }

      // Inicializar el cliente de pagos
      MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
      $client = new PaymentRefundClient();
      // $refund = $client->refund(12345678901, 5);
      $refund = $client->refund(121366112984, 5);

      info(["refffounddddd" => $refund->id]);
      info(["REEFFOUNDD" => $refund]);
      // https: //www.mercadopago.com.ar/developers/es/reference/chargebacks/_payments_id_refunds/post

      // if ($payment->status !== 'approved') {
      //   info("El pago {$garantia->payment_id} no está en estado 'approved'. Estado actual: {$payment->status}");
      //   throw new \Exception("El pago no está aprobado, no se puede procesar la devolución.");
      // }




      // Actualizar el estado de la garantía
      $garantia->estado = 'reembolsado';
      $garantia->fecha_reembolso = now();
      $garantia->save();

      info("Devolución procesada para garantía {$garantiaId}, payment_id: {$garantia->payment_id}, monto: {$garantia->monto}");

      return [
        'status' => 'success',
        'message' => 'Devolución procesada correctamente',
        'refund' => $refund
      ];
    } catch (\Exception $e) {
      info("Error al procesar la devolución para garantía {$garantiaId}: {$e->getMessage()}");
      throw new \Exception("Error al procesar la devolución: {$e->getMessage()}");
    }
  }






  public function notification2(Request $request)
  {
    $data = $request->all();
    info("Notificación MP POST recibida: ", $data);

    if (isset($data['topic']) && $data['topic'] === 'payment' && isset($data['id'])) {
      $paymentId = $data['id'];

      // Consultar el estado del pago usando la API de Mercado Pago
      // $paymentClient = new \MercadoPago\Client\Payment\PaymentClient();
      info("xxxxxxxxxxxxxxx");
      info(["payxxx" => $paymentId]);
      // $paymentClient = new \MercadoPago\Client\Payment\PaymentClient();

      MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));


      $paymentClient = new PaymentClient();


      // $paymentClient = new \MercadoPago\Client\Payment\PaymentClient();
      $payment = $paymentClient->get($paymentId);
      info(["PAYNEBTEzzzzzzzzzzzz"]);
      // $payment = $paymentClient->get(121123506839);

      info(["PAYNEBTE" => $payment]);
      info(["PAYNEBTE Status" => $payment->status]);
      info(["PAYNEBTE transaction_amount" => $payment->transaction_amount]);
      if ($payment->status === 'approved') {
        // Obtener la external_reference de la preferencia o del pago
        $externalRef = json_decode($payment->external_reference ?? '{"adquire":0,"subasta":0}', true);


        $garantia = Garantia::where('adquirente_id', $externalRef['adquire'])
          ->where('subasta_id', $externalRef['subasta'])
          ->first();
        // $garantia = Garantia::where('adquirente_id', $externalRef['adquire'])
        //   ->where('subasta_id', $externalRef['subasta'])
        //   ->first();

        if (!$garantia) {
          $garantia = Garantia::create([
            "adquirente_id" => $externalRef['adquire'],
            "subasta_id" => $externalRef['subasta'],
            "monto" => $payment->transaction_amount,
            "fecha" =>  now()->format('Y-m-d'),
            "estado" => "pagado",
            "payment_id" =>  $paymentId,
          ]);
        } else {
          $garantia->estado = 'pagado';
          $garantia->payment_id = $paymentId;
          $garantia->monto = $payment->transaction_amount;
          $garantia->save();
        }



        if ($garantia) {
          info(["garantia" => $garantia]);
        }
        //   $garantia->estado = 'pagado'; // O el estado que uses
        //   $garantia->payment_id = $paymentId;
        //   $garantia->save();

        //   info("Depósito {$garantia->id} actualizado a 'pagado' con payment_id: {$paymentId}");
        // } else {
        //   info("No se encontró depósito para external_reference: " . json_encode($externalRef));
        // }
      } else {
        info("Pago {$paymentId} no aprobado, estado: " . $payment->status);
      }
    }

    return response('OK', 200);
  }



  public function index() {}

  /**
   * Show the form for creating a new resource.
   */
  public function perfil()
  {
    $user  = auth()->user();
    // $adquirente = Adquirente::where("user_id", $user->id)->first();
    $adquirente = Adquirente::where("user_id", $user->id)->first();
    // if (auth()->user()->hasPermissionTo('adquirente-logged')) {
    return view('perfil', compact(["user", "adquirente"]));
    // }

  }

  public function create()
  {
    return view('adquirente');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    info('Inicio de store');

    // dd("ásssss");
    try {
      $adquirente = $this->adquirenteService->createAdquirente($request->all());
      return response()->json([
        'message' => 'adquirente creado con éxito',
        'adquirente' => $adquirente,
      ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json([
        'message' => 'Errores de validación',
        'errors' => $e->errors(),
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Ocurrió un error',
        'error' => $e->getMessage(),
      ], 500);
    }
  }


  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }

  public function lotes()
  {
    $lotes = Lote::limit(3)->get();

    return view("lotes", compact("lotes"));
  }

  public function loted(string $id)
  {
    $lote = Lote::find($id);
    return view("detail", compact("lote"));
  }


  public function getLotes(Subasta $subasta)
  {
    return view("lotes-activos", compact("subasta"));
  }


  public function getLotesActivos(Subasta $subasta)
  {
    info("FIRST");
    if (!$subasta->isActiva()) {
      info("IF");
      return response()->json(['error' => 'Subasta no activa'], 403);
    }
    info("SECOND");

    $lotes = app(SubastaService::class)->getLotesActivos($subasta)->toArray();
    // $lotes = $subasta->lotesActivos()->get()->map(function ($lote) use ($subasta) {
    //   return [
    //     'id' => $lote->id,
    //     'titulo' => $lote->titulo,
    //     'precio_base' => $lote->pivot->precio_base,
    //     'puja_actual' => $lote->getPujaFinal()?->monto,
    //     'tiempo_post_subasta_fin' => $lote->pivot->tiempo_post_subasta_fin,
    //     'estado' => $lote->isActivoEnSubasta($subasta->id) ? 'activo' : 'inactivo',
    //   ];
    // });

    return response()->json($lotes);
  }
}
