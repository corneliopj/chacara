<?php namespace App\Models;

class Cultura extends Model {
    protected $table = 'culturas';
    protected $fillable = ['nome', 'area', 'data_plantio', 'data_colheita_prevista', 
                           'produtividade_esperada', 'estoque_minimo', 
                           'gastos_acumulados', 'receitas_acumuladas'];
}