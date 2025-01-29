<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Activar cuenta de usuario.
     * Maneja la solicitud de activación de la cuenta del usuario a través de una ruta firmada.
     * Verifica que el enlace sea válido y activa la cuenta del usuario.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function activateAccount(Request $request)
    {
        $email = $request->query('email');

        if (!$request->hasValidSignature()) {
            return view('emails.error', ['message' => 'URL no valida.']);
        }
        $user = User::where('email', $email)->first();
        if (!$user) {
            return view('emails.error', ['message' => 'Usuario no encontrado.']);
        }
        $user->update([
            'email_verified_at' => Carbon::now(),
        ]);
        return view('emails.success', ['message' => 'Cuenta activada exitosamente.']);
    }
    
}
