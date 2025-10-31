<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CulturaController;
use App\Http\Controllers\DespesaController; // <-- ADICIONE ESTA LINHA

/*
|--------------------------------------------------------------------------
| Rotas do Aplicativo
|--------------------------------------------------------------------------
*/

// Rota principal (pode ser o Dashboard ou a listagem de culturas)
Route::get('/', function () {
    return redirect()->route('culturas.index');
});

// Rotas RESTful para o CRUD de Culturas
Route::resource('culturas', CulturaController::class)->names([
    'index' => 'culturas.index',
    'create' => 'culturas.create',
    'store' => 'culturas.store',
    'show' => 'culturas.show',
    'edit' => 'culturas.edit',
    'update' => 'culturas.update',
    'destroy' => 'culturas.destroy',
]);

// Rotas RESTful para o CRUD de Despesas
Route::resource('despesas', DespesaController::class)->names([
    'index' => 'despesas.index',
    'create' => 'despesas.create',
    'store' => 'despesas.store',
    'show' => 'despesas.show',
    'edit' => 'despesas.edit',
    'update' => 'despesas.update',
    'destroy' => 'despesas.destroy',
]);