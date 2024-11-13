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
        Schema::create('processo_seletivo_analises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_inscricao')->constrained('processo_seletivo_inscricaos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('status');
            $table->text('mensagem')->nullable();
            $table->string('analisado_por')->nullable();
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
        Schema::dropIfExists('processo_seletivo_analises');
    }
};
