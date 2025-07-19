<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Salao extends Model
{
    protected $table = 'saloes';

    protected $fillable = [
        'unidade_id',
        'nome',
        'ativo',
        'horario_funcionamento_inicio',
        'horario_funcionamento_fim',
        'dias_funcionamento',
        'layout_obj_id',
    ];

    protected $casts = [
        'horario_funcionamento_inicio' => 'datetime:H:i:s',
        'horario_funcionamento_fim' => 'datetime:H:i:s',
        'dias_funcionamento' => 'array',
        'layout' => 'array',
    ];

    public function mesas(): HasMany
    {
        return $this->hasMany(Mesa::class);
    }

    public function layout()
    {
        if (!$this->layout_obj_id) {
            return null;
        }
        return Layout::find($this->layout_obj_id);
    }


    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }

    public function estaAberto(Carbon $horario): bool
    {
        $horario = $horario ?? Carbon::now();

        if (!in_array($horario->dayOfWeek, $this->dias_funcionamento)) {
            return false;
        }

        $inicio = Carbon::parse($this->horario_funcionamento_inicio);
        $fim = Carbon::parse($this->horario_funcionamento_fim);

        return $horario->between($inicio, $fim);
    }
}
