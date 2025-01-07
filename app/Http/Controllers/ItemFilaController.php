<?php

namespace App\Http\Controllers;

use App\Models\ItemFila;
use App\Http\Resources\ItemFilaResource;
use App\Http\Resources\ItemFilaCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItemFilaController extends Controller
{
    /**
     * Lista todos os itens da fila com paginação.
     *
     * @return ItemFilaCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $perPage = is_numeric($perPage) && $perPage > 0 ? (int)$perPage : 10;
        
        $itensFila = ItemFila::paginate($perPage);
        return new ItemFilaCollection($itensFila);
    }

    /**
     * Exibe um item específico da fila.
     *
     * @param  int  $id
     * @return ItemFilaResource
     */
    public function show($id)
    {
        $itemFila = ItemFila::findOrFail($id);
        return new ItemFilaResource($itemFila);
    }

    /**
     * Cria um novo item na fila.
     *
     * @param  Request  $request
     * @return ItemFilaResource
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'unidade_id' => 'required|exists:unidades,id',
            'cliente_id' => 'required|exists:clientes,id',
            'numero_pessoas' => 'required|integer|min:1',
            'tempo_na_fila' => 'required|integer|min:0',
        ]);

        $itemFila = ItemFila::create($validatedData);

        return (new ItemFilaResource($itemFila))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Atualiza um item existente na fila.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return ItemFilaResource
     */
    public function update(Request $request, $id)
    {
        $itemFila = ItemFila::findOrFail($id);

        $validatedData = $request->validate([
            'unidade_id' => 'sometimes|required|exists:unidades,id',
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'numero_pessoas' => 'sometimes|required|integer|min:1',
            'tempo_na_fila' => 'sometimes|required|integer|min:0',
        ]);

        $itemFila->update($validatedData);

        return new ItemFilaResource($itemFila);
    }

    /**
     * Remove um item da fila.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $itemFila = ItemFila::findOrFail($id);
        $itemFila->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
