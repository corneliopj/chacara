<?php namespace App\Http\Controllers; // Adicionei o namespace aqui se você estiver usando um namespace customizado no routes.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CulturaController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\TarefaController;

/*
|--------------------------------------------------------------------------
| Rotas do Aplicativo de Gestão Agrícola
|--------------------------------------------------------------------------
*/

// Rota principal (Redireciona para a listagem de culturas ou Dashboard)
Route::get('/', function () {
    return redirect()->route('culturas.index');
})->name('dashboard');

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

// --- CRUD DE RECEITAS ---


// --- CRUD DE TAREFAS (MANEJOS) ---
Route::resource('tarefas', TarefaController::class)->names([
    'index' => 'tarefas.index',
    'create' => 'tarefas.create',
    'store' => 'tarefas.store',
    'show' => 'tarefas.show',
    'edit' => 'tarefas.edit',
    'update' => 'tarefas.update',
    'destroy' => 'tarefas.destroy',
]);