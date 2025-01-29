<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio.
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login.form');
        }

        return view('home');
    }
}
