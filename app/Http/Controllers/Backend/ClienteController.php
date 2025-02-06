<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sexo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function listaCliente()
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }

        $sexo = Sexo::all();
        // $proveedores = Proveedor::where('estado', 'activo')->get();
        return view('admin.cliente.index', compact('usuario', 'nombre', 'tipo','sexo'));
    }
}
