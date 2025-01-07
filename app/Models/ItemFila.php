<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemFila extends Model 
{
    use HasFactory;

    protected $table = 'item_fila';

    protected $fillable = [
        'unidade_id',
        'cliente_id',
        'numero_pessoas',
        'tempo_na_fila',
    ];

    /**
     * Relacionamento com a unidade.
     * Um item da fila pertence a uma unidade.
     */
    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }

    /**
     * Relacionamento com o cliente.
     * Um item da fila pertence a um cliente.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}