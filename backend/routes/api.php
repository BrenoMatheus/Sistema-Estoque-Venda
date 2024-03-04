<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\GrupoPessoaController;
use App\Http\Controllers\GrupoProdutoController;


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::apiResources([
        'pessoa' => PessoaController::class,
        'produto' => ProdutoController::class,
        'compra' => CompraController::class,
        'venda' => VendaController::class,
        'marca' => MarcaController::class,
        'grupo_produto' => GrupoProdutoController::class,
        'grupo_pessoa' => GrupoPessoaController::class,
    ]);

    Route::put('compra/{id}/atualizar-quantidade', [CompraController::class, 'atualizarQuantidade']);
    Route::put('venda/{id}/atualizar-quantidade', [VendaController::class, 'atualizarQuantidade']);
});

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::delete('/user/{id}', [AuthController::class, 'destroy']);
    Route::get('/user/{id}', [AuthController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
