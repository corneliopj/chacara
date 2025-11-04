<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Cultura;
use Illuminate\Http\Request;

class DespesaController extends Controller
{
    /**
     * Exibe a lista de despesas (Gerais e Vinculadas).
     */
    public function index()
    {
        // Obtém todas as despesas e pagina.
        // O método with('cultura') otimiza o carregamento do nome da cultura.
        $despesas = Despesa::with('cultura')->orderBy('data', 'desc')->paginate(10);
        
        return view('despesas.index', compact('despesas'));
    }

    /**
     * Exibe o formulário para criar uma nova despesa (Geral ou Vinculada).
     */
    public function create()
    {
        // Lista de culturas para o campo de seleção
        $culturas = Cultura::orderBy('nome')->get(['id', 'nome']);
        
        // Categorias predefinidas para facilitar o controle
        $categorias = [
            'Insumo', 'Semente', 'Mão-de-Obra', 'Combustível', 'Eletricidade', 'Equipamento', 'Manutenção', 'Outro Geral'
        ];

        return view('despesas.create', compact('culturas', 'categorias'));
    }

    /**
     * Armazena uma nova despesa no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'data' => 'required|date',
            'categoria' => 'required|string|max:100', // Campo Categoria agora é obrigatório
            'cultura_id' => 'nullable|exists:culturas,id', // Pode ser NULL para despesa geral
            'observacoes' => 'nullable|string',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'min' => 'O campo :attribute deve ser no mínimo :min.',
            'date' => 'O campo :attribute deve ser uma data válida.',
            'exists' => 'A Cultura selecionada é inválida.',
        ]);

        Despesa::create($request->all());

        return redirect()->route('despesas.index')
                         ->with('success', 'Despesa registrada com sucesso!');
    }

    // ... (Métodos show, edit, update, destroy seriam adicionados aqui)
}