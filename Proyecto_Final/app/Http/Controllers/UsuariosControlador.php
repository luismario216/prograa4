<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permisos;
use App\Models\Contactos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuariosControlador extends Controller
{
    public function index()
    {
        return User::get();
    }

    public function usuariosParaAgregar()
    {
        $usuarios = User::select('users.id', 'users.name', 'users.last_name', 'users.email', 'users.number')
            ->where('users.id', '!=', auth()->user()->id)
            ->whereNotIn('users.id', function ($query) {
                $query->select('contactos.contact_id')
                    ->from('contactos')
                    ->where('contactos.user_id', '=', auth()->user()->id);
            })
            ->get();
        return $usuarios;
    }

    public function store(Request $request)
    {
        $permiso = Permisos::get();
        if ($permiso->isEmpty()) {
            $permisos = [
                [
                    'nombre' => 'Usuario Comun',
                ],
                [
                    'nombre' => 'Administrador',
                ],
            ];
            Permisos::insert($permisos);
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $user = User::create($request->all());
        Auth::login($user);
        return redirect('/')->with('<p class="text-green-500">You are logged in!</p>');
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->update($request->all());
        return $user;
    }

    public function destroy()
    {
        $user = User::find(Auth::user()->id);
        $user->delete();
        return $user;
    }

}
