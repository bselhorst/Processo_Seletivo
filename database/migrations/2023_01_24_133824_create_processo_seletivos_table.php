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
        Schema::create('processo_seletivos', function (Blueprint $table) {
            $table->id();
            $table->text('titulo');
            $table->text('descricao');
            $table->dateTime('data_abertura');
            $table->dateTime('data_encerramento');
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
        Schema::dropIfExists('processo_seletivos');
    }
};
