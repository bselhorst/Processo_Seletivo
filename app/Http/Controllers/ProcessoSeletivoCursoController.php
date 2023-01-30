<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuxiliarMunicipio;
use App\Models\ProcessoSeletivo;
use App\Models\ProcessoSeletivoCurso;

class ProcessoSeletivoCursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_processo_seletivo)
    {
        $data = ProcessoSeletivoCurso::where('id_processo_seletivo', $id_processo_seletivo)->orderBy('titulo')->paginate(15);
        return view('processoSeletivo.cursos.index', [
            'user' => Auth::user(),
            'id_processo_seletivo' => $id_processo_seletivo,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_processo_seletivo)
    {
        $municipios = AuxiliarMunicipio::orderBy('nome')->get();
        return view('processoSeletivo.cursos.form', [
            'id_processo_seletivo' => $id_processo_seletivo,
            'municipios' => $municipios,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id_processo_seletivo)
    {
        $request["id_processo_seletivo"] = $id_processo_seletivo;
        ($request["salario"] == null)? $request["salario"] = 0.00 : '';
        $validatedData = $request->validate([
            'id_processo_seletivo' => 'required',
            'id_municipio' => 'required',
            'titulo' => 'required',
            'descricao' => '',
            'salario' => '',
            'carga_horaria' => 'required',
            'vagas' => 'required',
        ]);        
        $new = ProcessoSeletivoCurso::create($validatedData);
        return redirect()->route("pc.index", $id_processo_seletivo)->with('success', 'Registro adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_processo_seletivo, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_processo_seletivo, $id)
    {
        $municipios = AuxiliarMunicipio::orderBy('nome')->get();
        $data = ProcessoSeletivoCurso::findOrFail($id);
        return view('processoSeletivo.cursos.form', [
            'id_processo_seletivo' => $id_processo_seletivo,
            'data' => $data,
            'municipios' => $municipios
        ]);
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
        ($request["salario"] == null)? $request["salario"] = 0.00 : '';
        $validatedData = $request->validate([
            'id_municipio' => 'required',
            'titulo' => 'required',
            'descricao' => '',
            'salario' => '',
            'carga_horaria' => 'required',
            'vagas' => 'required',
        ]);
        ProcessoSeletivoCurso::whereId($id)->update($validatedData);
        return redirect()->route("pc.index", $id_processo_seletivo)->with('success', 'Registro editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_processo_seletivo, $id)
    {
        $item = ProcessoSeletivoCurso::findOrFail($id)->delete();
        return redirect()->route("pc.index", $id_processo_seletivo)->with('success', 'Registro excluído com sucesso!');
    }

    public function indexSearch(Request $request, $id_processo_seletivo)
    {
        $data = ProcessoSeletivoCurso::where('titulo', 'LIKE', "%".$request->pesquisa."%")->orderBy('id', 'DESC')->paginate(10);
        return view('processoSeletivo.cursos.index', [
            'user' => Auth::user(),
            'id_processo_seletivo' => $id_processo_seletivo,
            'data' => $data,
        ]);
    }
}
