<?php namespace App\Controllers;

use App\Models\Cultura;
use App\Models\Despesa;
use App\Models\Receita;
use App\Models\Inventario;
use App\Models\Tarefa;

class DashboardController {

    public function index() {
        $data = $this->getDashboardData();
        return view('dashboard', $data);
    }

    private function getDashboardData() {
        $culturas = Cultura::all();
        $total_gastos = Despesa::query("SELECT SUM(valor) as total FROM despesas")[0]['total'] ?? 0;
        $total_receitas = Receita::query("SELECT SUM(valor) as total FROM receitas")[0]['total'] ?? 0;
        $total_lucro = $total_receitas - $total_gastos;

        // Alertas de Estoque e Colheita
        $alertas_estoque = Inventario::query("SELECT item, quantidade, valor_unitario FROM inventario WHERE quantidade < (SELECT estoque_minimo FROM culturas WHERE culturas.nome = inventario.item LIMIT 1)");
        
        $data_alerta = date('Y-m-d', strtotime('+7 days'));
        $alertas_colheita = Cultura::query("SELECT nome, data_colheita_prevista FROM culturas WHERE data_colheita_prevista BETWEEN CURDATE() AND :data_alerta", ['data_alerta' => $data_alerta]);
        
        $tarefas_pendentes = Tarefa::query("SELECT T.data_prevista, T.tipo, C.nome AS cultura_nome FROM tarefas T JOIN culturas C ON T.cultura_id = C.id WHERE T.status = 'pendente' ORDER BY T.data_prevista ASC LIMIT 5");

        return [
            'total_gastos' => $total_gastos,
            'total_receitas' => $total_receitas,
            'total_lucro' => $total_lucro,
            'culturas' => $culturas,
            'alertas_estoque' => $alertas_estoque,
            'alertas_colheita' => $alertas_colheita,
            'tarefas_pendentes' => $tarefas_pendentes,
        ];
    }
    
    public function apiGraficos() {
        header('Content-Type: application/json');
        
        // Gráfico 1: Despesas vs Receitas Mensais
        $mensal = Despesa::query("
            SELECT 
                DATE_FORMAT(data, '%Y-%m') as mes,
                SUM(CASE WHEN table_name = 'despesas' THEN valor ELSE 0 END) as total_despesas,
                SUM(CASE WHEN table_name = 'receitas' THEN valor ELSE 0 END) as total_receitas
            FROM (
                SELECT valor, data, 'despesas' as table_name FROM despesas
                UNION ALL
                SELECT valor, data, 'receitas' as table_name FROM receitas
            ) AS dados
            GROUP BY mes
            ORDER BY mes ASC
        ");

        // Gráfico 2: Lucro por Cultura
        $lucro_cultura = Cultura::query("
            SELECT nome, (receitas_acumuladas - gastos_acumulados) as lucro 
            FROM culturas 
            HAVING lucro IS NOT NULL
        ");

        echo json_encode([
            'mensal' => $mensal,
            'lucro_cultura' => $lucro_cultura,
        ]);
        exit;
    }
}