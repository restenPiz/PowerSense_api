<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registro de novo contador
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_contador' => 'required|string|unique:contadores,numero_contador|max:50',
            'nome_proprietario' => 'required|string|max:255',
            'endereco' => 'required|string|max:500',
            'password' => 'required|string|min:4', // Senha opcional mas recomendada
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Criar contador
        $contador = Contador::create([
            'numero_contador' => $request->numero_contador,
            'nome_proprietario' => $request->nome_proprietario,
            'endereco' => $request->endereco,
            'password' => Hash::make($request->password),
            'saldo_kwh' => 0,
        ]);

        // Gerar token de autenticação
        $token = $contador->createToken('app-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Contador registrado com sucesso',
            'data' => [
                'contador' => [
                    'id' => $contador->id,
                    'numero_contador' => $contador->numero_contador,
                    'nome_proprietario' => $contador->nome_proprietario,
                    'endereco' => $contador->endereco,
                    'saldo_kwh' => $contador->saldo_kwh,
                ],
                'token' => $token,
            ]
        ], 201);
    }

    /**
     * Login (autenticação do contador)
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_contador' => 'required|string',
            'nome_proprietario' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Buscar contador
        $contador = Contador::where('numero_contador', $request->numero_contador)
            ->where('nome_proprietario', $request->nome_proprietario)
            ->first();

        if (!$contador) {
            return response()->json([
                'success' => false,
                'message' => 'Número do contador ou nome do proprietário incorretos'
            ], 401);
        }

        // Se tiver senha, validar
        if ($request->has('password') && $contador->password) {
            if (!Hash::check($request->password, $contador->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Senha incorreta'
                ], 401);
            }
        }

        // Gerar token
        $token = $contador->createToken('app-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso',
            'data' => [
                'contador' => [
                    'id' => $contador->id,
                    'numero_contador' => $contador->numero_contador,
                    'nome_proprietario' => $contador->nome_proprietario,
                    'endereco' => $contador->endereco,
                    'saldo_kwh' => $contador->saldo_kwh,
                    'dias_estimados' => $contador->calcularDiasEstimados(),
                ],
                'token' => $token,
            ]
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout realizado com sucesso'
        ]);
    }

    /**
     * Obter dados do contador autenticado
     */
    public function me(Request $request)
    {
        $contador = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $contador->id,
                'numero_contador' => $contador->numero_contador,
                'nome_proprietario' => $contador->nome_proprietario,
                'endereco' => $contador->endereco,
                'saldo_kwh' => $contador->saldo_kwh,
                'dias_estimados' => $contador->calcularDiasEstimados(),
                'consumo_hoje' => $contador->consumoHoje(),
            ]
        ]);
    }
}
