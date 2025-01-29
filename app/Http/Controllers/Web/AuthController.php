<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\TwoFactorCode;
use App\Models\User;
use Illuminate\Support\Facades\Log; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

/**
 * Controlador para operaciones relacionadas con los usuarios.
 * Gestiona el registro, inicio de sesión y activación de cuentas de usuario.
 */

class AuthController extends Controller
{
    /**
     * Mostrar formulario de registro.
     * Retorna la vista que contine el formulario de registro 
     * para los nuevos usuarios.
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function registerForm()
    {
        return view('auth.register');
    }

    /**
     * Mostrar formulario de inicio de sesión.
     * Retorna la vista que contine el formulario de inicio de sesión
     * permitiendo a los usuarios ingresar a su cuenta.
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Enviar el correo de activación de cuenta al usuario.
     * Este método genera un enlace firmado para la activación de la cuenta del usuario
     * y lo envía por correo electrónico. El enlace será válido durante 30 minutos.
     * 
     * @param \App\Models\User $user
     * @return void
     */
    public function sendActivationEmail(User $user)
    {
        $url = URL::temporarySignedRoute(
            'activate.account',
            now()->addMinutes(30),
            ['email' => $user->email]
        );

        Mail::send('emails.activationAccount', ['url' => $url], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Activación de cuenta');
        });
    }

    /**
     * Registro de usuario.
     * Procesa la solicitud de registro de un nuevo usuario.
     * Al completar el registro, se envía un correo de activación.
     * 
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Log::info("Usuario registrado", ['email' => $user->email]);
        
        $this->sendActivationEmail($user);

        return redirect()->route('login.form')->with('success', 'Registro exitoso. Por favor, active su cuenta.');
    }

    /**
     * Iniciar sesión.
     * Valida las credenciales del usuario y si son correctas, 
     * genera un código de autenticación en dos factores, que se enviará por correo electrónico.
     * 
     * @param \App\Http\Requests\LoginRequest $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->whereNotNull('email_verified_at')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'credentials' => 'Datos incorrectos.',
            ]);
        }

        Log::info("Intento de inicio de sesión.", ['email' => $user->email]);
        $twoFactorCode = Str::random(6);
        $encryptedCode = Crypt::encryptString($twoFactorCode);

        $user->update([
            'two_factor_code' => $encryptedCode,
            'two_factor_expires_at' => now()->addMinutes(15),
        ]);

        session([
            'two_factor_user_id' => $user->id,
            'two_factor_expires_at' => now()->addMinutes(15),
        ]);

        Mail::to($user->email)->send(new TwoFactorCode($twoFactorCode));

        return redirect()->route('twofactor.form');
    }

    /**
     * Mostrar formulario para ingresar el código de autenticación en dos factores.
     * Retorna la vista donde el usuario puede ingresar el código que ha recibido por correo.
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function twoFactorForm()
    {
        return view('auth.twofactorCode');
    }

    /**
     * Verificar el código de autenticación en dos factores.
     * Valida el código ingresado por el usuario y si es correcto,
     * autentica al usuario y lo redirige al inicio.
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function verifyTwoFactor(Request $request)
    {
        if (session('two_factor_expires_at') < now()) {
            Log::warning("Código de autenticación expirado", ['user_id' => session('two_factor_user_id')]);
            return redirect()->route('twofactor.form')->withErrors(['message' => 'El código ha expirado.']);
        }

        $user = User::find(session('two_factor_user_id'));

        if (!$user || Crypt::decryptString($user->two_factor_code) !== $request->code) {
            Log::warning("Código de autenticación incorrecto", ['email' => $user->email ?? 'desconocido']);
            return redirect()->route('twofactor.form')->withErrors(['message' => 'Código incorrecto.']);
        }

        session()->forget(['two_factor_code', 'two_factor_expires_at', 'two_factor_user_id']);
        Auth::login($user);
        Log::info("Usuario autenticado con éxito", ['email' => $user->email]);

        return redirect()->route('home');
    }

    /**
     * Cerrar sesión.
     * Cierra la sesión del usuario, invalida la sesión y genera un nuevo token CSRF.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $userEmail = Auth::user()->email;
        Auth::logout();

        Log::info("Usuario cerró sesión", ['email' => $userEmail]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
