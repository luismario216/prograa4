<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuariosControlador extends Controller
{
    public function index()
    {
        return User::get();
    }

    public function store(Request $request)
    {
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
