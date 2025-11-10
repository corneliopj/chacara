<?php

namespace App\Http\Controllers;

use App\Models\Cultura;
use App\Models\Despesa; // Usado no método edit
use App\Models\Socio; 
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
    // 1. Otimiza o carregamento dos dados financeiros para o Extrato
    $cultura->load(['despesas', 'receitas']); 

    // 2. Variáveis necessárias para os formulários de lançamento
    $unidades = ['Kg', 'Unidade', 'Saco', 'Litro', 'Caixa'];
    
    // Categorias para o formulário de Despesa
    $categorias = [ 
        'Insumo', 'Semente', 'Mão-de-Obra', 'Combustível', 'Eletricidade', 
        'Equipamento', 'Manutenção', 'Outro Geral'
    ]; 

    $socios = Socio::orderBy('nome')->get(['id', 'nome']); 

    // 3. Passando todas as variáveis necessárias para a view
    // <--- NOVO: Variável $socios adicionada aqui
    return view('culturas.edit', compact('cultura', 'unidades', 'categorias', 'socios'));
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
public function updateSociosQuota(Request $request, Cultura $cultura)
    {
        $cotas = $request->input('cotas');
        
        // 1. Validação básica de que todos os valores são numéricos e entre 0 e 100
        $validationRules = [];
        $validationMessages = [];
        foreach ($cotas as $socioId => $data) {
            $validationRules["cotas.$socioId.percentual_cota"] = 'required|numeric|min:0|max:100';
            $validationMessages["cotas.$socioId.percentual_cota.required"] = "O percentual do sócio $socioId é obrigatório.";
        }

        $request->validate($validationRules, $validationMessages);
        
        // 2. Validação se o total das cotas soma 100%
        $totalCotas = array_sum(array_column($cotas, 'percentual_cota'));

        if (abs($totalCotas - 100) > 0.01) { // Usamos uma pequena margem de erro (0.01) para float
            return redirect()->back()
                ->withInput()
                ->withErrors(['cotas_total' => 'A soma total dos percentuais deve ser exatamente 100% (Total atual: ' . number_format($totalCotas, 2, ',', '.') . '%).'])
                ->with('error', 'Erro de validação: A soma das cotas deve ser 100%.');
        }
        
        // 3. Preparar os dados para o sync
        $syncData = [];
        foreach ($cotas as $socioId => $data) {
            $syncData[$socioId] = ['percentual_cota' => $data['percentual_cota']];
        }

        try {
            // 4. Salva (cria/atualiza/deleta) os registros na tabela pivot (cultura_socio)
            $cultura->socios()->sync($syncData);

            return redirect()->route('culturas.edit', $cultura->id)
                ->with('success', 'Cotas de contribuição atualizadas com sucesso! (' . number_format($totalCotas, 2, ',', '.') . '%)');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao salvar as cotas: ' . $e->getMessage());
        }
    }
    // ... (Método destroy omitido)
}