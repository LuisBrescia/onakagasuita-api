<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Resources\UsuarioAuthResource;
use App\Enums\UsuarioStatus;
use App\Enums\UsuarioTipo;
use App\Http\Resources\OperadorAuthResource;
use App\Models\Operador;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:usuarios,email'],
            'senha' => ['required', 'string', 'min:8'],
        ]);

        $data['senha'] = Hash::make($data['senha']);

        $user = Usuario::create($data);

        $userData = [
            'user' => new UsuarioAuthResource($user),
            'access_token' => $user->createToken('api', ['all'])->plainTextToken
        ];

        return response()->json($userData, 201);
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        $user = Usuario::where('email', $data['email'])->first();

        if (is_null($user)) {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'errors' => [
                    'email' => ['Usuário não encontrado']
                ]
            ], 422);
        }

        if ($user->status == UsuarioStatus::Suspenso) {
            return response()->json([
                'message' => 'Usuário suspenso, verifique sua caixa de e-mail sobre o motivo',
                'errors' => [
                    'email' => ['Usuário suspenso']
                ]
            ], 422);
        }

        if ($user->status == UsuarioStatus::Inativo) {
            return response()->json([
                'message' => 'Usuário inativo, entre em contato com o administrador',
                'errors' => [
                    'email' => ['Usuário inativo']
                ]
            ], 422);
        }

        if (!Hash::check($data['senha'], $user->senha)) {
            return response()->json([
                'message' => 'Senha incorreta',
                'errors' => [
                    'senha' => ['Senha incorreta']
                ]
            ], 422);
        }

        $responseUser = new UsuarioAuthResource($user);
        $responseToken = $user->createToken('api', [$user->tipo]);
        $userData = [
            'user' => $responseUser,
            'access_token' => $responseToken->plainTextToken
        ];

        return response()->json($userData, 201);
    }

    public function operadorLogin(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|string',
            'senha' => 'required|string',
        ]);

        $data['login'] = $data['email'];
        $operador = Operador::where('login', $data['login'])->first();

        if (is_null($operador)) {
            return response()->json([
                'message' => 'Operador não encontrado',
                'errors' => [
                    'login' => ['Operador não encontrado']
                ]
            ], 422);
        }

        if (!$operador->ativo) {
            return response()->json([
                'message' => 'Operador inativo',
                'errors' => [
                    'login' => ['Operador inativo']
                ]
            ], 422);
        }

        if (!Hash::check($data['senha'], $operador->senha)) {
            return response()->json([
                'message' => 'Senha incorreta',
                'errors' => [
                    'senha' => ['Senha incorreta']
                ]
            ], 422);
        }

        $responseUser = new OperadorAuthResource($operador);
        $responseToken = $operador->createToken('api', ['operador']);
        $userData = [
            'user' => $responseUser,
            'unidade' => $operador->unidade,
            'access_token' => $responseToken->plainTextToken
        ];

        return response()->json($userData, 201);
    }

    public function me()
    {
        return response()->json(new UsuarioAuthResource(Auth::user()));
    }

    public function logout()
    {
        $user = Auth::user();

        $tokensTable = config('sanctum.storage.database.table', 'personal_access_tokens');

        DB::table($tokensTable)
            ->where('tokenable_id', $user->id)
            ->where('tokenable_type', get_class($user))
            ->whereJsonContains('abilities', 'all')
            ->delete();

        return response()->json(null, 202);
    }
}
