<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class BrevoService
{
  protected string $apiKey;
  protected string $baseUrl = 'https://api.brevo.com/v3';


  public function __construct()
  {


    // info(["keyyyy" => config('services.brevo.key')]);
    $this->apiKey = config('services.brevo.key');
  }

  /**
   * Create or update a contact in Brevo.
   *
   * @param string $email
   * @param array $attributes
   * @param array $listIds
   * @return bool|array
   */

  public function createContact(string $email, array $attributes = [], array $listIds = [])
  {
    $response = Http::withHeaders([
      'api-key' => $this->apiKey,
      'accept' => 'application/json',
      'content-type' => 'application/json',
    ])->post("{$this->baseUrl}/contacts", [
      'email' => $email,
      'attributes' => $attributes,
      'listIds' => array_map('intval', $listIds), // 🔥 FIX
      'updateEnabled' => true,
    ]);

    /** @var \Illuminate\Http\Client\Response $response */
    // info("brevo_sync", [
    //   'status' => $response->status(),
    //   'body' => $response->json(),
    // ]);

    if ($response->successful()) {
      return [
        'success' => true,
        'data' => $response->json(),
      ];
    }

    return [
      'success' => false,
      'message' => $response->json('message')
        ?? 'Error desconocido en Brevo.',
      'status' => $response->status(),
    ];
  }

  public function createContact22(string $email, array $attributes = [], array $listIds = [])
  {

    $response = Http::withHeaders([
      'api-key' => $this->apiKey,
      'accept' => 'application/json',
      'content-type' => 'application/json',
    ])->post("{$this->baseUrl}/contacts", [
      'email' => $email,
      'attributes' => $attributes,
      'listIds' => $listIds,
      'updateEnabled' => true,
    ]);


    info("sync", ["response" => $response]);


    /** @var \Illuminate\Http\Client\Response $response */
    if ($response->successful()) {
      return $response->json();
    }

    return [
      'success' => false,
      'message' => $response->json('message')
        ?? 'Error desconocido en Brevo.',
      'status' => $response->status(),
    ];
  }

  /**
   * Delete a contact from Brevo.
   *
   * @param string $email
   * @return bool
   */
  public function deleteContact(string $email)
  {
    if (empty($email)) {
      return false;
    }

    $response = Http::withHeaders([
      'api-key' => $this->apiKey,
      'accept' => 'application/json',
    ])->delete("{$this->baseUrl}/contacts/" . urlencode($email));

    /** @var \Illuminate\Http\Client\Response $response */
    if ($response->successful()) {
      return [
        'success' => true,
        'message' => 'Contacto eliminado correctamente.',
      ];
    }

    return [
      'success' => false,
      'message' => $response->json('message')
        ?? 'Error desconocido en Brevo.',
      'status' => $response->status(),
    ];
  }
}
