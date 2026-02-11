<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recarga extends Model
{
    use HasFactory;

    protected $table = 'recargas';

    protected $fillable = [
        'contador_id',
        'codigo_recarga',
        'valor_mt',
        'kwh',
        'data_recarga',
        'status'
    ];

    protected $casts = [
        'valor_mt' => 'decimal:2',
        'kwh' => 'decimal:2',
        'data_recarga' => 'datetime',
    ];

    // Relacionamento: Uma recarga pertence a um contador
    public function contador(): BelongsTo
    {
        return $this->belongsTo(Contador::class);
    }
}
