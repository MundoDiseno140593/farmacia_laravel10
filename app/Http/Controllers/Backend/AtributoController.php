<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Laboratorio;
use App\Models\Presentacion;
use App\Models\TipoProducto;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AtributoController extends Controller
{
    public function vistaAtributos()
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }

        return view('admin/atributos.index', compact('usuario', 'nombre', 'tipo'));
    }


    //parte de crear el laboratorio
    public function crearLaboratorio(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Ajusta el tamaño máximo según tus necesidades
        ]);

        // Verificar si ya existe un laboratorio con el mismo nombre
        $existeLaboratorio = Laboratorio::where('nombre', $request->nombre)->first();
        if ($existeLaboratorio) {
            // Retornar error si el laboratorio ya existe
            return redirect()->back()->with('danger', 'Ya existe un laboratorio con el Nombre: ' . $existeLaboratorio->nombre);
        }

        // Procesar la imagen si se ha cargado
        $path = null;
        if ($request->hasFile('foto')) {
            // Guardar la imagen en el directorio 'public/laboratorios' y obtener la ruta
            $path = $request->file('foto')->store('laboratorios', 'public');
        }

        // Crear el nuevo laboratorio
        $laboratorio = new Laboratorio();
        $laboratorio->nombre = $request->nombre;
        $laboratorio->foto = $path ? $path : 'default.png'; // Usa la ruta de la imagen o la imagen por defecto
        $laboratorio->save();

        // Redirigir o retornar respuesta
        return redirect()->back()->with('success', 'Laboratorio creado exitosamente.');
    }

    public function eliminarLaboratorio($id)
    {
        $lab = Laboratorio::find($id);

        if ($lab) {
            $lab->estado = 'Inactivo';
            $lab->save();
            return response()->json(['success' => true, 'message' => 'Laboratorio Inactivo']);
        }

        return response()->json(['error' => true, 'message' => 'Laboratorio no encontrado']);
    }

    public function listarLaboratorios(): JsonResponse
    {
        $laboratorios = Laboratorio::where('estado', 'activo')->get()->map(function ($laboratorio) {
            $laboratorio->foto_url = $laboratorio->foto ? asset('storage/' . $laboratorio->foto) : null;
            return $laboratorio;
        });

        // Retorna los laboratorios en formato JSON
        return response()->json(['lab' => $laboratorios]);
    }

    public function datoslaboratorio($id): JsonResponse
    {
        $laboratorio = Laboratorio::find($id);
        if ($laboratorio) {
            $laboratorio->foto_url = $laboratorio->foto ? asset('storage/' . $laboratorio->foto) : asset('img/default.jpg');
            return response()->json(['success' => true, 'laboratorio' => $laboratorio]);
        } else {
            return response()->json(['success' => false, 'message' => 'Laboratorio no encontrado']);
        }
    }

    public function editarLabo(Request $request, $id)
    {
        $laboratorio = Laboratorio::find($id);
        if ($laboratorio) {
            $laboratorio->nombre = $request->input('edit_nombre');

            if ($request->hasFile('edit_foto')) {
                $fotoPath = $request->file('edit_foto')->store('laboratorios', 'public');
                $laboratorio->foto = $fotoPath;
            }

            $laboratorio->save();

            return response()->json(['success' => true, 'message' => 'Laboratorio actualizado correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'Laboratorio no encontrado']);
        }
    }


    // crear parte de tipo productos
    public function crearTipoProd(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_tipo' => 'required|string|max:255',
        ]);

        // Verificar si ya existe un tipo de producto con el mismo nombre
        $existeTipo = TipoProducto::where('nombre', $request->nombre_tipo)->first();
        if ($existeTipo) {
            // Retornar error si el tipo de producto ya existe
            return response()->json(['success' => false, 'message' => 'Ya existe un tipo de producto con el nombre: ' . $existeTipo->nombre]);
        }

        // Crear el nuevo tipo de producto
        $tipo = new TipoProducto();
        $tipo->nombre = $request->nombre_tipo;
        $tipo->save();

        return response()->json(['success' => true, 'message' => 'Tipo Producto creado con éxito', 'tipo' => $tipo]);
    }


    public function listartipo(): JsonResponse
    {
        $tipos = TipoProducto::where('estado', 'Activo')->get();
        // Retorna los laboratorios en formato JSON
        return response()->json(['tip' => $tipos]);
    }

    public function datosTip($id): JsonResponse
    {
        $tipo = TipoProducto::find($id);
        if ($tipo) {
            return response()->json(['success' => true, 'tipo' => $tipo]);
        } else {
            return response()->json(['success' => false, 'message' => 'Tipo no encontrado']);
        }
    }

    public function editarTipo(Request $request, $id)
    {
        $ltipo = TipoProducto::find($id);
        if ($ltipo) {
            $ltipo->nombre = $request->input('edit_nombre_tip');
            $ltipo->save();

            return response()->json(['success' => true, 'message' => 'Tipo actualizado correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tipo no encontrado']);
        }
    }

    public function eliminarTipo($id)
    {
        $tip = TipoProducto::find($id);

        if ($tip) {
            $tip->estado = 'Inactivo';
            $tip->save();
            return response()->json(['success' => true, 'message' => 'Tipo Inactivo']);
        }

        return response()->json(['error' => true, 'message' => 'Tipo no encontrado']);
    }

    // crear procesos de presentacion
    public function crearPresentacion(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_pre' => 'required|string|max:255',
        ]);

        // Verificar si ya existe una presentación con el mismo nombre
        $existePresentacion = Presentacion::where('nombre', $request->nombre_pre)->first();
        if ($existePresentacion) {
            // Retornar error si la presentación ya existe
            return response()->json(['success' => false, 'message' => 'Ya existe una presentación con el nombre: ' . $existePresentacion->nombre]);
        }

        // Crear la nueva presentación
        $pre = new Presentacion();
        $pre->nombre = $request->nombre_pre;
        $pre->save();

        return response()->json(['success' => true, 'message' => 'Presentación creada con éxito', 'presentacion' => $pre]);
    }



    public function listarPresentacion(): JsonResponse
    {
        $presentacion = Presentacion::where('estado', 'Activo')->get();
        // Retorna los laboratorios en formato JSON
        return response()->json(['pre' => $presentacion]);
    }

    public function datosPre($id): JsonResponse
    {
        $pre = Presentacion::find($id);
        if ($pre) {
            return response()->json(['success' => true, 'pre' => $pre]);
        } else {
            return response()->json(['success' => false, 'message' => 'Presentacion no encontrado']);
        }
    }

    public function editarPre(Request $request, $id)
    {
        $pre = Presentacion::find($id);
        if ($pre) {
            $pre->nombre = $request->input('edit_nombre_pre');
            $pre->save();

            return response()->json(['success' => true, 'message' => 'Presentacion actualizado correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'Presentacion no encontrado']);
        }
    }

    public function eliminarPre($id)
    {
        $pre = Presentacion::find($id);

        if ($pre) {
            $pre->estado = 'Inactivo';
            $pre->save();
            return response()->json(['success' => true, 'message' => 'Presentacion Inactivo']);
        }

        return response()->json(['error' => true, 'message' => 'Presentacion no encontrado']);
    }

}
