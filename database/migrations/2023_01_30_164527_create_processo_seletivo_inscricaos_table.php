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
        Schema::create('processo_seletivo_inscricaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_processo_seletivo_curso')->constrained('processo_seletivo_cursos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_tipo_documento')->constrained('auxiliar_tipo_documentos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('numero_documento');
            $table->string('nome');
            $table->string('endereco');
            $table->string('bairro')->nullable();
            $table->string('numero_contato');
            $table->string('email')->nullable();
	    $table->string('mensagem')->nullable();
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
        Schema::dropIfExists('processo_seletivo_inscricaos');
    }
};
