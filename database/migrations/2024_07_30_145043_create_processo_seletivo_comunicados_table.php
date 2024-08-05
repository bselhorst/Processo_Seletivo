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
        Schema::create('processo_seletivo_comunicados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_processo_seletivo');
            $table->foreign('id_processo_seletivo')->references('id')->on('processo_seletivos')->onDelete('cascade');
            $table->string('titulo');
            $table->string('documento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processo_seletivo_comunicados');
    }
};
