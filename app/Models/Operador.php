<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Operador extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'operadores';

    protected $fillable = [
        'unidade_id',
        'login',
        'label',
        'senha',
        'token',
        'icon',
        'ativo',
        'horario_ativo_inicio',
        'horario_ativo_fim',
    ];

    protected $casts = [
        'horario_ativo_inicio' => 'datetime:H:i:s',
        'horario_ativo_fim' => 'datetime:H:i:s',
    ];

    protected function casts(): array
    {
        return [
            'horario_ativo_inicio' => 'datetime:H:i:s',
            'horario_ativo_fim' => 'datetime:H:i:s',
            'senha' => 'hashed',
        ];
    }

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }
}
