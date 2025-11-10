<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultura extends Model
{
    use HasFactory;

    protected $table = 'culturas';

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'nome',
        'area_m2',               // <--- RENOMEADO
        'data_plantio',          // <--- Adicionado (Usado no formulário anterior, mas faltava no fillable)
        'colheita_prevista',     // <--- Adicionado
        'status',                // <--- Adicionado
        'estoque_minimo',        // <--- Adicionado
        'observacoes',           // <--- Adicionado
    ];

    /**
     * Conversão automática de tipos.
     */
    protected $casts = [
        'data_plantio' => 'date',
        'colheita_prevista' => 'date',
    ];

    /**
     * Uma Cultura tem muitas Despesas (custeio direto).
     */
    public function despesas()
    {
        return $this->hasMany(Despesa::class);
    }

    /**
     * Uma Cultura tem muitas Receitas (vendas da colheita).
     */
    public function receitas()
    {
        return $this->hasMany(Receita::class);
    }
    public function socios()
    {
        // Usa withPivot('percentual_cota') para acessar o campo extra na tabela pivot.
        return $this->belongsToMany(Socio::class, 'cultura_socio', 'cultura_id', 'socio_id')
                    ->withPivot('percentual_cota');
    }
}