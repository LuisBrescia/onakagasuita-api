<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnidadeResource extends JsonResource
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
            'franquia_id' => $this->franquia_id,
            'nome_fantasia' => $this->nome_fantasia,
            'cidade' => $this->cidade,
            'logradouro' => $this->logradouro,
            'cep' => $this->cep,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'foto' => $this->foto,
            'ativo' => $this->ativo,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            // Inclui informações da franquia associada, se carregada
            // 'franquia' => new FranquiaResource($this->whenLoaded('franquia')),
        ];
    }
}
