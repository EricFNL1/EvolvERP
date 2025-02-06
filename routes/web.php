<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\ClienteController;

Route::get('/clientes', [ClienteController::class, 'index']);
Route::post('/clientes', [ClienteController::class, 'store']);
Route::put('/clientes/{id}', [ClienteController::class, 'update']);
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);


Route::get('/movimentacoes', [MovimentacaoController::class, 'index']);
Route::post('/movimentacoes', [MovimentacaoController::class, 'store']);
Route::get('/movimentacoes/relatorio', [MovimentacaoController::class, 'relatorio']);
Route::post('/produtos/movimentar', [MovimentacaoController::class, 'store']);


// Rota principal redirecionando para o login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas de Produtos
Route::resource('produtos', ProdutoController::class)->except(['show']);
Route::get('/produtos/historico-geral', [ProdutoController::class, 'historicoGeral'])->name('produtos.historico-geral');
Route::get('/produtos/{id}/historico', [ProdutoController::class, 'historico'])->name('produtos.historico');
Route::get('/produtos', [ProdutoController::class, 'index']);
Route::post('/produtos', [ProdutoController::class, 'store']);
Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);
Route::get('/produtos/{id}/historico', [ProdutoController::class, 'historico']);

// Rotas para o módulo de estoque
Route::get('/estoque', [EstoqueController::class, 'index'])->name('estoque.index');
// Rotas de Usuários
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Rotas de Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas de Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Rotas para redefinição de senha
Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
