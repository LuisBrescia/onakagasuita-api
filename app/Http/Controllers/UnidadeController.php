<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Http\Resources\UnidadeResource;
use App\Http\Resources\UnidadeCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Enums\UsuarioTipo;

class UnidadeController extends Controller
{
    /**
     * Lista todas as unidades com paginação.
     *
     * @return UnidadeCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $perPage = is_numeric($perPage) && $perPage > 0 ? (int)$perPage : 10;

        $user = $request->user();
        $unidades = $user->unidades()->paginate($perPage);

        return new UnidadeCollection($unidades);
    }

    /**
     * Exibe uma unidade específica.
     *
     * @param  int  $id
     * @return UnidadeResource
     */
    public function show($id)
    {
        $unidade = Unidade::findOrFail($id);
        return new UnidadeResource($unidade);
    }

    /**
     * Cria uma nova unidade.
     *
     * @param  Request  $request
     * @return UnidadeResource
     */
    public function store(Request $request)
    {
        $user = $request->user(); // ou $user = Auth::user();
        // 'franquia_id' => 'required|exists:franquias,id',
        $validatedData = $request->validate([
            'nome_fantasia' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'logradouro' => 'required|string|max:255',
            'cep' => 'required|string|max:20',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'foto' => 'nullable|string',
            'ativo' => 'boolean',
        ]);

        // * Tirando todos caracteres não numéricos do telefone
        $validatedData['telefone'] = preg_replace('/\D/', '', $validatedData['telefone']);
        $unidade = Unidade::create($validatedData);

        $unidade->usuarios()->attach($user->id, [
            'tipo' => UsuarioTipo::Admin->value, // Usando o Enum UsuarioTipo
        ]);

        return (new UnidadeResource($unidade))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Atualiza uma unidade existente.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return UnidadeResource
     */
    public function update(Request $request, $id)
    {
        $unidade = Unidade::findOrFail($id);

        $validatedData = $request->validate([
            'franquia_id' => 'sometimes|required|exists:franquias,id',
            'nome_fantasia' => 'sometimes|required|string|max:255',
            'cidade' => 'sometimes|required|string|max:255',
            'logradouro' => 'sometimes|required|string|max:255',
            'cep' => 'sometimes|required|string|max:20',
            'telefone' => 'sometimes|required|string|max:20',
            'email' => 'sometimes|required|email|max:255',
            'foto' => 'nullable|string|max:255',
            'ativo' => 'boolean',
        ]);

        $unidade->update($validatedData);

        return new UnidadeResource($unidade);
    }

    /**
     * Remove uma unidade.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $unidade = Unidade::findOrFail($id);
        $unidade->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Lista todas as unidades com paginação sem middleware.
     *
     * @return UnidadeCollection
     */
    public function all(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $perPage = is_numeric($perPage) && $perPage > 0 ? (int)$perPage : 10;

        $unidades = Unidade::paginate($perPage);

        return new UnidadeCollection($unidades);
    }
}
