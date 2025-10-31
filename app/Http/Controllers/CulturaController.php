<?php namespace App\Http\Controllers;

use App\Models\Cultura;

class CulturaController {
    
    public function index() {
        $culturas = Cultura::all();
        return view('culturas.index', ['culturas' => $culturas]);
    }
    
    public function criar() {
        return view('culturas.criar');
    }
    
    public function salvar() {
        $data = $_POST;
        
        $cultura = new Cultura([
            'nome' => $data['nome'],
            'area' => $data['area'],
            'data_plantio' => $data['data_plantio'],
            'data_colheita_prevista' => $data['data_colheita_prevista'],
            'produtividade_esperada' => $data['produtividade_esperada'],
            'estoque_minimo' => $data['estoque_minimo'] ?? 0,
        ]);

        if ($cultura->save()) {
            header('Location: /culturas');
            exit;
        }
        return view('culturas.criar', ['erro' => 'Falha ao salvar cultura.']);
    }
    // ... (demais métodos CRUD)
}