<?php

namespace App\Http\Controllers;

use App\Models\Operador;
use App\Http\Resources\OperadorResource;
use App\Http\Resources\OperadorCollection;
use App\Http\Resources\OperadorAuthResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OperadorController extends Controller
{
    /**
     * Lista todas os saloes com paginação.
     *
     * @return OperadorCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $perPage = is_numeric($perPage) && $perPage > 0 ? (int)$perPage : 10;

        $unidadeId = $request->header('X-UID');

        if (!$unidadeId || !is_numeric($unidadeId)) {
            return response()->json(['error' => 'Cabeçalho X-UID é obrigatório'], 400);
        }

        $operadores = Operador::where('unidade_id', $unidadeId)->paginate($perPage);

        return new OperadorCollection($operadores);
    }

    public function show($id)
    {
        $operador = Operador::findOrFail($id);
        return new OperadorResource($operador);
    }

    public function store(Request $request)
    {
        $unidade_id = $request->header('X-UID');

        if (!$unidade_id || !is_numeric($unidade_id)) {
            return response()->json(['error' => 'Necessário enviar X-UID'], 400);
        }

        $validatedData = $request->validate([
            'login' => 'required|string|min:3|max:255|unique:operadores',
            'senha' => 'required|string|min:6|max:255',
            'label' => 'required|string|min:3|max:255',
        ]);

        $validatedData['senha'] = Hash::make($validatedData['senha']);
        $validatedData['unidade_id'] = (int) $unidade_id;

        $operador = Operador::create($validatedData);

        $operadorData = [
            'operador' => new OperadorAuthResource($operador),
            'access_token' => $operador->createToken('api', ['operador'])->plainTextToken
        ];

        return response()->json($operadorData, 201);
    }


    public function update(Request $request, $id)
    {
        $operador = Operador::find($id);

        if (!$operador) {
            return response()->json(['message' => 'Operador não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'login' => 'string|min:3|max:255|unique:operadores,login,' . $id,
            'label' => 'string|min:3|max:255',
            'icon' => 'string|min:3|max:255',
        ]);

        $operador->update($validatedData);

        return response()->json($operador);
    }

    public function destroy($id)
    {
        $operador = Operador::find($id);

        if (!$operador) {
            return response()->json(['message' => 'Operador não encontrado'], 404);
        }

        DB::transaction(function () use ($operador) {
            $operador->delete();
        });

        return response()->json(['message' => 'Operador deletado com sucesso']);
    }
}
