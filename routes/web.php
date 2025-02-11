<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AtributoController;
use App\Http\Controllers\Backend\ClienteController;
use App\Http\Controllers\Backend\ProductoController;
use App\Http\Controllers\Backend\ProveedorController;
use App\Http\Controllers\Backend\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Verificar si el usuario no está autenticado
    if (!auth()->check()) {
        return Redirect::action([AdminController::class, 'login']);
    }
    return redirect()->route('home');
});


Route::prefix('usuario')->group(function () {
    Route::get('/listarusuario', [UsuarioController::class, 'listausuario'])->name('listausuario');
    Route::get('/usuariosinactivos', [UsuarioController::class, 'usuariosinactivos'])->name('usuariosinactivos');

    Route::post('/saveuser', [UsuarioController::class, 'saveuser'])->name('saveuser');


    Route::get('/verusuario/{id}', [UsuarioController::class, 'verusuario'])->name('verusuario');

    //capturar los datos para editar
    Route::get('/editarus/{id}', [UsuarioController::class, 'editarus'])->name('editarus');
    //editar usuario
    Route::post('/editar_usuario', [UsuarioController::class, 'editar_usuario'])->name('editar_usuario');

    Route::post('/eliminar/{id}', [UsuarioController::class, 'eliminar'])->name('eliminar');

    Route::post('/activarusaurios/{id}', [UsuarioController::class, 'activarusaurios'])->name('activarusaurios');

});

Route::prefix('atributos')->group(function () {
    Route::get('/vistaAtributos', [AtributoController::class, 'vistaAtributos'])->name('vistaAtributos');
// proceso del laboratorio
    Route::get('/listarlaboratorios', [AtributoController::class, 'listarLaboratorios'])->name('listarLaboratorios');
    Route::get('/datoslaboratorio/{id}', [AtributoController::class, 'datoslaboratorio'])->name('datoslaboratorio');
    Route::post('/crearLaboratorio', [AtributoController::class, 'crearLaboratorio'])->name('crearLaboratorio');
    Route::post('/eliminarLaboratorio/{id}', [AtributoController::class, 'eliminarLaboratorio'])->name('eliminarLaboratorio');
    Route::post('/editarLabo/{id}', [AtributoController::class, 'editarLabo'])->name('editarLabo');

    // proceso de tipo producto
    Route::post('/crearTipoProd', [AtributoController::class, 'crearTipoProd'])->name('crearTipoProd');
    Route::get('/listartipo', [AtributoController::class, 'listartipo'])->name('listartipo');
    Route::get('/datosTip/{id}', [AtributoController::class, 'datosTip'])->name('datosTip');
    Route::post('/editarTipo/{id}', [AtributoController::class, 'editarTipo'])->name('editarTipo');
    Route::post('/eliminarTipo/{id}', [AtributoController::class, 'eliminarTipo'])->name('eliminarTipo');

    // procesos de presentacion del producto crearPresentacion
    Route::post('/crearPresentacion', [AtributoController::class, 'crearPresentacion'])->name('crearPresentacion');
    Route::get('/listarPresentacion', [AtributoController::class, 'listarPresentacion'])->name('listarPresentacion');
    Route::get('/datosPre/{id}', [AtributoController::class, 'datosPre'])->name('datosPre');
    Route::post('/editarPre/{id}', [AtributoController::class, 'editarPre'])->name('editarPre');
    Route::post('/eliminarPre/{id}', [AtributoController::class, 'eliminarPre'])->name('eliminarPre');
});


Route::prefix('productos')->group(function () {
    Route::get('/vistaproducto', [ProductoController::class, 'vistaproducto'])->name('vistaproducto');
    Route::post('/crear_productos', [ProductoController::class, 'crear_productos'])->name('crear_productos');
    Route::get('/buscar_productos', [ProductoController::class, 'buscar_productos'])->name('buscar_productos');
    Route::post('/cambiar_avatar', [ProductoController::class, 'cambiar_avatar'])->name('cambiar_avatar');
    Route::post('/editar_productos', [ProductoController::class, 'editar_productos'])->name('editar_productos');
    Route::post('/eliminar_producto/{id}', [ProductoController::class, 'eliminar_producto'])->name('eliminar_producto');

});


Route::prefix('proveedor')->group(function () {
    Route::get('/vistaproveedor', [ProveedorController::class, 'vistaproveedor'])->name('vistaproveedor');
    Route::post('/crear_proveedor', [ProveedorController::class, 'crear_proveedor'])->name('crear_proveedor');
    Route::post('/cambiar_foto_proveedor', [ProveedorController::class, 'cambiar_foto_proveedor'])->name('cambiar_foto_proveedor');
    Route::get('/proveedor/{id}', [ProveedorController::class, 'extraerDatos'])->name('extraer_datos');
    Route::put('/proveedor/actualizar', [ProveedorController::class, 'actualizar'])->name('actualizar_proveedor');
    Route::post('/proveedor/eliminar_proveedor/{id}', [ProveedorController::class, 'eliminar_proveedor'])->name('eliminar_proveedor');
});


Route::prefix('cliente')->group(function () {
    Route::get('/cliente', [ClienteController::class, 'listaCliente'])->name('listaCliente');
    Route::post('/crear_cliente', [ClienteController::class, 'crear_cliente'])->name('crear_cliente');
    Route::post('/cambiar_foto_cliente', [ClienteController::class, 'cambiar_foto_cliente'])->name('cambiar_foto_cliente');
    Route::get('/cliente/{id}', [ClienteController::class, 'extraer_datos_cliente'])->name('extraer_datos_cliente');
    Route::put('/proveedor/actualizar', [ProveedorController::class, 'actualizar'])->name('actualizar_proveedor');
    Route::post('/proveedor/eliminar_proveedor/{id}', [ProveedorController::class, 'eliminar_proveedor'])->name('eliminar_proveedor');
});





Route::prefix('admin')->group(function () {
    Route::middleware('admin-logueado:0')->group(function () {
        Route::get('/', [AdminController::class, 'login'])->name('login');
        Route::get('/registro', [AdminController::class, 'registro'])->name('registro');
        Route::post('/loginInicio', [AdminController::class, 'loginInicio'])->name('loginInicio');
        Route::post('/crearusuario', [AdminController::class, 'crearusuario'])->name('crearusuario');

    });

    Route::middleware('admin-logueado:1')->group(function () {
        Route::get('/home', [AdminController::class, 'home'])->name('home');
        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    });
});