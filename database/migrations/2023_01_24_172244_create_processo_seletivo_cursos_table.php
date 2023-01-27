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
        Schema::create('processo_seletivo_cursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_processo_seletivo')->constrained('processo_seletivos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('municipio');
            $table->text('titulo');
            $table->text('descricao');
            $table->decimal('salario', 9,3);
            $table->integer('vagas');
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
        Schema::dropIfExists('processo_seletivo_cursos');
    }
};
