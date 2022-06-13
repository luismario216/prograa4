@extends('layouts.app')

@section('content')
<ajustes-component v-bind:form="vistas" rel="ajustes" v-if="vistas['ajustes'].mostrar" :titulo="'@lang('mensajes.test')'" :guardar="'@lang('mensajes.save')'" :login="{{ Auth::check() }}" :lang="{{ json_encode(App::getLocale()) }}"></ajustes-component>
<div class="container">
    @if (Auth::check())
        <p id="user_id" class="d-none">{{Auth::user()->id}}</p>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
        <mis-contactos v-bind:form="vistas" rel="misContactos" v-if="vistas['misContactos'].mostrar" 
            :titulo="'@lang('mensajes.myContacts')'" :nombre="'@lang('mensajes.nombre')'" :apellido="'@lang('mensajes.apellido')'" :numero="'@lang('mensajes.numero')'"></mis-contactos>
            <contacto-component v-bind:form="vistas" rel="contacto" v-if="vistas['contacto'].mostrar" 
            :titulo="'@lang('mensajes.contact')'" :agregar="'@lang('mensajes.addContact')'" :guardar="'@lang('mensajes.save')'"></contacto-component>
        
            <mi-ubicacion v-bind:form="vistas" rel="miUbicacion" v-if="vistas['miUbicacion'].mostrar" 
            :titulo="'@lang('mensajes.ubication')'" :encontrar="'@lang('mensajes.find')'" :compartir="'@lang('mensajes.shareUbication')'" :user="{{Auth::user()}}"></mi-ubicacion>
            <rutas-component v-bind:form="vistas" rel="rutas" v-if="vistas['rutas'].mostrar" 
            :titulo="'@lang('mensajes.routes')'" :buscar="'@lang('mensajes.search')'"></rutas-ubicacion>
        </div>
    </div>
</div>
@endsection
