<?php

namespace App\Http\Controllers;

use App\Models\Salao;
use App\Models\Unidade;
use App\Http\Resources\SalaoResource;
use App\Http\Resources\SalaoCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaoController extends Controller
{
    /**
     * Lista todas os saloes com paginação.
     *
     * @return UnidadeCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $perPage = is_numeric($perPage) && $perPage > 0 ? (int)$perPage : 10;

        $unidadeId = $request->header('X-UID');

        if (!$unidadeId || !is_numeric($unidadeId)) {
            return response()->json(['error' => 'Cabeçalho X-UID é obrigatório'], 400);
        }

        $saloes = Salao::where('unidade_id', $unidadeId)->paginate($perPage);

        return new SalaoCollection($saloes);
    }

    public function show($id)
    {
        $salao = Salao::findOrFail($id);
        return new SalaoResource($salao);
    }

    public function store(Request $request)
    {
        $unidadeId = $request->header('X-UID');

        if (!$unidadeId || !is_numeric($unidadeId)) {
            return response()->json(['error' => 'Necessário enviar X-UID'], 400);
        }

        // > TODO @GustavoPereira @VictorReisCarlota: Validar se usuário autenticado tem permissão para criar salão naquela unidade

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'dias_funcionamento' => 'required|array',
            'dias_funcionamento.*' => 'integer|between:0,6',
            'ativo' => 'required|boolean',
            'horario_funcionamento_inicio' => 'required|date_format:H:i',
            'horario_funcionamento_fim' => [
                'required',
                'date_format:H:i',
                'after:horario_funcionamento_inicio',
            ],
        ]);

        $unidade = Unidade::find($unidadeId);

        if (!$unidade) {
            return response()->json(['message' => 'Unidade não encontrada'], 404);
        }

        $validatedData['unidade_id'] =  $unidade->id;
        $salao = Salao::create($validatedData);
        return response()->json($salao, 201);
    }

    public function update(Request $request, $id)
    {
        $salao = Salao::find($id);

        if (!$salao) {
            return response()->json(['message' => 'Salão não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nome' => 'string|max:255',
            'ativo' => 'boolean',
            'horario_funcionamento_inicio' => 'date_format:H:i',
            'horario_funcionamento_fim' => [
                'date_format:H:i',
                'after:horario_funcionamento_inicio',
            ],
            'dias_funcionamento' => 'array',
            'dias_funcionamento.*' => 'integer|between:0,6',
        ]);

        $salao->update($validatedData);

        return response()->json($salao);
    }

    public function destroy($id)
    {
        $salao = Salao::find($id);

        if (!$salao) {
            return response()->json(['message' => 'Salão não encontrado'], 404);
        }

        DB::transaction(function () use ($salao) {
            // $salao->mesas()->delete();
            $salao->delete();
        });

        return response()->json(['message' => 'Salão e mesas associadas deletados com sucesso']);
    }

    public function showLayout(Request $request, $salaoId)
    {
        $salao = Salao::findOrFail($salaoId);
        return response()->json($salao->layout === null ? [] : $salao->layout, 200);
    }

    public function storeLayout(Request $request, $salaoId)
    {

        $layout = $request->all();

        $salao = Salao::findOrFail($salaoId);
        $salao->layout = $layout;
        $salao->save();

        return response()->json(['message' => 'Mesas armazenadas com sucesso!', 'salao' => $salao], 200);
    }
}
