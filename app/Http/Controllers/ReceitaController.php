<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use App\Models\Cultura; // Importação necessária para listar as culturas
use Illuminate\Http\Request;

class ReceitaController extends Controller
{
    /**
     * Exibe a lista de receitas (todas as vendas).
     */
    public function index()
    {
        // Obtém todas as receitas, otimizando o carregamento da Cultura
        $receitas = Receita::with('cultura')->orderBy('data_venda', 'desc')->paginate(10);
        
        return view('receitas.index', compact('receitas'));
    }

    /**
     * Exibe o formulário para criar uma nova receita.
     */
    public function create()
    {
        // Lista TODAS as culturas (independente do status) para garantir que apareçam no select.
        // O campo agora é opcional, permitindo "Receita Geral".
        $culturas = Cultura::orderBy('nome')->get(['id', 'nome']);
                            
        $unidades = ['Kg', 'Unidade', 'Saco', 'Litro', 'Caixa'];

        return view('receitas.create', compact('culturas', 'unidades'));
    }

    /**
     * Armazena uma nova receita no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            // CORREÇÃO: cultura_id agora é opcional (nullable) para permitir Receitas Gerais
            'cultura_id' => 'nullable|exists:culturas,id',
            'data_venda' => 'required|date',
            'descricao' => 'required|string|max:255',
            'quantidade_vendida' => 'required|numeric|min:0.01',
            'unidade_medida' => 'required|string|max:50',
            'valor' => 'required|numeric|min:0.01',
            'observacoes' => 'nullable|string',
            'socio_depositante_id' => 'nullable|exists:socios,id',
        ]);
        if (empty($request->quantidade_vendida) || $request->quantidade_vendida == 0) {
            $request->merge(['quantidade_vendida' => 0, 'unidade_medida' => null]);
        }
        Receita::create($request->all());

        return redirect()->route('receitas.index')
                         ->with('success', 'Receita de venda registrada com sucesso!');
    }

    /**
     * Exibe o formulário de edição de uma receita.
     */
    public function edit(Receita $receita)
    {
        // Lista TODAS as culturas
        $culturas = Cultura::orderBy('nome')->get(['id', 'nome']);
        $unidades = ['Kg', 'Unidade', 'Saco', 'Litro', 'Caixa'];

        return view('receitas.edit', compact('receita', 'culturas', 'unidades'));
    }

    /**
     * Atualiza a receita no banco de dados.
     */
    public function update(Request $request, Receita $receita)
    {
        $request->validate([
            // CORREÇÃO: cultura_id agora é opcional (nullable)
            'cultura_id' => 'nullable|exists:culturas,id',
            'data_venda' => 'required|date',
            'descricao' => 'required|string|max:255',
            'quantidade_vendida' => 'required|numeric|min:0.01',
            'unidade_medida' => 'required|string|max:50',
            'valor' => 'required|numeric|min:0.01',
            'observacoes' => 'nullable|string',
        ]);
        
        $receita->update($request->all());

        return redirect()->route('receitas.index')
                         ->with('success', 'Receita atualizada com sucesso!');
    }

    /**
     * Remove uma receita do banco de dados.
     */
    public function destroy(Receita $receita)
    {
        $receita->delete();

        return redirect()->route('receitas.index')
                         ->with('success', 'Receita removida com sucesso!');
    }
}