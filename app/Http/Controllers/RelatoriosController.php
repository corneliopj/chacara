<?php namespace App\Http\Controllers;

use App\Models\Cultura;
use App\Models\Despesa;
use App\Models\Receita;
use Illuminate\Http\Request;

class RelatoriosController extends Controller
{
    public function index(Request $request)
    {
        $culturas = Cultura::all(['id', 'nome', 'area']);
        $filtros = $request->all();
        $resultados = null;

        if ($request->isMethod('POST')) {
            $request->validate([
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
                'cultura_id' => 'nullable|exists:culturas,id',
            ]);

            $cultura_id = $filtros['cultura_id'] ?? null;
            
            // Query base para o período
            $query_despesas = Despesa::whereBetween('data', [$filtros['data_inicio'], $filtros['data_fim']]);
            $query_receitas = Receita::whereBetween('data', [$filtros['data_inicio'], $filtros['data_fim']]);
            
            // Aplica filtro de cultura se houver
            if ($cultura_id) {
                $query_despesas->where('cultura_id', $cultura_id);
                $query_receitas->where('cultura_id', $cultura_id);
            }
            
            $total_despesas = $query_despesas->sum('valor');
            $total_receitas = $query_receitas->sum('valor');
            $lucro = $total_receitas - $total_despesas;
            
            $resultados = [
                'total_despesas' => $total_despesas,
                'total_receitas' => $total_receitas,
                'lucro' => $lucro,
            ];
            
            // Cálculo Custo por Hectare
            if ($cultura_id) {
                $cultura = Cultura::find($cultura_id);
                if ($cultura && $cultura->area > 0) {
                    $resultados['custo_ha'] = $total_despesas / $cultura->area;
                    $resultados['cultura_nome'] = $cultura->nome;
                    $resultados['area'] = $cultura->area;
                }
            }
        }

        return view('relatorios.index', compact('culturas', 'resultados', 'filtros'));
    }
}