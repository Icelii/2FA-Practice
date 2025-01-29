<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Clase para el envío de correos de activación de la cuenta.
 */

class Activation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * URL de activación.
     * 
     * @var string
     */
    public $url;

    /**
     * Crea una nueva instancia del correo.
     *
     * @param string $url URL para activar la cuenta.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Define el asunto del correo.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Activar cuenta',
        );
    }

    /**
     * Define el contenido del correo.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.activationAccount',
        );
    }

    /**
     * Obtiene los archivos adjuntos del correo.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    /**
     * Construye el correo y le pasa la URL de activación.
     * 
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.activationAccount')
            ->with([
                'url' => $this->url,
            ]);
    }
}
