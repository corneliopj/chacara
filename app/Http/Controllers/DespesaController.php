<?php namespace App\Controllers;

use App\Models\Despesa;

class DespesaController {

    public function index() {
        $despesas = Despesa::all();
        return view('despesas.index', ['despesas' => $despesas]);
    }

    public function salvar() {
        // Simulação de Request POST do Laravel
        $data = $_POST; 
        
        // 1. Cria a Despesa (tipo 'cultura' ou 'geral')
        $despesa = new Despesa([
            'valor' => $data['valor'],
            'data' => $data['data'],
            'descricao' => $data['descricao'],
            'tipo' => $data['tipo'],
            'cultura_id' => $data['cultura_id'] ?? null,
        ]);

        if ($despesa->save()) {
            // 2. Regra: Se tipo 'cultura', replica em despesa 'geral'
            if ($data['tipo'] === 'cultura' && $data['cultura_id']) {
                $despesa_geral = new Despesa([
                    'valor' => $data['valor'],
                    'data' => $data['data'],
                    'descricao' => 'Custo de Cultura (Geral): ' . $data['descricao'],
                    'tipo' => 'geral',
                    'cultura_id' => null, // Esta é a cópia geral
                ]);
                $despesa_geral->save(); 
                // A atualização de gastos_acumulados na Cultura é feita no Model Despesa::save() da despesa original.
            }
            // Redireciona de volta para a lista (simulação)
            header('Location: /despesas');
            exit;
        } 
        
        // Erro
        return view('despesas.criar', ['erro' => 'Falha ao salvar despesa.']);
    }
    
    // ... (criar, editar, deletar)
}