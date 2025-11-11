<?php

namespace App\Http\Controllers;

use App\Models\Cultura;
use App\Models\Inventario; 
use App\Models\Receita; 
use App\Models\Despesa; 
use App\Models\Socio; // NOVO: Importar o modelo Socio
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class DashboardController extends Controller
{
    /**
     * Exibe a página principal do Dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Cálculo de Alerta de Estoque 
        // Corrigido para referenciar 'inventario.item' (singular)
        $alertas_estoque = Inventario::where('quantidade', '<', function ($query) {
            $query->select('estoque_minimo')
                  ->from('culturas')
                  ->whereRaw('culturas.nome = inventario.item') 
                  ->limit(1);
        })->get(['item', 'quantidade', 'valor_unitario']);

        // 2. Cálculo do Balanço Financeiro 
        $total_receitas = Receita::sum('valor');
        $total_despesas = Despesa::sum('valor');
        $balanco_geral = $total_receitas - $total_despesas;

        // 3. Culturas com maior despesa 
        $culturas_mais_caras = Despesa::select('cultura_id', DB::raw('SUM(valor) as total_despesa'))
            ->groupBy('cultura_id')
            ->orderByDesc('total_despesa')
            ->with('cultura')
            ->limit(5)
            ->get();
            
        // 4. Despesas Pagas por Sócio (NOVO)
        $despesasPorSocio = Despesa::select('pago_por_socio_id', DB::raw('SUM(valor) as total_pago'))
            ->whereNotNull('pago_por_socio_id') // Apenas despesas com sócio pagador definido
            ->groupBy('pago_por_socio_id')
            // Carrega o nome do sócio (assumindo relacionamento pagoPorSocio no modelo Despesa)
            ->with('pagoPorSocio:id,nome') 
            ->get();
        
        // Formatar os dados para fácil exibição na View
        $resumoDespesasSocio = $despesasPorSocio->map(function ($item) {
            return [
                'nome' => $item->pagoPorSocio->nome ?? 'Sócio Não Identificado',
                'total_pago' => $item->total_pago,
            ];
        });

        // CORREÇÃO: Mudar 'dashboard.index' para 'dashboard'
        return view('dashboard', [
            'alertas_estoque' => $alertas_estoque,
            'total_receitas' => $total_receitas,
            'total_despesas' => $total_despesas,
            'balanco_geral' => $balanco_geral,
            'culturas_mais_caras' => $culturas_mais_caras,
            'resumoDespesasSocio' => $resumoDespesasSocio, // NOVO
        ]);
    }
}