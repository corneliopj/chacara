<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    use HasFactory;

    protected $table = 'receitas';

    protected $fillable = [
        'cultura_id',
        'data_venda',
        'descricao',
        'quantidade_vendida',
        'unidade_medida',
        'valor', // ⬅️ CORREÇÃO: Voltando para 'valor'
        'observacoes',
    ];

    protected $casts = [
        'data_venda' => 'date',
        'valor' => 'float', // ⬅️ CORREÇÃO: Voltando para 'valor'
        'quantidade_vendida' => 'float', 
    ];

    /**
     * Relacionamento com a Cultura 
     */
    public function cultura()
    {
        return $this->belongsTo(Cultura::class, 'cultura_id');
    }
}