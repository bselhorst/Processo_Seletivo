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
        Schema::create('processo_seletivo_notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_processo_seletivo_analise')->constrained('processo_seletivo_analises')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_processo_seletivo_doc')->constrained('processo_seletivo_documentos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('nota')->default(0);
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
        Schema::dropIfExists('processo_seletivo_notas');
    }
};
