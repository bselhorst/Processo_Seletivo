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
        Schema::table('processo_seletivo_inscricaos', function (Blueprint $table) {
            $table->enum('deficiencia', [1, 2])->default(2)->comment('1 - Sim, 2 - Não');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processo_seletivo_inscricaos', function (Blueprint $table) {
            $table->dropColumn('deficiencia');
        });
    }
};
