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
        Schema::table('processo_seletivos', function (Blueprint $table) {
            $table->boolean('resultado')->after('data_encerramento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processo_seletivos', function (Blueprint $table) {
            $table->dropColumn('resultado');
        });
    }
};
