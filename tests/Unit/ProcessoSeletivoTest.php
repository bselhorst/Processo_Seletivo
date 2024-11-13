<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ProcessoSeletivo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ProcessoSeletivoTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    // Ou usa a anotação abaixo, ou começa com o nome test_
    /** @test */
    public function criar_um_processo_seletivo(){
        $ps = new ProcessoSeletivo();
        $ps->id = 1;
        $ps->titulo = 'Processo Seletivo 1';
        $ps->descricao = 'Descricao Processo Seletivo';
        $ps->data_abertura = '2024-11-13 00:00:00';
        $ps->data_encerramento = '2024-11-18 00:00:00';
        $ps->save();

        $this->assertNotNull($ps);
    }

    public function test_criar_segundo_processo_seletivo(){
        $ps = new ProcessoSeletivo();
        $ps->id = 2;
        $ps->titulo = 'Processo Seletivo 2';
        $ps->descricao = 'Descricao Processo Seletivo 2';
        $ps->data_abertura = '2024-11-13 00:00:00';
        $ps->data_encerramento = '2024-11-18 00:00:00';
        $ps->save();
        $this->assertNotNull($ps);
    }

    public function test_api_endpoint_processos(){

        $user = User::factory()->create();

        $token = $user->createToken('Test Token')->plainTextToken;

        $response = $this->get('/api/processos', [
            'Authorization' => 'Bearer ' . $token
        ]);
      
        $response->assertStatus(200);

        $response->assertJson([ 'data' => true ]);
    }

    public function test_erro_ao_criar_processo_seletivo_sem_titulo(){
        $this->expectException(QueryException::class);
        $ps = new ProcessoSeletivo();
        $ps->descricao = 'Descricao Processo Seletivo 2';
        $ps->data_abertura = '2024-11-13 00:00:00';
        $ps->data_encerramento = '2024-11-18 00:00:00';
        $ps->save();
    }

    public function test_erro_ao_criar_processo_seletivo_sem_descricao(){
        $this->expectException(QueryException::class);
        $ps = new ProcessoSeletivo();
        $ps->titulo = 'Processo Seletivo 2';
        $ps->data_abertura = '2024-11-13 00:00:00';
        $ps->data_encerramento = '2024-11-18 00:00:00';
        $ps->save();
    }

    public function test_erro_ao_criar_processo_seletivo_sem_data_abertura(){
        $this->expectException(QueryException::class);
        $ps = new ProcessoSeletivo();
        $ps->titulo = 'Processo Seletivo 2';
        $ps->descricao = 'Descricao Processo Seletivo 2';
        $ps->data_encerramento = '2024-11-18 00:00:00';
        $ps->save();
    }

    public function test_erro_ao_criar_processo_seletivo_sem_data_encerramento(){
        $this->expectException(QueryException::class);
        $ps = new ProcessoSeletivo();
        $ps->titulo = 'Processo Seletivo 2';
        $ps->descricao = 'Descricao Processo Seletivo 2';
        $ps->data_abertura = '2024-11-13 00:00:00';
        $ps->save();
    }

    public function test_verificar_se_existem_2_processos_seletivos(){
        $ps = ProcessoSeletivo::all();
        $this->assertCount(2, $ps);
    }

    public function test_verificar_se_existe_o_processo_seletivo_com_id_1(){
        $ps = ProcessoSeletivo::findOrFail(1);
        $this->assertNotNull($ps);
    }

    public function test_verificar_se_existe_o_processo_seletivo_com_id_2(){
        $ps = ProcessoSeletivo::findOrFail(2);
        $this->assertNotNull($ps);
    }

    public function test_verificar_se_nao_existe_o_processo_seletivo(){
        $this->expectException(ModelNotFoundException::class);
        $ps = ProcessoSeletivo::findOrFail(10000);
    }

    public function test_verificar_se_no_banco_existe_o_titulo_especifico_no_banco(){
        $this->assertDatabaseHas('processo_seletivos', [
            'titulo' => 'Processo Seletivo 1'
        ]);
    }

    public function test_verificar_se_no_banco_nao_existe_o_titulo_especifico_no_banco(){
        $this->assertDatabaseMissing('processo_seletivos', [
            'titulo' => 'Processo Seletivo Teste'
        ]);
    }

    public function test_verificar_existencia_de_descricao_no_banco(){
        $this->assertDatabaseHas('processo_seletivos', [
            'titulo' => 'Processo Seletivo 1'
        ]);
    }

    public function test_verificar_inexistencia_de_descricao_no_banco(){
        $this->assertDatabaseMissing('processo_seletivos', [
            'titulo' => 'Descrição Inexistente'
        ]);
    }

    public function test_limpar_tudo()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // ProcessoSeletivo::query()->delete();
        ProcessoSeletivo::truncate();
        User::truncate();
        $resultado = true;
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->assertTrue($resultado);

    }
}
