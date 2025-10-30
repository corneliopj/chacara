<?php namespace App\Controllers;

use App\Models\Despesa;
use App\Models\Receita;
use App\Models\Cultura;

class RelatoriosController {

    public function index() {
        $culturas = Cultura::all();
        return view('relatorios.index', ['culturas' => $culturas, 'resultados' => null]);
    }

    public function gerar() {
        $data_inicio = $_POST['data_inicio'] ?? date('Y-m-01');
        $data_fim = $_POST['data_fim'] ?? date('Y-m-d');
        $cultura_id = $_POST['cultura_id'] ?? null;
        
        $params = [
            'data_inicio' => $data_inicio, 
            'data_fim' => $data_fim
        ];
        
        $sql_where = " WHERE data BETWEEN :data_inicio AND :data_fim";
        if ($cultura_id) {
            $sql_where .= " AND cultura_id = :cultura_id";
            $params['cultura_id'] = $cultura_id;
        }
        
        // Calcula Totais
        $total_despesas = Despesa::query("SELECT SUM(valor) as total FROM despesas {$sql_where}", $params)[0]['total'] ?? 0;
        $total_receitas = Receita::query("SELECT SUM(valor) as total FROM receitas {$sql_where}", $params)[0]['total'] ?? 0;
        $lucro = $total_receitas - $total_despesas;
        
        $resultados = [
            'total_despesas' => $total_despesas,
            'total_receitas' => $total_receitas,
            'lucro' => $lucro,
        ];
        
        // Custo por Hectare (se houver filtro de cultura e área)
        if ($cultura_id) {
            $cultura = Cultura::find($cultura_id);
            if ($cultura && $cultura->area > 0) {
                $custo_ha = $total_despesas / $cultura->area;
                $resultados['custo_ha'] = $custo_ha;
                $resultados['cultura_nome'] = $cultura->nome;
                $resultados['area'] = $cultura->area;
            }
        }
        
        $culturas = Cultura::all();
        return view('relatorios.index', [
            'culturas' => $culturas, 
            'resultados' => $resultados,
            'filtros' => $_POST
        ]);
    }
}