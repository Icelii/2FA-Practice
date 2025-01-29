<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Clase que maneja la validación de los datos de registro de un nuevo usuario.
 * 
 * Asegura que los datos enviados en la solicitud de registro sean válidos antes de ser procesados
 * por el controlador.
 */
class RegisterRequest extends FormRequest
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
     * Reglas de validación para la solicitud de registro.
     * 
     * @return array{email: string, g-recaptcha-response: string, password: string, username: string}
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:150|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    /**
     * Define los mensajes personalizados para los errores de validación.
     * 
     * @return array{email.email: string, email.required: string, email.unique: string, g-recaptcha-response.captcha: string, g-recaptcha-response.required: string, password.min: string, password.required: string, username.required: string, username.unique: string}
     */
    public function messages()
    {
        return [
            'username.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo debe ser válido.',
            'email.unique' => 'El correo ya está en uso.',
            'username.unique' => 'El nombre de usuario ya está en uso.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'g-recaptcha-response.required' => 'Debe completar el reCAPTCHA.',
            'g-recaptcha-response.captcha' => 'La verificación reCAPTCHA ha fallado.'
        ];
    }
}
