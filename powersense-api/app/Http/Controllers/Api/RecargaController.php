<?php

namespace App\Http\Controllers;

use App\Models\Recarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecargaController extends Controller
{
    /**
     * Inserir código de recarga
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo_recarga' => 'required|string|size:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Verificar se código já foi usado
        if (Recarga::where('codigo_recarga', $request->codigo_recarga)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Este código de recarga já foi utilizado'
            ], 400);
        }

        // TODO: Aqui você integraria com a API da EDM para validar o código
        // Por enquanto, simulamos a resposta
        $valor = 500; // MT (simulado)
        $kwh = $valor / 10; // 10 MT = 1 kWh (simulado)

        $contador = $request->user();
        $recarga = $contador->adicionarRecarga(
            $request->codigo_recarga,
            $valor,
            $kwh
        );

        return response()->json([
            'success' => true,
            'message' => 'Recarga realizada com sucesso',
            'data' => [
                'recarga' => $recarga,
                'novo_saldo' => $contador->fresh()->saldo_kwh,
                'dias_estimados' => $contador->calcularDiasEstimados(),
            ]
        ], 201);
    }

    /**
     * Listar histórico de recargas
     */
    public function index(Request $request)
    {
        $contador = $request->user();
        $recargas = $contador->recargas()
            ->orderBy('data_recarga', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $recargas
        ]);
    }

    /**
     * Detalhes de uma recarga específica
     */
    public function show(Request $request, $id)
    {
        $contador = $request->user();
        $recarga = $contador->recargas()->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $recarga
        ]);
    }
}
