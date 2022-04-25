<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LenguajeController extends Controller
{
    public function cambiarLenguaje($lan)
    {
        session()->put('languaje', $lan);
        return redirect()->back();
    }
}
