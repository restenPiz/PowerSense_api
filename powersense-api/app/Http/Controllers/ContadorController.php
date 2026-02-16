<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContadorController extends Controller
{
    public function index()
    {
        return Inertia::render('Contador', [
            'contadores' => \App\Models\Contador::all()
        ]);
    }


}
