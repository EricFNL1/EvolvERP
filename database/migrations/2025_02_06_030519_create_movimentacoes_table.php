<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('cliente_id')->nullable(); // Pode ser sem cliente associado
            $table->integer('quantidade');
            $table->string('tipo_movimentacao'); // "entrada" ou "saida"
            $table->string('descricao')->nullable();
            $table->timestamps();
    
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('movimentacoes');
    }
    
};
