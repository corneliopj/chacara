<?php

namespace App\Http\Controllers;

use App\Models\Cultura;
use App\Models\Inventario; // Assumindo que você tem um modelo Inventario
use App\Models\Receita; // Para dados do dashboard
use App\Models\Despesa; // Para dados do dashboard
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Necessário para a subconsulta

class DashboardController extends Controller
{
    /**
     * Exibe a página principal do Dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Cálculo de Alerta de Estoque (CORRIGIDO AQUI)
        // Alterado de 'inventarios.item' para 'inventario.item' para corresponder ao FROM "inventario"
        $alertas_estoque = Inventario::where('quantidade', '<', function ($query) {
            $query->select('estoque_minimo')
                  ->from('culturas')
                  ->whereRaw('culturas.nome = inventario.item') // <--- CORREÇÃO
                  ->limit(1);
        })->get(['item', 'quantidade', 'valor_unitario']);

        // 2. Cálculo do Balanço Financeiro (Exemplo)
        $total_receitas = Receita::sum('valor');
        $total_despesas = Despesa::sum('valor');
        $balanco_geral = $total_receitas - $total_despesas;

        // 3. Culturas com maior despesa (Exemplo de agregação)
        $culturas_mais_caras = Despesa::select('cultura_id', DB::raw('SUM(valor) as total_despesa'))
            ->groupBy('cultura_id')
            ->orderByDesc('total_despesa')
            ->with('cultura')
            ->limit(5)
            ->get();

        return view('dashboard.index', [
            'alertas_estoque' => $alertas_estoque,
            'total_receitas' => $total_receitas,
            'total_despesas' => $total_despesas,
            'balanco_geral' => $balanco_geral,
            'culturas_mais_caras' => $culturas_mais_caras,
        ]);
    }
}