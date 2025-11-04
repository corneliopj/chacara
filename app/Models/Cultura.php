<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultura extends Model
{
    use HasFactory;

    protected $table = 'culturas';

    /**
     * Os atributos que são mass assignable (preenchíveis em massa).
     * Incluindo os campos do formulário de Nova Cultura.
     */
    protected $fillable = [
        'nome',
        'area', // <--- Adicionado
        'data_plantio', // <--- Adicionado
        'colheita_prevista', // <--- Adicionado
        'status', // <--- Adicionado
        'observacoes', // <--- Adicionado
        'estoque_minimo',
    ];
    
    // Adicionar tipos de data para conversão automática
    protected $casts = [
        'data_plantio' => 'date',
        'colheita_prevista' => 'date',
    ];
}