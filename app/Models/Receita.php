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
        'data_venda',              // ⬅️ CORRIGIDO: Nome usado no Controller
        'descricao',
        'quantidade_vendida',      // ⬅️ ADICIONADO: Campo da validação
        'unidade_medida',          // ⬅️ ADICIONADO: Campo da validação
        'valor_total',             // ⬅️ CORRIGIDO: Nome usado no Controller
        'observacoes',             // ⬅️ ADICIONADO: Campo da validação (nullable)
    ];

    protected $casts = [
        'data_venda' => 'date',    // ⬅️ CORRIGIDO: Nome do campo de data
        'valor_total' => 'float',  // ⬅️ CORRIGIDO: Nome do campo de valor
        'quantidade_vendida' => 'float', // ADICIONADO: Cast para garantir float
    ];

    /**
     * Relacionamento com a Cultura 
     */
    public function cultura()
    {
        return $this->belongsTo(Cultura::class, 'cultura_id');
    }
}