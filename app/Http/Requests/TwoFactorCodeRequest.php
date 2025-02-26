<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TwoFactorCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'verification_code' => 'required|alpha_num|size:6'
        ];
    }

    public function messages()
    {
        return [
            'verification_code.required' => 'El código de verificación es obligatorio.',
            'verification_code.alpha_num' => 'El código de verificación debe ser un alpanúmerico.',
            'verification_code.size' => 'El código de verificación debe tener exactamente 6 dígitos.',
        ];
    }
}
