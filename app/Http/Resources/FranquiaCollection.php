<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FranquiaCollection extends ResourceCollection
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
            'data' => FranquiaResource::collection($this->collection),
        ];
    }

    /**
     * Adiciona meta dados adicionais à resposta.
     *
     * @param  Request  $request
     * @return array
     */
    // public function with($request)
    // {
    //     return [
    //         'meta' => [
    //             'current_page' => $this->resource->currentPage(),
    //             'from' => $this->resource->firstItem(),
    //             'last_page' => $this->resource->lastPage(),
    //             'path' => $this->resource->path(),
    //             'per_page' => $this->resource->perPage(),
    //             'to' => $this->resource->lastItem(),
    //             'total' => $this->resource->total(),
    //         ],
    //         'links' => [
    //             'first_page_url' => $this->resource->url(1),
    //             'last_page_url' => $this->resource->url($this->resource->lastPage()),
    //             'next_page_url' => $this->resource->nextPageUrl(),
    //             'prev_page_url' => $this->resource->previousPageUrl(),
    //         ],
    //     ];
    // }
}
