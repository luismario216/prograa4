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
});
Route::view('/google/login', 'auth.google.login');
Route::view('/google/register', 'auth.google.register');

Auth::routes();

Route::get('/login/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);
Route::post('/register/google', [GoogleController::class, 'register']);

// La siguiente ruta no debe redirección a ninguna vista, sino a una ruta de controlador
Route::get('/locale/{locale}', [App\Http\Controllers\LenguajeController::class, 'cambiarLenguaje'])->name('lan');
// Route::post('/lan', function () {
//     // App::setLocale($request->languaje);
//     dd($request);
//     return $request->all();
// })->name('lan');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
