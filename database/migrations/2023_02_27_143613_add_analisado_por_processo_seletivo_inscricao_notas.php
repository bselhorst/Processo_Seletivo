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
            $table->string('analisado_por')->after('mensagem')->nullable();
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
            $table->dropColumn('analisado_por');
        });
    }
};
