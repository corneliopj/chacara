<?php

namespace App\Http\Controllers;

use App\Models\Cultura;
use App\Models\Despesa; // Usado no método edit
use Illuminate\Http\Request;

class CulturaController extends Controller
{
    /**
     * Exibe a lista de culturas com sumário de custos e receitas.
     */
    public function index()
    {
        $culturas = Cultura::withSum('despesas', 'valor')
                            ->withSum('receitas', 'valor')
                            ->orderBy('nome', 'asc')
                            ->paginate(10);
        
        return view('culturas.index', compact('culturas'));
    }

    /**
     * Exibe o formulário para criar uma nova cultura.
     */
    public function create()
    {
        return view('culturas.create');
    }

    /**
     * Armazena uma nova cultura no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:culturas,nome',
            'area_m2' => 'required|numeric|min:0.01', // <--- CAMPO NOVO/ALTERADO
            'data_plantio' => 'required|date',
            'colheita_prevista' => 'nullable|date|after_or_equal:data_plantio',
            'status' => 'required|string|in:Ativa,Plantio Pendente,Colheita,Finalizada',
            'estoque_minimo' => 'nullable|integer|min:0',
            'observacoes' => 'nullable|string',
        ], [
            // Mensagens de erro
        ]);

        Cultura::create($request->all());

        return redirect()->route('culturas.index')
                         ->with('success', 'Cultura cadastrada com sucesso!');
    }

    // ... (Método show omitido)

    /**
     * Carrega a Cultura e suas Despesas para edição e detalhes.
     */
    public function edit(Cultura $cultura)
    {
        // Carrega despesas e receitas para o painel de edição
        $cultura->load(['despesas', 'receitas']); 

        // Categorias para o formulário de Despesa Direta
        $categorias = [
            'Insumo', 'Semente', 'Mão-de-Obra', 'Combustível', 'Eletricidade', 'Equipamento', 'Manutenção', 'Outro Geral'
        ];
        
        return view('culturas.edit', compact('cultura', 'categorias'));
    }

    /**
     * Atualiza a cultura no banco de dados.
     */
    public function update(Request $request, Cultura $cultura)
{
    // 🚨 Validação completa com base no seu Model $fillable
    $request->validate([
        'nome' => 'required|string|max:255',
        'area_m2' => 'required|numeric|min:0.01',
        'data_plantio' => 'required|date',         // <-- Adicionado
        'colheita_prevista' => 'nullable|date',    // <-- Adicionado (Assumindo que pode ser nulo)
        'status' => 'required|string',             // <-- Adicionado
        'estoque_minimo' => 'nullable|numeric',    // <-- Adicionado (Assumindo que pode ser nulo)
        'observacoes' => 'nullable|string',        // <-- Adicionado
    ]);
    
    try {
        // Se a validação e o $fillable estiverem corretos, a atualização deve funcionar
        $cultura->update($request->all()); 
        
        return redirect()
            ->route('culturas.edit', $cultura->id)
            ->with('success', 'Cultura atualizada com sucesso!');
    
    } catch (\Exception $e) {
        // Captura e exibe o erro exato, se houver um problema no DB (pouco provável agora)
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Erro ao atualizar a Cultura: ' . $e->getMessage());
    }
}

    // ... (Método destroy omitido)
}