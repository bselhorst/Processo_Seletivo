<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processo_seletivo_inscricao_notas', function (Blueprint $table) {
            $table->integer('nota_comprovante_endereco')->after('status');
            $table->integer('nota_carta_intencao')->after('nota_comprovante_endereco');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processo_seletivo_inscricao_notas', function (Blueprint $table) {
            $table->dropColumn('nota_comprovante_endereco');
            $table->dropColumn('nota_carta_intencao');
        });
    }
};
