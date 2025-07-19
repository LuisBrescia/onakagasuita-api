<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaoResource extends JsonResource
{
    /**
     * Transforma o recurso em um array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'unidade_id' => $this->unidade_id,
            'nome' => $this->nome,
            'ativo' => $this->ativo,
            'horario_funcionamento_inicio' => $this->horario_funcionamento_inicio,
            'horario_funcionamento_fim' => $this->horario_funcionamento_fim,
            'dias_funcionamento' => $this->dias_funcionamento,
        ];
    }
}
