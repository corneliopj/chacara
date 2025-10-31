<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;

class Despesa extends Model
{
    protected $table = 'despesas';
    protected $fillable = ['valor', 'data', 'descricao', 'tipo', 'cultura_id'];
    
    public function cultura(): BelongsTo
    {
        return $this->belongsTo(Cultura::class, 'cultura_id');
    }
    
    // Regra: Atualiza gastos_acumulados da cultura após salvar
    protected static function booted(): void
    {
        static::created(function (Despesa $despesa) {
            // Regra 1: Soma gastos_acumulados na Cultura
            if ($despesa->tipo === 'cultura' && $despesa->cultura_id) {
                DB::table('culturas')->where('id', $despesa->cultura_id)->increment('gastos_acumulados', $despesa->valor);
                
                // Regra 2: Replica em despesas gerais (Criada no Controller para evitar recursão)
            }
        });
    }
}