<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Sexo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
        $cliente = Cliente::where('estado', 'activo')->get();
        return view('admin.cliente.index', compact('usuario', 'nombre', 'tipo', 'sexo','cliente'));
    }

    public function crear_cliente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|integer',
            'f_nac' => 'required|date',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string',
            'correo' => 'nullable|email|max:255',
            'id_sexo' => 'required|exists:sexos,id',
        ]);

        try {
            Cliente::create([
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'dni' => $request->dni,
                'edad' => $request->f_nac,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'correo' => $request->correo,
                'sexo_id' => $request->id_sexo,
            ]);

            return redirect()->back()->with('success', 'Cliente creado con éxito');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }


}
