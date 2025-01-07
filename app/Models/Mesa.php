<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mesa extends Model
{
    protected $table = 'mesas';

    protected $fillable = [
        'salao_id',
        'numero_lugares',
        'min_lugares',
        'max_lugares',
        'ativo',
        'layout',
    ];

    public function salao(): BelongsTo
    {
        return $this->belongsTo(Salao::class);
    }
}
