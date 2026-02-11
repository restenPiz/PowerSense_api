<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Contador extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'contadores';

    protected $fillable = [
        'numero_contador',
        'nome_proprietario',
        'endereco',
        'saldo_kwh',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'saldo_kwh' => 'decimal:2',
    ];

    // Relacionamento: Um contador tem muitas recargas
    public function recargas(): HasMany
    {
        return $this->hasMany(Recarga::class);
    }

    // Relacionamento: Um contador tem muitos consumos
    public function consumos(): HasMany
    {
        return $this->hasMany(Consumo::class);
    }

    // ==================== MÉTODOS AUXILIARES ====================

    /**
     * Adicionar recarga ao contador
     */
    public function adicionarRecarga(string $codigo, float $valor, float $kwh): Recarga
    {
        $recarga = $this->recargas()->create([
            'codigo_recarga' => $codigo,
            'valor_mt' => $valor,
            'kwh' => $kwh,
            'data_recarga' => now(),
            'status' => 'confirmado'
        ]);

        // Atualizar saldo
        $this->increment('saldo_kwh', $kwh);

        return $recarga;
    }

    /**
     * Registrar consumo
     */
    public function registrarConsumo(float $kwh, float $potencia = null): void
    {
        $this->consumos()->create([
            'kwh_consumido' => $kwh,
            'potencia_kw' => $potencia,
            'data_hora' => now()
        ]);

        $this->decrement('saldo_kwh', $kwh);
    }

    /**
     * Calcular dias estimados de energia
     */
    public function calcularDiasEstimados(): int
    {
        // Média de consumo diário dos últimos 7 dias
        $consumoSemanal = $this->consumos()
            ->where('data_hora', '>=', now()->subDays(7))
            ->sum('kwh_consumido');

        $mediaDiaria = $consumoSemanal / 7;

        if ($mediaDiaria <= 0) {
            return 0;
        }

        return (int) ceil($this->saldo_kwh / $mediaDiaria);
    }

    /**
     * Obter consumo do dia atual
     */
    public function consumoHoje(): float
    {
        return $this->consumos()
            ->whereDate('data_hora', today())
            ->sum('kwh_consumido');
    }

    /**
     * Obter consumo semanal
     */
    public function consumoSemanal(): array
    {
        $dados = [];
        $diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

        for ($i = 6; $i >= 0; $i--) {
            $data = now()->subDays($i);
            $consumo = $this->consumos()
                ->whereDate('data_hora', $data)
                ->sum('kwh_consumido');

            $dados[] = [
                'day' => $diasSemana[$data->dayOfWeek],
                'kwh' => round($consumo, 2)
            ];
        }

        return $dados;
    }
}
