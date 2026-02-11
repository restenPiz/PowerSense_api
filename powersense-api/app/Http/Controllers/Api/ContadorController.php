<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContadorController extends Controller
{
    /**
     * Obter dashboard completo
     */
    public function dashboard(Request $request)
    {
        $contador = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'saldo' => [
                    'kwh' => $contador->saldo_kwh,
                    'dias_estimados' => $contador->calcularDiasEstimados(),
                ],
                'consumo' => [
                    'hoje' => $contador->consumoHoje(),
                    'semanal' => $contador->consumoSemanal(),
                ],
                'estatisticas' => [
                    'total_recargas' => $contador->recargas()->count(),
                    'total_valor_recarregado' => $contador->recargas()->sum('valor_mt'),
                    'total_kwh_recarregado' => $contador->recargas()->sum('kwh'),
                    'ultima_recarga' => $contador->recargas()->latest('data_recarga')->first(),
                ]
            ]
        ]);
    }

    /**
     * Obter consumo semanal detalhado
     */
    public function consumoSemanal(Request $request)
    {
        $contador = $request->user();

        return response()->json([
            'success' => true,
            'data' => $contador->consumoSemanal()
        ]);
    }
}
