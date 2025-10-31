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
        // Tabela Culturas
        Schema::create('culturas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('area', 10, 2)->comment('Área em hectares');
            $table->date('data_plantio');
            $table->date('data_colheita_prevista')->nullable();
            $table->decimal('produtividade_esperada', 10, 2)->nullable();
            $table->decimal('estoque_minimo', 10, 2)->default(0);
            $table->decimal('gastos_acumulados', 15, 2)->default(0);
            $table->decimal('receitas_acumuladas', 15, 2)->default(0);
            $table->timestamps();
        });

        // Tabela Despesas
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor', 15, 2);
            $table->date('data');
            $table->string('descricao');
            $table->enum('tipo', ['cultura', 'geral']);
            $table->foreignId('cultura_id')->nullable()->constrained('culturas')->onDelete('set null');
            $table->timestamps();
        });

        // Tabela Inventário
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->decimal('quantidade', 10, 2);
            $table->decimal('valor_unitario', 10, 2);
            $table->timestamps();
        });

        // Tabela Receitas
        Schema::create('receitas', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor', 15, 2);
            $table->date('data');
            $table->string('descricao');
            $table->enum('fonte', ['producao', 'venda']);
            $table->foreignId('cultura_id')->nullable()->constrained('culturas')->onDelete('set null');
            $table->foreignId('item_id')->nullable()->constrained('inventario')->onDelete('set null')->comment('Referencia inventario.id');
            $table->timestamps();
        });
        
        // Tabela Tarefas
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cultura_id')->constrained('culturas')->onDelete('cascade');
            $table->enum('tipo', ['plantio', 'adubacao', 'colheita', 'outros']);
            $table->date('data_prevista');
            $table->string('descricao')->nullable();
            $table->enum('status', ['pendente', 'concluida'])->default('pendente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefas');
        Schema::dropIfExists('receitas');
        Schema::dropIfExists('despesas');
        Schema::dropIfExists('inventario');
        Schema::dropIfExists('culturas');
    }
};