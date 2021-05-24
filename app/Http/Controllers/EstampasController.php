<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estampa;

class EstampasController extends Controller
{
    public function index()
    {
        $estampas = Estampa::paginate(10);
        return view('catalogos.index')
            ->withEstampas($estampas);
    }
}
