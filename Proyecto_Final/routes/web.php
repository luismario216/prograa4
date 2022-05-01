<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');
Route::view('/google/login', 'auth.google.login');
Route::view('/google/register', 'auth.google.register');

Auth::routes();

Route::resource('/usuarios', App\Http\Controllers\UsuariosControlador::class)->middleware('auth');
Route::post('/new-name',[App\Http\Controllers\UsuariosControlador::class,'update'])->middleware('auth');
Route::delete('/delete',[App\Http\Controllers\UsuariosControlador::class,'destroy'])->middleware('auth');
Route::resource('/contactos', App\Http\Controllers\ContactosControlador::class)->middleware('auth');
Route::post('/register/user', App\Http\Controllers\UsuariosControlador::class . '@store')->middleware('guest')->name('register.user');

Route::get('/login/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);
Route::post('/register/google', [GoogleController::class, 'register']);
Route::get('/locale/{locale}', [App\Http\Controllers\LenguajeController::class, 'cambiarLenguaje'])->name('lan');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
