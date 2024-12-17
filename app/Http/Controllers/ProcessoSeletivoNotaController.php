<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessoSeletivoConfiguracao;
use App\Models\ProcessoSeletivoNota;
use App\Models\ProcessoSeletivoAnalise;
use Auth;

class ProcessoSeletivoNotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Cria uma nova instância de Análise
        $analise = new ProcessoSeletivoAnalise();
        $analise->id_inscricao = $request->id_inscricao;
        $analise->status = $request->status;
        $analise->mensagem = $request->mensagem;
        $analise->analisado_por = Auth::user()->name;

        // Salva a estrutura no banco de análises
        $analise->save();

        // Verifica se a análise foi deferida para fazer a inserção dos pontos
        // if ($analise->status == "Deferido"){
        //     // Pega as configurações
        //     $configuracoes = ProcessoSeletivoConfiguracao::with("documento")->where('id_processo_seletivo', $request->id_processo_seletivo)->get();
        //     // Itera as configurações
        //     foreach ($configuracoes as $conf){
        //         // Cria o nome da nota
        //         $path = \App\Helpers\StringHelper::createPath($conf->documento->nome);

        //         // Verifica se a configuração possui a pontuação
        //         if ($conf->pontuacao){
        //             // Cria uma nova instância
        //             $nota = new ProcessoSeletivoNota();
        //             $nota->id_processo_seletivo_analise = $analise->id;
        //             $nota->id_processo_seletivo_doc = $conf->documento->id;
        //             $nota->nota = $request->input("nota_".$path);

        //             // Salva no banco de notas
        //             $nota->save();
        //         }
        //     }
        // }

        $configuracoes = ProcessoSeletivoConfiguracao::with("documento")->where('id_processo_seletivo', $request->id_processo_seletivo)->get();
        // Itera as configurações
        foreach ($configuracoes as $conf){
            // Cria o nome da nota
            $path = \App\Helpers\StringHelper::createPath($conf->documento->nome);

            // Verifica se a configuração possui a pontuação
            // if ($conf->pontuacao){
                // Cria uma nova instância
                $nota = new ProcessoSeletivoNota();
                $nota->id_processo_seletivo_analise = $analise->id;
                $nota->id_processo_seletivo_doc = $conf->documento->id;
                $nota->nota = ($request->input("nota_".$path)) ? $request->input("nota_".$path) : 0;

                // Salva no banco de notas
                $nota->save();
            // }
        }

        // $new = ProcessoSeletivoInscricaoNota::create($validatedData);
        return redirect()->route("pi.index", $request->id_processo_seletivo)->with('success', 'Registro adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Cria uma nova instância de Análise
        $analise = new ProcessoSeletivoAnalise();
        $analise->id_inscricao = $request->id_inscricao;
        $analise->status = $request->status;
        $analise->mensagem = $request->mensagem;
        $analise->analisado_por = Auth::user()->name;

        // Salva a estrutura no banco de análises
        $analise->save();

        // Verifica se a análise foi deferida para fazer a inserção dos pontos
        // if ($analise->status == "Deferido"){
        //     // Pega as configurações
        //     $configuracoes = ProcessoSeletivoConfiguracao::with("documento")->where('id_processo_seletivo', $request->id_processo_seletivo)->get();
        //     // Itera as configurações
        //     foreach ($configuracoes as $conf){
        //         // Cria o nome da nota
        //         $path = \App\Helpers\StringHelper::createPath($conf->documento->nome);

        //         // Verifica se a configuração possui a pontuação
        //         if ($conf->pontuacao){
        //             // Cria uma nova instância
        //             $nota = new ProcessoSeletivoNota();
        //             $nota->id_processo_seletivo_analise = $analise->id;
        //             $nota->id_processo_seletivo_doc = $conf->documento->id;
        //             $nota->nota = $request->input("nota_".$path);

        //             // Salva no banco de notas
        //             $nota->save();
        //         }
        //     }
        // }

        $configuracoes = ProcessoSeletivoConfiguracao::with("documento")->where('id_processo_seletivo', $request->id_processo_seletivo)->get();
        // Itera as configurações
        foreach ($configuracoes as $conf){
            // Cria o nome da nota
            $path = \App\Helpers\StringHelper::createPath($conf->documento->nome);

            // Verifica se a configuração possui a pontuação
            // if ($conf->pontuacao){
                // Cria uma nova instância
                $nota = new ProcessoSeletivoNota();
                $nota->id_processo_seletivo_analise = $analise->id;
                $nota->id_processo_seletivo_doc = $conf->documento->id;
                $nota->nota = ($request->input("nota_".$path)) ? $request->input("nota_".$path) : 0;

                // Salva no banco de notas
                $nota->save();
            // }
        }

        // $new = ProcessoSeletivoInscricaoNota::create($validatedData);
        return redirect()->route("pi.index", $request->id_processo_seletivo)->with('success', 'Registro adicionado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
