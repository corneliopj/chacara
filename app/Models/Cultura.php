<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cultura extends Model
{
    protected $table = 'culturas';
    protected $fillable = [
        'nome', 'area', 'data_plantio', 'data_colheita_prevista', 
        'produtividade_esperada', 'estoque_minimo'
    ];
    
    // Gastos e Receitas Acumulados são atualizados por eventos/regras de negócio
    protected $attributes = [
        'gastos_acumulados' => 0.00,
        'receitas_acumuladas' => 0.00,
    ];

    public function despesas(): HasMany
    {
        return $this->hasMany(Despesa::class, 'cultura_id');
    }

    public function receitas(): HasMany
    {
        return $this->hasMany(Receita::class, 'cultura_id');
    }
    
    public function tarefas(): HasMany
    {
        return $this->hasMany(Tarefa::class, 'cultura_id');
    }
}