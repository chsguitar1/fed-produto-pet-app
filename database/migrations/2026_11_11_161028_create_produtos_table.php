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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('produto');
            $table->unsignedInteger('quantidade')->default(0);
            $table->decimal('preco_custo', 10, 2);
            $table->decimal('preco_venda', 10, 2);
            $table->foreignId('lote_id')
                ->nullable()
                ->constrained('lotes')
                ->restrictOnDelete();
            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->restrictOnDelete();
            $table->foreignId('marca_id')
                ->constrained('marcas')
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
