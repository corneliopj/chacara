<?php

namespace App\Http\Controllers;

use App\Models\Cultura;
use Illuminate\Http\Request;

// Nomes de Controllers, Views, Model ou tabelas no DB devem estar em português (brasil)
class CulturaController extends Controller
{
    /**
     * Exibe a lista de culturas.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Paginando 10 culturas por página
        $culturas = Cultura::orderBy('nome', 'asc')->paginate(10);
        
        // Assume que a view de listagem será resources/views/culturas/index.blade.php
        return view('culturas.index', compact('culturas'));
    }

    /**
     * Exibe o formulário para criar uma nova cultura.
     * Método atualmente ausente que causou o erro.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // A View de criação não precisa de variáveis extras por enquanto
        // Assume que a view será resources/views/culturas/create.blade.php
        return view('culturas.create');
    }

    /**
     * Armazena uma nova cultura no banco de dados.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:culturas,nome',
            'estoque_minimo' => 'nullable|integer|min:0',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O nome da cultura já está em uso.',
            'integer' => 'O estoque mínimo deve ser um número inteiro.',
        ]);

        Cultura::create($request->all());

        return redirect()->route('culturas.index')
                         ->with('success', 'Cultura cadastrada com sucesso!');
    }

    /**
     * Exibe os detalhes de uma cultura específica (Opcional, mas faz parte do Resource).
     */
    public function show(Cultura $cultura)
    {
        // Normalmente usado para exibir relatórios ou detalhes, por enquanto, apenas retorna para o edit.
        return redirect()->route('culturas.edit', $cultura);
    }
    
    /**
     * Exibe o formulário para editar uma cultura existente.
     */
    public function edit(Cultura $cultura)
    {
        return view('culturas.edit', compact('cultura'));
    }

    /**
     * Atualiza a cultura no banco de dados.
     */
    public function update(Request $request, Cultura $cultura)
    {
        $request->validate([
            // unique:table,column,except,idColumn
            'nome' => 'required|string|max:255|unique:culturas,nome,' . $cultura->id,
            'estoque_minimo' => 'nullable|integer|min:0',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O nome da cultura já está em uso.',
            'integer' => 'O estoque mínimo deve ser um número inteiro.',
        ]);

        $cultura->update($request->all());

        return redirect()->route('culturas.index')
                         ->with('success', 'Cultura atualizada com sucesso!');
    }

    /**
     * Remove uma cultura do banco de dados.
     */
    public function destroy(Cultura $cultura)
    {
        $cultura->delete();

        return redirect()->route('culturas.index')
                         ->with('success', 'Cultura removida com sucesso!');
    }
}