<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Clase que maneja la validación de los datos para el inicio de sesión de un usuario.
 * 
 * Asegura que los datos enviados en la solicitud de inicio de sesión sean válidos antes de ser procesados
 * por el controlador.
 */
class LoginRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     * 
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación para la solicitud de inicio de sesión.
     * 
     * @return array{email: string, g-recaptcha-response: string, password: string}
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    /**
     * Define los mensajes personalizados para los errores de validación.
     * 
     * @return array{email.email: string, email.required: string, g-recaptcha-response.captcha: string, g-recaptcha-response.required: string, password.required: string}
     */
    public function messages()
    {
        return [
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo debe ser una dirección válida.',
            'password.required' => 'La contraseña es obligatoria.',
            'g-recaptcha-response.required' => 'Debe completar el reCAPTCHA.',
            'g-recaptcha-response.captcha' => 'La verificación reCAPTCHA ha fallado.'
        ];
    }
}
