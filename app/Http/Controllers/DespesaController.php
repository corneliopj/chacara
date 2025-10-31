<?php namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;

class DespesaController extends Controller
{
    // ... (index, edit, update, destroy - padrão CRUD)

    public function store(Request $request)
    {
        $dados = $request->validate([
            'valor' => 'required|numeric|min:0.01',
            'data' => 'required|date',
            'descricao' => 'required|string|max:255',
            'tipo' => 'required|in:cultura,geral',
            'cultura_id' => 'nullable|exists:culturas,id',
        ]);

        // 1. Cria a Despesa original. O Model Despesa cuida de somar gastos_acumulados.
        $despesa = Despesa::create($dados);
        
        // 2. Regra: Se tipo 'cultura', replica em despesa 'geral'
        if ($despesa->tipo === 'cultura' && $despesa->cultura_id) {
            Despesa::create([
                'valor' => $despesa->valor,
                'data' => $despesa->data,
                'descricao' => "Custo de Cultura (Geral - Ref: {$despesa->id}): {$despesa->descricao}",
                'tipo' => 'geral',
                'cultura_id' => null, // Esta é a cópia geral
            ]);
        }
        
        return redirect()->route('despesas.index')->with('sucesso', 'Despesa registrada com sucesso!');
    }
}