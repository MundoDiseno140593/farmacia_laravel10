<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdminController extends Controller
{
    public function login()
    {

        // Verifica si el usuario root existe, suponiendo que el role_id del usuario root es 1
        $rootExists = User::where('id_tipo', 1)->exists();

        return view('admin/login.login', compact('rootExists'));
    }

    public function registro()
    {
        return view('admin/login.registro');
    }

    public function home()
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }
        return view('admin/home.home', compact('usuario', 'nombre', 'tipo'));
    }

    public function loginInicio(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);


        $credenciales['email'] = strtolower($credenciales['email']);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
            $usuario = Auth::user();

            return redirect()->route('home')->with('succes', 'Has Iniciado session');
        } else {
            return redirect()->route('login')->with('error', 'Credenciales Incorrectas');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


    public function crearusuario(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Si la validación falla, redirige con mensajes de error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->id_tipo = 1;

        $user->save();

        return redirect()->route('login')->with('success', 'Usuario registrado exitosamente.');

    }
}
