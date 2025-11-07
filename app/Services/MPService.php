<?php

namespace App\Services;

use App\Models\Garantia;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Payment\PaymentRefundClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;



class MPService
{

  public function __construct()
  {
    MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
  }


  public function crearPreferencia($title, $quantity, $price, $adquirente = null, $subasta = null, $lote = null, $route = null)
  {

    // info(["SUUBASTA   " => $subasta, "ADQUIRENTE " => $adquirente]);
    // info(["SUUBASTA   MP " => $route]);
    // info(["SUUBASTA   MPppppppppppppppppp " => 333]);

    $client = new PreferenceClient();

    $preference = $client->create([
      "items" => [
        [
          "title" => $title,
          "quantity" => $quantity,
          "unit_price" => $price
        ]
      ],
      "back_urls" => [
        // "success" => config('services.mercadopago.host') . "/success",
        "success" => config('services.mercadopago.host') . $route,
        "failure" => config('services.mercadopago.host') . "/failure",
        "pending" => config('services.mercadopago.host') . "/pending"
      ],
      "notification_url" => config('services.mercadopago.host') . "/api/notification",

      "external_reference" => [
        "adquire" => $adquirente,
        "subasta" => $subasta,

      ]
    ]);
    info(["preferece" => $preference]);
    info(["preferece INIIIII" => $preference->init_point]);

    return $preference;
  }

  public function crearPreferenciaOrden($adquirente, $subasta, $orden, $route = null, $conEnvio = null, $montoEnvio = null)
  {
    // si monto es negativo  ,oosea desceunto mayor que precio lote , da error MP 
    // info(["TOTAL  nnnnnn=" => (float) $orden->total_neto]);
    info("rrrrrrrrrrrrrrrrrrrrrrrr");
    $client = new PreferenceClient();
    info(["conENVIO" => $conEnvio]);
    info(["montoENVIO" => $montoEnvio]);
    $preference = $client->create([
      "items" => [
        [
          "title" => "Orden #{$orden->id} - Subasta: {$subasta->titulo}",
          "quantity" => 1,
          // "unit_price" => 1111,
          "unit_price" => (float) $orden->total_neto,
        ]
      ],
      "back_urls" => [
        // "success" => $route,
        "success" => config('services.mercadopago.host') . "/success",
        "failure" => config('services.mercadopago.host') . "/failure",
        "pending" => config('services.mercadopago.host') . "/pending"
      ],
      "notification_url" => config('services.mercadopago.host') . "/api/notification",
      "external_reference" => json_encode([
        "orden_id" => $orden->id,
        "adquirente_id" => $adquirente->id,
        "subasta_id" => $subasta->id,
        "conEnvio" => $conEnvio,
        "montoEnvio" => $montoEnvio,
      ])
    ]);

    info(["MP----adquirente " => $adquirente, "Subasta" => $subasta, "ordem" => $orden]);
    info(["MP----prefeeeee " => $preference]);
    return $preference;
  }


  public function crearDevolucion($garantiaId)
  {

    try {
      info("TRYYYYY");
      // Buscar la garantía en la base de datos
      // $garantia = Garantia::findOrFail(25);

      // info(["GARANTIAEX" => $garantia]);
      // // Verificar que la garantía tenga un payment_id y esté en estado 'pagado'
      // if (!$garantia->payment_id || $garantia->estado !== 'pagado') {
      //   info("No se puede procesar la devolución para la garantía {$garantiaId}. Estado: {$garantia->estado}, Payment ID: {$garantia->payment_id}");
      //   throw new \Exception("La garantía no está en estado pagado o no tiene un payment_id asociado.");
      // }

      // Inicializar el cliente de pagos


      $paymentClient = new PaymentClient();
      // $payment = $paymentClient->get($garantia->payment_id);
      // $payment = $paymentClient->get(120887771737);
      $payment = $paymentClient->get(121151650315);

      // Verificar que el pago esté en estado 'approved'
      if ($payment->status !== 'approved') {
        info("El pago  no está en estado 'approved'. Estado actual: {$payment->status}");
        // info("El pago {$garantia->payment_id} no está en estado 'approved'. Estado actual: {$payment->status}");
        throw new \Exception("El pago no está aprobado, no se puede procesar la devolución.");
      }


      info(["ANTEEEEE" => $payment]);


      $client = new PaymentRefundClient();
      $refund = $client->refund(121884371342, 5);



      $client = new PaymentRefundClient();
      info(["GARANTIAEXCLIENT" => $client]);
      $refund = $client->refund(120887771737, 200);

      // $refund = $client->refund(12345678901, 5);
      info(["refffounddddd" => $refund->id]);
      info(["REEFFOUNDD" => $refund]);
      // https: //www.mercadopago.com.ar/developers/es/reference/chargebacks/_payments_id_refunds/post

      // if ($payment->status !== 'approved') {
      //   info("El pago {$garantia->payment_id} no está en estado 'approved'. Estado actual: {$payment->status}");
      //   throw new \Exception("El pago no está aprobado, no se puede procesar la devolución.");
      // }





      // Actualizar el estado de la garantía
      // $garantia->estado = 'reembolsado';
      // $garantia->fecha_reembolso = now();
      // $garantia->save();

      info("Devolución procesada para garantía {$garantiaId}, payment_id:, monto: ");
      // info("Devolución procesada para garantía {$garantiaId}, payment_id: {$garantia->payment_id}, monto: {$garantia->monto}");

      return [
        'status' => 'success',
        'message' => 'Devolución procesada correctamente',
        'refund' => $refund
      ];
    } catch (\MercadoPago\Exceptions\MPApiException $e) {
      info("ErrorMP CATHCA");
      info(["ErrorMP"  =>  $e->getApiResponse()]);
      throw new \Exception("Error al procesar la devolución: {$e->getMessage()}");
    } catch (\Exception $e) {
      // Capturar otros errores
      info("Error al procesar la devolución para garantía {$garantiaId}: {$e->getMessage()}");
      throw new \Exception("Error al procesar la devolución: {$e->getMessage()}");
    }
  }
}
