<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->string('cliente_nome');
            $table->string('cpf')->nullable();
            $table->string('item');
            $table->decimal('valor_total', 10, 2);
            $table->json('item_prices')->nullable();
            $table->integer('quantidade_parcelas');
            $table->date('data_venda');
            $table->boolean('is_flexivel')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};
