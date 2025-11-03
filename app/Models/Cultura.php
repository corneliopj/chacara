<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultura extends Model
{
    use HasFactory;

    protected $table = 'culturas';

    protected $fillable = [
        'nome',
        'area_ha',
        'data_plantio',
        'data_colheita_prevista',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'data_plantio' => 'date',
        'data_colheita_prevista' => 'date',
    ];

    /**
     * Relacionamento com Despesas (Despesas associadas a esta cultura)
     */
    public function despesas()
    {
        return $this->hasMany(Despesa::class, 'cultura_id');
    }

    /**
     * Relacionamento com Receitas (Vendas associadas a esta cultura)
     */
    public function receitas()
    {
        return $this->hasMany(Receita::class, 'cultura_id');
    }

    /**
     * Relacionamento com Tarefas (Manejos e atividades associadas a esta cultura)
     */
    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'cultura_id');
    }
}