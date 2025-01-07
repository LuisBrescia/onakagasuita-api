<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Http\Resources\MesaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class MesaController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'salao_id' => 'required|exists:saloes,id',
                'numero_lugares' => 'required|integer|min:1',
            ]);

            $mesa = Mesa::create($validatedData);

            return (new MesaResource($mesa))
                        ->response()
                        ->setStatusCode(Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the mesa.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index()
{
    try {
        $mesas = Mesa::all(); // Pega todas as mesas
        return MesaResource::collection($mesas); // Retorna uma coleção de mesas
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while fetching the mesas.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

    public function update(Request $request, $id)
    {
        try {
            $mesa = Mesa::findOrFail($id);

            $validatedData = $request->validate([
                'salao_id' => 'required|exists:saloes,id',
                'numero_lugares' => 'required|integer|min:1',
            ]);

            $mesa->update($validatedData);

            return new MesaResource($mesa);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Mesa not found.'], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the mesa.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $mesa = Mesa::findOrFail($id);
            $mesa->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Mesa not found.'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the mesa.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}