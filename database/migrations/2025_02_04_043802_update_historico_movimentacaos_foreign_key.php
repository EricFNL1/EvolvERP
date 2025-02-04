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
        Schema::table('historico_movimentacaos', function (Blueprint $table) {
            $table->unsignedBigInteger('produto_id')->nullable()->change(); // Permitir null
            $table->foreign('produto_id')
                  ->references('id')
                  ->on('produtos')
                  ->onDelete('SET NULL'); // Mantém o histórico mesmo após exclusão.
        });
    }
    
    public function down()
    {
        Schema::table('historico_movimentacaos', function (Blueprint $table) {
            $table->dropForeign(['produto_id']);
            $table->unsignedBigInteger('produto_id')->nullable(false)->change();
        });
    }
    
};
