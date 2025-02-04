<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('historico_movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->integer('quantidade');
            $table->string('unidade');
            $table->string('acao'); // 'Adicionado', 'Editado', 'Excluído'
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade'); // Qual usuário fez a ação
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('historico_movimentacoes');
    }
};
