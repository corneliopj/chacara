<?php namespace App\Http\Controllers;

use App\Models\Cultura;
use App\Models\Despesa;
use App\Models\Receita;
use App\Models\Inventario;
use App\Models\Tarefa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $culturas = Cultura::all();
        $total_gastos = Despesa::sum('valor');
        $total_receitas = Receita::sum('valor');
        $total_lucro = $total_receitas - $total_gastos;

        // Alertas de Estoque e Colheita (Usando Join/Where do Eloquent/Query Builder)
        $alertas_estoque = Inventario::whereColumn('quantidade', '<', function ($query) {
            $query->select('estoque_minimo')
                  ->from('culturas')
                  ->whereRaw('culturas.nome = inventario.item')
                  ->limit(1);
        })->get(['item', 'quantidade', 'valor_unitario']);
        
        $data_alerta = Carbon::now()->addDays(7);
        $alertas_colheita = Cultura::whereBetween('data_colheita_prevista', [Carbon::now(), $data_alerta])->get(['nome', 'data_colheita_prevista']);
        
        $tarefas_pendentes = Tarefa::where('status', 'pendente')
            ->with('cultura:id,nome') // Carrega o nome da cultura
            ->orderBy('data_prevista')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'total_gastos', 'total_receitas', 'total_lucro', 'culturas',
            'alertas_estoque', 'alertas_colheita', 'tarefas_pendentes'
        ));
    }
    
    public function apiGraficos()
    {
        // Gráfico 1: Despesas vs Receitas Mensais
        $mensal = DB::table('despesas')
            ->select(
                DB::raw('DATE_FORMAT(data, "%Y-%m") as mes'),
                DB::raw('SUM(valor) as total_despesas'),
                DB::raw('0 as total_receitas')
            )
            ->unionAll(
                DB::table('receitas')
                ->select(
                    DB::raw('DATE_FORMAT(data, "%Y-%m") as mes'),
                    DB::raw('0 as total_despesas'),
                    DB::raw('SUM(valor) as total_receitas')
                )
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Gráfico 2: Lucro por Cultura (apenas Culturas com movimentação)
        $lucro_cultura = Cultura::select('nome', DB::raw('(receitas_acumuladas - gastos_acumulados) as lucro'))
            ->where(DB::raw('receitas_acumuladas + gastos_acumulados'), '>', 0)
            ->get();

        return response()->json([
            'mensal' => $mensal,
            'lucro_cultura' => $lucro_cultura,
        ]);
    }
}