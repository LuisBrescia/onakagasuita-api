<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Franquia extends Model 
{
    use HasFactory;

    protected $table = 'franquias';

    protected $fillable = [
        'nome_fantasia',
        'categoria',
        'descricao',
        'info_adicional',
        'logo',
    ];

    public function unidades(): HasMany
    {
        return $this->hasMany(Unidade::class);
    }
}