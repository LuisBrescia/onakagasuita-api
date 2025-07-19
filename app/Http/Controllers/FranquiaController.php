<?php

namespace App\Http\Controllers;

use App\Models\Franquia;
use App\Http\Resources\FranquiaResource;
use App\Http\Resources\FranquiaCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FranquiaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $perPage = is_numeric($perPage) && $perPage > 0 ? (int)$perPage : 10;
        
        $franquias = Franquia::paginate($perPage);
        return new FranquiaCollection($franquias);
    }

    public function show($id)
    {
        $franquia = Franquia::findOrFail($id);
        return new FranquiaResource($franquia);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_fantasia' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'descricao' => 'required|string',
            'info_adicional' => 'nullable|string',
            'logo' => 'nullable|string',
        ]);

        $franquia = Franquia::create($validatedData);

        return (new FranquiaResource($franquia))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $franquia = Franquia::findOrFail($id);

        $validatedData = $request->validate([
            'nome_fantasia' => 'sometimes|required|string|max:255',
            'categoria' => 'sometimes|required|string|max:255',
            'descricao' => 'sometimes|required|string',
            'info_adicional' => 'nullable|string',
            'logo' => 'nullable|string',
        ]);

        $franquia->update($validatedData);

        return new FranquiaResource($franquia);
    }

    public function destroy($id)
    {
        $franquia = Franquia::findOrFail($id);
        $franquia->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
