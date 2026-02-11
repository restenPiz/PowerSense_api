<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consumo extends Model
{
    use HasFactory;

    protected $table = 'consumos';

    protected $fillable = [
        'contador_id',
        'kwh_consumido',
        'potencia_kw',
        'data_hora'
    ];

    protected $casts = [
        'kwh_consumido' => 'decimal:2',
        'potencia_kw' => 'decimal:2',
        'data_hora' => 'datetime',
    ];

    public $timestamps = false; // Apenas created_at

    // Relacionamento: Um consumo pertence a um contador
    public function contador(): BelongsTo
    {
        return $this->belongsTo(Contador::class);
    }
}
