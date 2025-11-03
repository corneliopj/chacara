<?php namespace App\Http\Controllers;

use App\Models\Cultura;
use App\Models\Despesa;
use App\Models\Receita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    /**
     * Exibe o relatório de Balanço Financeiro por Cultura.
     */
    public function financeiroPorCultura()
    {
        $culturas = Cultura::with(['receitas', 'despesas'])->get();
        
        $balanco = $culturas->map(function ($cultura) {
            $totalReceitas = $cultura->receitas->sum('valor');
            $totalDespesas = $cultura->despesas->sum('valor');
            $lucroLiquido = $totalReceitas - $totalDespesas;

            return [
                'nome' => $cultura->nome,
                'area_ha' => $cultura->area_ha,
                'data_plantio' => $cultura->data_plantio->format('d/m/Y'),
                'total_receitas' => $totalReceitas,
                'total_despesas' => $totalDespesas,
                'lucro_liquido' => $lucroLiquido,
            ];
        });

        // Adiciona um balanço para lançamentos "Gerais" (sem cultura_id)
        $receitasGerais = Receita::whereNull('cultura_id')->sum('valor');
        $despesasGerais = Despesa::whereNull('cultura_id')->sum('valor');
        
        $balancoGeral = [
            'nome' => 'Geral (Sem Associação)',
            'area_ha' => '-',
            'data_plantio' => '-',
            'total_receitas' => $receitasGerais,
            'total_despesas' => $despesasGerais,
            'lucro_liquido' => $receitasGerais - $despesasGerais,
        ];

        return view('relatorios.financeiro_cultura', compact('balanco', 'balancoGeral'));
    }
}