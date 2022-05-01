@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Si existe una sesión de usuario, enviarla como propiedad a ajustes-component -->
<ajustes-component v-bind:form="vistas" rel="ajustes" v-if="vistas['ajustes'].mostrar" :titulo="'@lang('mensajes.test')'" :guardar="'@lang('mensajes.save')'" :lang="'@lang('mensajes.lang')'" :login="{{ Auth::check() ? 'yes' : 'null' }}"></ajustes-component>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <mis-contactos v-bind:form="vistas" rel="misContactos" v-if="vistas['misContactos'].mostrar" 
            :titulo="'@lang('mensajes.myContacs')'" :nombre="'@lang('mensajes.nombre')'" :apellido="'@lang('mensajes.apellido')'" :numero="'@lang('mensajes.numero')'"></mis-contactos>
            <contacto-component v-bind:form="vistas" rel="contacto" v-if="vistas['contacto'].mostrar" 
            :titulo="'@lang('mensajes.contact')'" :agregar="'@lang('mensajes.addContact')'" :guardar="'@lang('mensajes.save')'"></contacto-component>
        </div>
    </div>
</div>
@endsection
