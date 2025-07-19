<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FranquiaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\SalaoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\OperadorController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AuthController;


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

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('login/operador', [AuthController::class, 'operadorLogin']);
});

Route::post('reservas', [ReservaController::class, 'store']);

Route::get('unidades/all', [UnidadeController::class, 'all']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('franquias', FranquiaController::class);
    Route::resource('unidades', UnidadeController::class);
    Route::resource('saloes', SalaoController::class);
    Route::resource('mesas', MesaController::class);
    Route::resource('operadores', OperadorController::class);

    Route::prefix('auth')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

    Route::get('saloes/{salaoId}/layout', [SalaoController::class, 'showLayout']);
    Route::post('saloes/{salaoId}/layout', [SalaoController::class, 'storeLayout']);
});
