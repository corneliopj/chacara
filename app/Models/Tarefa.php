<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarefa extends Model
{
    protected $table = 'tarefas';
    protected $fillable = ['cultura_id', 'tipo', 'data_prevista', 'status', 'descricao'];

    public function cultura(): BelongsTo
    {
        return $this->belongsTo(Cultura::class, 'cultura_id');
    }
}