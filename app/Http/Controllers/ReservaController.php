<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;  
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaConfirmada;

class ReservaController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'cliente_id' => 'required|integer',
        'unidade_id' => 'required|integer',
        'salao_id' => 'required|integer',
        'horario_selecionado' => 'required|string',
        'num_mesas' => 'required|integer|min:1',
        'email' => 'required|email',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $reserva = Reserva::create([
        'cliente_id' => $request->cliente_id,
        'unidade_id' => $request->unidade_id,
        'salao_id' => $request->salao_id,
        'horario_selecionado' => $request->horario_selecionado,
        'num_mesas' => $request->num_mesas,
    ]);

    Mail::to($request->email)->send(new ReservaConfirmada($reserva));

    return response()->json(['message' => 'Reserva criada com sucesso!', 'reserva' => $reserva], 201);
}
}
