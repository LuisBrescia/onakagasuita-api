<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FranquiaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\SalaoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\OperadorController;
use App\Http\Controllers\ReservaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('operador/login', [\App\Http\Controllers\AuthController::class, 'operadorLogin']);
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/reservas', [ReservaController::class, 'store']);

Route::get('unidades/all', [UnidadeController::class, 'all']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('franquias', FranquiaController::class);
    Route::resource('unidades', UnidadeController::class);
    Route::resource('saloes', SalaoController::class);
    Route::resource('mesas', MesaController::class);
    Route::resource('operadores', OperadorController::class);

    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    Route::get('saloes/{salaoId}/layout', [SalaoController::class, 'showLayout']);
    Route::post('saloes/{salaoId}/layout', [SalaoController::class, 'storeLayout']);
});
