<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MesaResource extends JsonResource
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
            'salao_id' => $this->salao_id,
            'numero_lugares' => $this->numero_lugares,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Inclui informações do salão associado, se carregado
            'salao' => new SalaoResource($this->whenLoaded('salao')),
        ];
    }
}
