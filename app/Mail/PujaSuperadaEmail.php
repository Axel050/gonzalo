<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class PujaSuperadaEmail extends Mailable
{
  use Queueable, SerializesModels;

  public $data;

  /**
   * Create a new message instance.
   */
  public function __construct($data)
  {
    $this->data = $data;
    // info(["data mail " => $data]);
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    return new Envelope(
      // from: 'info@casablanca.ar',
      from: new Address('info@casablanca.ar', 'Casablanca'),
      subject: 'Puja superada',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.puja-superada',
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array<int, \Illuminate\Mail\Mailables\Attachment>
   */
  public function attachments(): array
  {
    return [];
  }
}
