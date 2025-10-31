<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\ReceitaController;
use App\Http\Controllers\CulturaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\RelatoriosController;

// Rota Principal
Route::redirect('/', '/dashboard');

// Dashboard e API
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/api/graficos', [DashboardController::class, 'apiGraficos'])->name('api.graficos');

// CRUDs
Route::resource('culturas', CulturaController::class);
Route::resource('despesas', DespesaController::class);
Route::resource('receitas', ReceitaController::class);
Route::resource('inventario', InventarioController::class);
Route::resource('tarefas', TarefaController::class); // Tarefas: CRUD

// Relatórios (POST para envio de filtros)
Route::match(['get', 'post'], '/relatorios', [RelatoriosController::class, 'index'])->name('relatorios.index');