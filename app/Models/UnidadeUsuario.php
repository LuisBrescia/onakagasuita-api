<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Enums\UsuarioTipo;

class UnidadeUsuario extends Pivot
{
    protected $table = 'unidade_usuario';

    protected $casts = [
        'tipo' => UsuarioTipo::class,
    ];
}
