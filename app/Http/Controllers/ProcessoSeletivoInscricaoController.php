<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessoSeletivoInscricao;

class ProcessoSeletivoInscricaoController extends Controller
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
        return $request;
        // $validatedData = $request->validate([
        //     'id_processo_seletivo_curso' => 'required',
        //     'id_tipo_documento' => 'required',
        //     'numero_documento' => 'required',
        //     'nome' => 'required',
        //     'endereco' => 'required',
        //     'bairro' => '',
        //     'numero_contato' => 'required',
        //     'email' => '',
        //     'anexo_documento' => 'required',
        //     'anexo_titulacao' => '',
        //     'anexo_qualificacao' => '',
        //     'anexo_experiencia_profissional' => '',
        // ]);
        // $new = ProcessoSeletivo::create($validatedData);
        // $request->file->storeAs("public/inscricao/$new->id", 'edital.pdf');
        // return redirect()->route("inscricao")->with('success', 'Registro adicionado com sucesso!');
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
        //
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
