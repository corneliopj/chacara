<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $table = 'tarefas';

    protected $fillable = [
        'cultura_id',
        'descricao',
        'tipo',
        'data_prevista',
        'data_execucao',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'data_prevista' => 'date',
        'data_execucao' => 'date',
    ];

    /**
     * Relacionamento com a Cultura
     */
    public function cultura()
    {
        return $this->belongsTo(Cultura::class, 'cultura_id');
    }

    /**
     * Escopo para tarefas pendentes (útil para o Dashboard)
     */
    public function scopePendente($query)
    {
        return $query->whereIn('status', ['Pendente', 'Em Andamento']);
    }
}