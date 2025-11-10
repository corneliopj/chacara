<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Cultura;
use App\Models\Socio; // <--- NOVO: Importação do Model Socio
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class DespesaController extends Controller
{
    /**
     * Exibe a lista de despesas (Gerais e Vinculadas).
     */
    public function index()
    {
        // Otimização: Carrega 'cultura' e o novo relacionamento 'pagoPorSocio'
        $despesas = Despesa::with(['cultura', 'pagoPorSocio'])->orderBy('data', 'desc')->paginate(10);
        
        return view('despesas.index', compact('despesas'));
    }

    /**
     * Exibe o formulário para criar uma nova despesa (Geral ou Vinculada).
     */
    public function create()
    {
        $culturas = Cultura::orderBy('nome')->get(['id', 'nome']);
        
        // <--- NOVO: Carrega a lista de sócios
        $socios = Socio::orderBy('nome')->get(['id', 'nome']);
        
        $categorias = [
            'Insumo', 'Semente', 'Mão-de-Obra', 'Combustível', 'Eletricidade', 'Equipamento', 'Manutenção', 'Outro Geral'
        ];

        // <--- NOVO: Variável $socios adicionada ao compact
        return view('despesas.create', compact('culturas', 'categorias', 'socios'));
    }

    /**
     * Armazena uma nova despesa no banco de dados (Para formulários simples/gerais).
     */
    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'data' => 'required|date',
            'categoria' => 'required|string|max:100',
            'cultura_id' => 'nullable|exists:culturas,id',
            // <--- NOVO: Campo obrigatório e checa se existe na tabela 'socios'
            'pago_por_socio_id' => 'required|exists:socios,id', 
            'observacoes' => 'nullable|string',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'min' => 'O campo :attribute deve ser no mínimo :min.',
            'date' => 'O campo :attribute deve ser uma data válida.',
            'exists' => 'A Cultura/Sócio selecionado(a) é inválida.',
        ]);

        Despesa::create($request->all());

        return redirect()->route('despesas.index')
                         ->with('success', 'Despesa registrada com sucesso!');
    }

    /**
     * Armazena MÚLTIPLAS despesas em uma única transação (vindo do 'carrinho' da Cultura).
     */
    public function storeMultiCultura(Request $request)
    {
        $request->validate([
            'cultura_id' => 'required|exists:culturas,id',
            // <--- NOVO: Agora a Requisição deve trazer o ID do sócio pagador para o lote
            'pago_por_socio_id' => 'required|exists:socios,id', 
            'data_base' => 'required|date',
            'itens' => 'required|array|min:1',
            'itens.*.categoria' => 'required|string|max:100',
            'itens.*.descricao' => 'required|string|max:255',
            'itens.*.valor' => 'required|numeric|min:0.01',
        ]);

        $culturaId = $request->cultura_id;
        $dataBase = $request->data_base;
        $pagoPorSocioId = $request->pago_por_socio_id; // <--- NOVO: Captura o ID do pagador
        $dadosParaInserir = [];
        $agora = now();

        foreach ($request->itens as $item) {
            $dadosParaInserir[] = [
                'cultura_id' => $culturaId,
                'pago_por_socio_id' => $pagoPorSocioId, // <--- NOVO: Adiciona a cada item
                'data' => $dataBase,
                'categoria' => $item['categoria'],
                'descricao' => $item['descricao'],
                'valor' => $item['valor'],
                'created_at' => $agora,
                'updated_at' => $agora,
            ];
        }
        
        try {
            DB::beginTransaction();
            
            DB::table('despesas')->insert($dadosParaInserir); 

            DB::commit();

            return redirect()->route('culturas.edit', $culturaId)
                             ->with('success', count($dadosParaInserir) . ' despesas registradas na cultura com sucesso!');
        
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Não foi possível salvar as despesas: ' . $e->getMessage());
        }
    }
    
    /**
     * Exibe uma despesa específica (Opcional).
     */
    public function show(Despesa $despesa)
    {
        return view('despesas.show', compact('despesa'));
    }

    /**
     * Exibe o formulário de edição de uma despesa.
     */
    public function edit(Despesa $despesa)
    {
        $culturas = Cultura::orderBy('nome')->get(['id', 'nome']);
        // <--- NOVO: Carrega a lista de sócios
        $socios = Socio::orderBy('nome')->get(['id', 'nome']);
        $categorias = [
            'Insumo', 'Semente', 'Mão-de-Obra', 'Combustível', 'Eletricidade', 'Equipamento', 'Manutenção', 'Outro Geral'
        ];
        
        // <--- NOVO: Variável $socios adicionada ao compact
        return view('despesas.edit', compact('despesa', 'culturas', 'categorias', 'socios'));
    }

    /**
     * Atualiza a despesa no banco de dados.
     */
    public function update(Request $request, Despesa $despesa)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'data' => 'required|date',
            'categoria' => 'required|string|max:100',
            'cultura_id' => 'nullable|exists:culturas,id',
            // <--- NOVO: Validação para o campo de edição
            'pago_por_socio_id' => 'required|exists:socios,id', 
        ]);

        $despesa->update($request->all());

        return redirect()->route('despesas.index')
                         ->with('success', 'Despesa atualizada com sucesso!');
    }

    /**
     * Remove uma despesa do banco de dados.
     */
    public function destroy(Despesa $despesa)
    {
        $despesa->delete();

        return redirect()->route('despesas.index')
                         ->with('success', 'Despesa removida com sucesso!');
    }
}