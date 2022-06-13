<?php

namespace App\Http\Controllers;

use App\Models\Contactos;
use App\Models\User;
use Illuminate\Http\Request;

class ContactosControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactos = Contactos::select('users.id', 'users.name', 'users.last_name', 'users.number')
            ->join('users', 'contactos.contact_id', '=', 'users.id')
            ->where('contactos.user_id', '=', auth()->user()->id)
            ->get();
        return $contactos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contacto = new Contactos;
        $contacto->user_id = auth()->user()->id;
        $contacto->contact_id = $request->contact_id;
        $contacto->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function show(Contactos $contactos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function edit(Contactos $contactos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contactos $contactos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contactos $contactos)
    {
        //
    }
}
