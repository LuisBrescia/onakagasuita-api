<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperadorResource extends JsonResource
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
            'login' => $this->login,
            'ativo' => $this->ativo,
            'icon' => $this->icon,
            'label' => $this->label,
        ];
    }
}
