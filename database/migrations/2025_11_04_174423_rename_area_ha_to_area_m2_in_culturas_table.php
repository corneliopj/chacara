<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('culturas', function (Blueprint $table) {
           if (Schema::hasColumn('culturas', 'area_ha')) {
                $table->renameColumn('area_ha', 'area_m2');
            }
            
            // 2. Adicionar as colunas que estavam faltando na sua tabela (se for o caso)
            if (!Schema::hasColumn('culturas', 'data_plantio')) {
                $table->date('data_plantio')->after('area_m2');
            }
            if (!Schema::hasColumn('culturas', 'colheita_prevista')) {
                $table->date('colheita_prevista')->nullable()->after('data_plantio');
            }
            if (!Schema::hasColumn('culturas', 'status')) {
                $table->string('status', 50)->default('Plantio Pendente')->after('colheita_prevista');
            }
            if (!Schema::hasColumn('culturas', 'estoque_minimo')) {
                $table->integer('estoque_minimo')->default(0)->after('status');
            }
            if (!Schema::hasColumn('culturas', 'observacoes')) {
                $table->text('observacoes')->nullable()->after('estoque_minimo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('culturas', function (Blueprint $table) {
         if (Schema::hasColumn('culturas', 'area_m2')) {
                $table->renameColumn('area_m2', 'area_ha');
            }
            // Reverter remoção das novas colunas (necessário)
            $table->dropColumn(['data_plantio', 'colheita_prevista', 'status', 'estoque_minimo', 'observacoes']);
        });
    }
};
