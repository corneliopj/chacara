<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CulturaController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\ReceitaController; // <-- ADICIONE ESTE
use App\Http\Controllers\TarefaController; // <-- ADICIONE ESTE
use App\Http\Controllers\DashboardController; // <-- ADICIONE ESTE (se não estiver lá)
use App\Http\Controllers\RelatorioController; // <-- ADICIONE ESTE (se não estiver lá)


/*
|--------------------------------------------------------------------------
| Rotas do Aplicativo de Gestão Agrícola
|--------------------------------------------------------------------------
*/

// Rota principal (Agora aponta para o Dashboard)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); // Alterado para ir diretamente ao Dashboard

// --- CRUD DE CULTURAS ---
Route::resource('culturas', CulturaController::class)->names([
    'index' => 'culturas.index',
    'create' => 'culturas.create',
    'store' => 'culturas.store',
    'show' => 'culturas.show',
    'edit' => 'culturas.edit',
    'update' => 'culturas.update',
    'destroy' => 'culturas.destroy',
]);

// --- CRUD DE DESPESAS ---
Route::resource('despesas', DespesaController::class)->names([
    'index' => 'despesas.index',
    'create' => 'despesas.create',
    'store' => 'despesas.store',
    'show' => 'despesas.show',
    'edit' => 'despesas.edit',
    'update' => 'despesas.update',
    'destroy' => 'despesas.destroy',
]);

// --- CRUD DE RECEITAS --- // <-- NOVO BLOCO
Route::resource('receitas', ReceitaController::class)->names([
    'index' => 'receitas.index',
    'create' => 'receitas.create',
    'store' => 'receitas.store',
    'show' => 'receitas.show',
    'edit' => 'receitas.edit',
    'update' => 'receitas.update',
    'destroy' => 'receitas.destroy',
]);

// --- CRUD DE TAREFAS --- // <-- NOVO BLOCO
Route::resource('tarefas', TarefaController::class)->names([
    'index' => 'tarefas.index',
    'create' => 'tarefas.create',
    'store' => 'tarefas.store',
    'show' => 'tarefas.show',
    'edit' => 'tarefas.edit',
    'update' => 'tarefas.update',
    'destroy' => 'tarefas.destroy',
]);

// --- ROTAS DE RELATÓRIOS --- // <-- NOVO BLOCO
Route::get('relatorios/financeiro-cultura', [RelatorioController::class, 'financeiroPorCultura'])->name('relatorios.financeiro_cultura');