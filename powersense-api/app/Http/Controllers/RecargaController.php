<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recarga;

class RecargaController extends Controller
{
    public function index()
    {
        $recargas = Recarga::orderBy('data_recarga', 'desc')->paginate(20);

        return view('recargas.index', compact('recargas'));
    }
}
