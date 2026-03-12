<?php

namespace App\Http\Controllers;

use App\Enums\SessionActions;
use App\Enums\SessionKeys;
use App\Facades\CheckProxy\CheckProxy;
use App\Facades\ConfigFacade;
use App\Facades\Notify;
use App\Facades\SessionLogFacade;
use App\Models\SessionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use libphonenumber\NumberParseException;

class AuthController extends Controller
{
    public function index()
    {

        return view('auth.index' );
    }

    public function logout()
    {

        Auth::logout();
        $this->request->session()->invalidate();
        $this->request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function login()
    {
        $data = $this->request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);







        $user = User::where('email', $data['email'])->first();
        if ($user == null) {
            return redirect()->back()->withErrors('Usuario no encontrado');
        }


        if (Auth::attempt($data)) {


            return redirect()->route('dashboard');
        } else {

            return redirect()->back()->withErrors('Usuario o contraseña incorrectos');
        }
    }
}
