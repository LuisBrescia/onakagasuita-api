<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unidade extends Model
{
    use HasFactory;

    protected $table = 'unidades';

    protected $fillable = [
        'franquia_id',
        'nome_fantasia',
        'cidade',
        'logradouro',
        'cep',
        'telefone',
        'email',
        'foto',
        'ativo'
    ];

    public function franquia(): BelongsTo
    {
        return $this->belongsTo(Franquia::class);
    }

    public function usuarios()
    {
        // return $this->belongsToMany(Usuario::class, 'unidade_usuario', 'unidade_id', 'usuario_id');
        return $this->belongsToMany(Usuario::class, 'unidade_usuario', 'unidade_id', 'usuario_id')
            ->withPivot('tipo')
            ->withTimestamps()
            ->using(UnidadeUsuario::class);
    }
}
