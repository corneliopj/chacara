<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Receita extends Model
{
    protected $table = 'receitas';
    protected $fillable = ['valor', 'data', 'descricao', 'fonte', 'cultura_id', 'item_id'];

    public function cultura(): BelongsTo
    {
        return $this->belongsTo(Cultura::class, 'cultura_id');
    }
    
    public function itemInventario(): BelongsTo
    {
        return $this->belongsTo(Inventario::class, 'item_id');
    }
    
    // Regra: Atualiza receitas_acumuladas da cultura após salvar
    protected static function booted(): void
    {
        static::created(function (Receita $receita) {
            // Regra: Se Receita for 'producao', soma receitas_acumuladas cultura
            if ($receita->fonte === 'producao' && $receita->cultura_id) {
                DB::table('culturas')->where('id', $receita->cultura_id)->increment('receitas_acumuladas', $receita->valor);
            }
        });
    }
}