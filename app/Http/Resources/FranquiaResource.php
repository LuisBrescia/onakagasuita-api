<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FranquiaResource extends JsonResource
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
            'nome_fantasia' => $this->nome_fantasia,
            'categoria' => $this->categoria,
            'descricao' => $this->descricao,
            'info_adicional' => $this->info_adicional,
            'logo' => $this->logo,
            'unidades' => $this->unidades,
        ];
    }
}
