<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string',
            'email' => 'required|string',
            'cpf' => 'required|string',
            'telefone' => 'nullable|string',
        ]);

        $cliente = Cliente::create($validatedData);

        return (new ClienteResource($cliente))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $validatedData = $request->validate([
            'nome' => 'required|string',
            'email' => 'required|string',
            'cpf' => 'required|string',
            'telefone' => 'nullable|string',
        ]);

        $cliente->update($validatedData);

        return new ClienteResource($cliente);
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
