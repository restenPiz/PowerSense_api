<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recarga;

class RecargaController extends Controller
{
    public function index()
    {
        return \Inertia\Inertia::render('Recarga', [
            'recargas' => Recarga::all()
        ]);
    }
}
