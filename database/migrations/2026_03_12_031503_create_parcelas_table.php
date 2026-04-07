<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id')->constrained()->cascadeOnDelete();
            $table->integer('numero_parcela');
            $table->decimal('valor', 10, 2);
            $table->date('data_vencimento')->nullable();
            $table->boolean('pago')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcelas');
    }
};
