<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorCode extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * El código de verificación de dos factores.
     * 
     * @var string
     */
    public $twoFactorCode;

    /**
     * Crear una nueva instancia del mensaje.
     * 
     * @param mixed $twoFactorCode
     */
    public function __construct($twoFactorCode)
    {
        $this->twoFactorCode = $twoFactorCode;
    }

    /**
     * Construir el mensaje de correo.
     * 
     * @return TwoFactorCode
     */
    public function build()
    {
        return $this->subject('Código de Verificación')
        ->view('emails.twoFactor')
        ->with([
            'twoFactorCode' => $this->twoFactorCode,
        ]);
    }
}
