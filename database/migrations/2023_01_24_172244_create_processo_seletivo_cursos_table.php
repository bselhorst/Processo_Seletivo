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
            $table->foreignId('id_municipio')->constrained('auxiliar_municipios')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('titulo');
            $table->text('descricao')->nullable();
            $table->decimal('salario', 9,2);
            $table->integer('carga_horaria');
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
