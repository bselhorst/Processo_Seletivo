<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessoSeletivoInscricaoNota;

class ProcessoSeletivoInscricaoNotaController extends Controller
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
        // return $request;
        $id_processo_seletivo = $request->id_processo_seletivo;
        $validatedData = $request->validate([
            'id_inscricao' => 'required',
            'status' => 'required',            
            'nota_titulacao' => 'required',
            'nota_qualificacao' => 'required',
            'nota_exp_profissional' => 'required',
            'mensagem' => '',
        ]);
        // return $validatedData;
        $new = ProcessoSeletivoInscricaoNota::create($validatedData);
        return redirect()->route("pi.index", $id_processo_seletivo)->with('success', 'Registro adicionado com sucesso!');
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
    public function update(Request $request, $id_processo_seletivo, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required',            
            'nota_titulacao' => 'required',
            'nota_qualificacao' => 'required',
            'nota_exp_profissional' => 'required',
            'mensagem' => '',
        ]);
        // return $validatedData;
        ProcessoSeletivoInscricaoNota::findOrFail($id)->update($validatedData);
        return redirect()->route("pi.index", $id_processo_seletivo)->with('success', 'Registro adicionado com sucesso!');
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
