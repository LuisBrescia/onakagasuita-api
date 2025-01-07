<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperadorCollection extends JsonResource
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
            'login' => $item->login,
            'label' => $item->label,
            'icon' => $item->icon,
            'unidade_id' => $item->unidade_id,
            'ativo' => $item->ativo,
        ];
    }
}
