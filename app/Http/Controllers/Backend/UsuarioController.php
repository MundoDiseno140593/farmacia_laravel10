<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tipo;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Storage;

class UsuarioController extends Controller
{
    public function listausuario()
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;

            $user = User::with('tipo')->where('estado', 'Activo')->get();

            $tipousuario = Tipo::all();
        }
        return view('admin/usuario.index', compact('usuario', 'nombre', 'tipo', 'tipousuario', 'user'));
    }


    public function saveuser(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'id_tipo' => 'required|exists:tipos,id'
        ]);


        $user = new User();
        $user->name = $request->input('nombre');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->id_tipo = $request->input('id_tipo');

        $user->save();

        return redirect()->route('listausuario')->with('success', 'Usuario creado correctamente.');
    }


    public function verusuario($id)
    {
        $usuario = User::with('tipo')->find($id);
        if ($usuario) {
            // Construir la URL completa para el avatar
            $usuario->avatar = $usuario->avatar ? asset('storage/profile_images/' . $usuario->avatar) : asset('images/default_avatar.png');
        }
        return response()->json($usuario);
    }


    public function editarus($id)
    {
        $user = User::find($id);

        // Construir la URL completa de la imagen de perfil
        $avatarUrl = $user->avatar ? asset('storage/profile_images/' . $user->avatar) : asset('img/default.jpg');

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $avatarUrl,
            'id_tipo' => $user->id_tipo,
            'estado' => $user->estado,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ]);
    }


    public function editar_usuario(Request $request)
    {
        $request->validate([
            'iduser' => 'required',
            'username' => "required",
            'useremail' => "required",
            'id_tipo_edit' => "required",
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = User::find($request->input('iduser'));

        $user->name = $request->input('username');
        $user->email = $request->input('useremail');
        $user->id_tipo = $request->input('id_tipo_edit');

        if ($request->hasFile('profile_image')) {
            // Eliminar la imagen antigua si existe
            if ($user->avatar) {
                Storage::delete('public/profile_images/' . $user->avatar);
            }

            // Subir la nueva imagen
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->file('profile_image')->storeAs('public/profile_images', $imageName);

            // Actualizar la ruta de la imagen en el perfil del usuario
            $user->avatar = $imageName;
        }
        $user->save();

        return redirect()->route('listausuario')->with('success', 'Usuario editado correctamente.');
    }


    public function eliminar($id)
    {
        $usuario = User::find($id);

        if ($usuario) {
            $usuario->estado = 'Inactivo';
            $usuario->save();
            return response()->json(['success' => true, 'message' => 'usario Inactivo']);
        }

        return response()->json(['error' => true, 'message' => 'usario no encontrado']);
    }


    public function usuariosinactivos()
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;

            $user = User::with('tipo')->where('estado', 'Inactivo')->get();

            $tipousuario = Tipo::all();
        }
        return view('admin/usuario.inactivo', compact('usuario', 'nombre', 'tipo', 'tipousuario', 'user'));
    }


    public function activarusaurios($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'usario no Encontrado']);
        }

        $user->estado = 'Activo';
        $user->save();

        return response()->json(['success' => true, 'message' => 'usario activado correctamente']);
    }
}
