<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Laboratorio;
use App\Models\Presentacion;
use App\Models\Producto;
use App\Models\Tipo;
use App\Models\TipoProducto;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Storage;

class ProductoController extends Controller
{
    // Función que muestra la vista para la gestión de productos
    public function vistaproducto()
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtiene información del usuario autenticado
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }

        // Obtiene todos los registros de los modelos relacionados
        $tipospr = TipoProducto::all(); // Modelos de tipos de productos
        $laboratorios = Laboratorio::all(); // Modelos de laboratorios
        $presentaciones = Presentacion::all(); // Modelos de presentaciones

        // Devuelve la vista para mostrar los productos, pasando datos como el usuario y los registros adicionales
        return view('admin.productos.index', compact('usuario', 'nombre', 'tipo', 'tipospr', 'laboratorios', 'presentaciones'));
    }

    // Función que maneja la creación de nuevos productos
    public function crear_productos(Request $request)
    {
        // Valida los datos que se envían en el formulario
        $validatedData = $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'concentracion' => 'nullable|string|max:255',
            'adicional' => 'nullable|string|max:255',
            'precio' => 'required|numeric',
            'laboratorio' => 'required|integer|exists:laboratorios,id',
            'tipo' => 'required|integer|exists:tipos,id',
            'presentacion' => 'required|integer|exists:presentaciones,id',
        ]);

        // Verifica si ya existe un producto con el mismo nombre, laboratorio, tipo y presentación
        $productoExistente = Producto::where('nombre', $validatedData['nombre_producto'])
            ->where('id_lab', $validatedData['laboratorio'])
            ->where('id_tip_prod', $validatedData['tipo'])
            ->where('id_present', $validatedData['presentacion'])
            ->first();

        // Si el producto ya existe, devuelve un error
        if ($productoExistente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ya existe un producto con el mismo nombre, laboratorio, tipo y presentación.'
            ], 400);
        }

        // Si no existe el producto, lo crea
        $producto = new Producto();
        $producto->nombre = $validatedData['nombre_producto'];
        $producto->concentracion = $validatedData['concentracion'];
        $producto->adicional = $validatedData['adicional'];
        $producto->precio = $validatedData['precio'];
        $producto->id_lab = $validatedData['laboratorio'];
        $producto->id_tip_prod = $validatedData['tipo'];
        $producto->id_present = $validatedData['presentacion'];

        // Guarda el nuevo producto en la base de datos
        $producto->save();

        // Retorna una respuesta exitosa en formato JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Producto creado correctamente'
        ]);
    }

    // Función para buscar productos según una consulta
    public function buscar_productos(Request $request)
    {
        // Obtiene el valor de la consulta enviada en la solicitud
        $consulta = $request->input('consulta');

        // Prepara la consulta para buscar productos activos
        $query = Producto::with(['laboratorio', 'tipoProducto', 'presentacion'])
            ->where('estado', 'Activo'); // Solo productos activos

        // Si se proporcionó una consulta, filtra los productos por nombre
        if (!empty($consulta)) {
            $query->where('nombre', 'like', '%' . $consulta . '%');
        } else {
            // Si no se proporciona consulta, ordena por nombre
            $query->orderBy('nombre');
        }

        // Limita los resultados a 25 productos
        $productos = $query->limit(25)->get();

        // Mapea los resultados para que la respuesta sea más fácil de usar en el frontend
        $productosResponse = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'concentracion' => $producto->concentracion,
                'adicional' => $producto->adicional,
                'precio' => $producto->precio,
                'stock' => $producto->stock,  // Asegúrate de que haya un campo de stock en el modelo
                'laboratorio' => $producto->laboratorio->nombre,  // Accede al nombre del laboratorio
                'tipo' => $producto->tipoProducto->nombre,  // Accede al nombre del tipo de producto
                'presentacion' => $producto->presentacion->nombre,  // Accede al nombre de la presentación
                'laboratorio_id' => $producto->id_lab,
                'tipo_id' => $producto->id_tip_prod,
                'presentacion_id' => $producto->id_present,
                'avatar' => $producto->avatar && file_exists(public_path('storage/producto/' . $producto->avatar))
                    ? asset('storage/producto/' . $producto->avatar)
                    : asset('img/producto_default.jpeg'),

            ];
        });

        // Devuelve la respuesta en formato JSON con los productos encontrados
        return response()->json($productosResponse);
    }
    public function cambiar_avatar(Request $request)
    {
        // Validar el archivo
        $validatedData = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Obtener el producto
        $producto = Producto::find($request->input('id-logo-prod'));

        if ($producto) {
            // Guardar la nueva imagen
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filePath = 'producto/' . $filename; // Ruta donde se almacenará la imagen

                // Verificar que el directorio exista y crearlo si no existe
                $directory = storage_path('app/public/producto');
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true); // Crear el directorio si no existe
                }

                // Elimina la imagen antigua si existe
                if ($producto->avatar) {
                    Storage::delete('public/producto/' . $producto->avatar);
                }

                // Guardar la nueva imagen en el directorio 'producto' dentro de 'storage/app/public'
                $file->storeAs('public/producto', $filename);

                // Actualizar el campo 'avatar' en la base de datos
                $producto->avatar = $filename;
                $producto->save();

                // Retornar una respuesta JSON con la nueva ruta de la imagen
                return response()->json([
                    'alert' => 'edit',
                    'ruta' => asset('storage/producto/' . $filename)
                ]);
            }
        }

        // Retornar un error si el producto no se encuentra
        return response()->json([
            'alert' => 'error'
        ], 400);
    }

    public function editar_productos(Request $request)
    {
        $producto = Producto::find($request->id_edit_prod);

        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        $producto->update([
            'nombre' => $request->edit_nombre,
            'concentracion' => $request->edit_concentracion,
            'adicional' => $request->edit_adicional,
            'precio' => $request->edit_precio,
            'id_lab' => $request->edit_laboratorio,
            'id_tip_prod' => $request->edit_tipo,
            'id_present' => $request->edit_presentacion,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Producto actualizado correctamente.'
        ]);
    }

    public function eliminar_producto($id)
    {
        // Verificar si el producto tiene lotes activos
        $lotesActivos = DB::table('lote')
            ->where('id_prod', $id)
            ->where('estado', 'Activo')
            ->exists(); // Retorna true si hay lotes activos

        if ($lotesActivos) {
            // Si hay lotes activos, no se puede borrar
            return response()->json('noborrado');
        }

        // Actualizar el estado del producto a 'I'
        $actualizado = DB::table('productos')
            ->where('id', $id)
            ->update(['estado' => 'Inactivo']);

        if ($actualizado) {
            return response()->json('borrado');
        }

        return response()->json('noborrado');
    }




}
