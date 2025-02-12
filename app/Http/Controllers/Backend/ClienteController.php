<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Sexo;
use Carbon\Carbon;
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
        return view('admin.cliente.index', compact('usuario', 'nombre', 'tipo', 'sexo', 'cliente'));
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

    public function cambiar_foto_cliente(Request $request)
    {
        // Validar el archivo de imagen
        $request->validate([
            'photo' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Obtener el id del cliente desde el campo oculto
        $id = $request->input('id-logo-cli');
        $cliente = Cliente::findOrFail($id);

        if ($request->hasFile('photo')) {
            // Subir la nueva foto
            $path = $request->file('photo')->store('public/proveedor');

            // Convertir el path a una URL accesible
            $path = str_replace('public/', 'storage/', $path);

            // Actualizar el avatar del cliente
            $cliente->avatar = $path;
            $cliente->save();
        }

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Foto actualizada correctamente');
    }

    public function extraer_datos_cliente($id)
    {
        $cliente = Cliente::find($id);

        if ($cliente) {
            // Calcular edad
            $edad = null;
            if ($cliente->edad) {
                $edad = Carbon::parse($cliente->edad)->age;
            }

            return response()->json([
                'success' => true,
                'data' => $cliente,
                'edad_fecha' => $edad  // Agregamos la edad al JSON
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }
    }


    public function actualizar_cliente(Request $request)
    {
        $request->validate([
            'id_edit_cli' => 'required',
            'nombre_edit' => 'required|string|max:255',
            'apellidos_edit' => 'required|string|max:255',
            'telefono_edit' => 'required|numeric',
            'correo_edit' => 'nullable|email|max:255',
            'direccion_edit' => 'required|string|max:255',
            'dni_edit' => 'required',
            'f_nac_edit' => 'required|date',
            'id_sexo_edit' => 'required',
        ]);

        $cliente = Cliente::findOrFail($request->id_edit_cli);
        $cliente->nombre = $request->nombre_edit;
        $cliente->apellidos = $request->apellidos_edit;
        $cliente->dni = $request->dni_edit;
        $cliente->edad = $request->f_nac_edit;
        $cliente->telefono = $request->telefono_edit;
        $cliente->correo = $request->correo_edit;
        $cliente->direccion = $request->direccion_edit;
        $cliente->sexo_id = $request->id_sexo_edit;
        $cliente->save();
        return redirect()->back()->with('success', 'Proveedor actualizado correctamente.');
    }

    public function eliminar_cliente($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->estado = 'Inactivo';  // Cambia el valor de estado, puede ser 'activo' o 'inactivo'
            $cliente->save();

            return response()->json([
                'success' => true,
                'message' => 'cliente marcado como inactivo correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar el cliente como inactivo.'
            ]);
        }
    }

}

