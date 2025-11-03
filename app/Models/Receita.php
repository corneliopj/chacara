<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    use HasFactory;

    protected $table = 'receitas';

    protected $fillable = [
        'cultura_id',
        'descricao',
        'valor',
        'data_lancamento',
        'categoria',
    ];

    protected $casts = [
        'data_lancamento' => 'date',
        'valor' => 'float',
    ];

    /**
     * Relacionamento com a Cultura (Opcional)
     */
    public function cultura()
    {
        return $this->belongsTo(Cultura::class, 'cultura_id');
    }
}