<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;

    protected $table = 'despesas';

    protected $fillable = [
        'cultura_id',
        'descricao',
        'valor',
        'data',
        'categoria', // Adicionado para classificar (Semente, Insumo, Mão-de-Obra, Geral, etc.)
        'observacoes',
    ];

    /**
     * Define o relacionamento com a Cultura (belongsTo).
     * Uma despesa pode pertencer a uma cultura ou ser geral (cultura_id = null).
     */
    public function cultura()
    {
        return $this->belongsTo(Cultura::class);
    }
}