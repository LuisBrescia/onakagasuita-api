<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->id)) {
            return $this->jsonReturn($this);
        }

        return $this->resource->map(function ($item) {
            return $this->jsonReturn($item);
        });
    }

    public function jsonReturn($item)
    {
        return [
            'id' => $item->id,
            'nome' => $item->nome,
            'email' => $item->email,
            'status' => $item->status,
            'tipo' => $item->tipo
        ];
    }
}
