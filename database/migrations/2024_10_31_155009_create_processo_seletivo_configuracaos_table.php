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
        Schema::create('processo_seletivo_configuracaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_processo_seletivo')->constrained('processo_seletivos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_processo_seletivo_doc')->constrained('processo_seletivo_documentos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('obrigatorio');
            $table->boolean('pontuacao');
            $table->boolean('multiplos_arquivos');
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
        Schema::dropIfExists('processo_seletivo_configuracaos');
    }
};
