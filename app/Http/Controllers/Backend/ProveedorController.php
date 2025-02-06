<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Auth;
use Illuminate\Http\Request;
use Storage;

class ProveedorController extends Controller
{
    public function vistaproveedor()
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }

        $proveedores = Proveedor::where('estado', 'activo')->get();

        return view('admin.proveedor.index', compact('usuario', 'nombre', 'tipo', 'proveedores'));
    }

    public function crear_proveedor(Request $request)
    {
        // Validamos que el proveedor no exista por correo o teléfono
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required',
            'correo' => 'required',
            'direccion' => 'required|string|max:255',
        ]);

        // Verificamos si el proveedor ya existe por nombre, teléfono o correo
        $proveedorExistente = Proveedor::where('nombre', $request->nombre)
            ->orWhere('telefono', $request->telefono)
            ->orWhere('correo', $request->correo)
            ->exists();

        if ($proveedorExistente) {
            // Si el proveedor ya existe, redirigimos con un mensaje de error
            return redirect()->back()->with('error', 'El proveedor con este nombre, teléfono o correo ya existe.');
        }
        // Si no existe, procedemos a crear el nuevo proveedor
        Proveedor::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
        ]);

        // Redirigimos con un mensaje de éxito
        return redirect()->back()->with('success', 'Proveedor creado con éxito');
    }

    public function cambiar_foto_proveedor(Request $request)
    {
        // Validar el archivo de imagen
        $request->validate([
            'photo' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Obtener el id del proveedor desde el campo oculto
        $id = $request->input('id-logo-prov');
        $proveedor = Proveedor::findOrFail($id);

        if ($request->hasFile('photo')) {
            // Subir la nueva foto
            $path = $request->file('photo')->store('public/proveedor');

            // Convertir el path a una URL accesible
            $path = str_replace('public/', 'storage/', $path);

            // Actualizar el avatar del proveedor
            $proveedor->avatar = $path;
            $proveedor->save();
        }

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Foto actualizada correctamente');
    }

    public function extraerDatos($id)
    {
        $proveedor = Proveedor::find($id);

        if ($proveedor) {
            return response()->json([
                'success' => true,
                'data' => $proveedor
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id_edit_prov' => 'required',
            'nombre_edit' => 'required|string|max:255',
            'telefono_edit' => 'required|numeric',
            'correo_edit' => 'nullable|email|max:255',
            'direccion_edit' => 'required|string|max:255',
        ]);

        $proveedor = Proveedor::findOrFail($request->id_edit_prov);
        $proveedor->nombre = $request->nombre_edit;
        $proveedor->telefono = $request->telefono_edit;
        $proveedor->correo = $request->correo_edit;
        $proveedor->direccion = $request->direccion_edit;
        $proveedor->save();

        return redirect()->back()->with('success', 'Proveedor actualizado correctamente.');
    }

    public function eliminar_proveedor($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->estado = 'Inactivo';  // Cambia el valor de estado, puede ser 'activo' o 'inactivo'
            $proveedor->save();

            return response()->json([
                'success' => true,
                'message' => 'Proveedor marcado como inactivo correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar el proveedor como inactivo.'
            ]);
        }
    }


}
