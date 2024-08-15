<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessoSeletivo;
use App\Models\ProcessoSeletivoComunicado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProcessoSeletivoComunicadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id_processo_seletivo)
    {
        $data = ProcessoSeletivoComunicado::where('id_processo_seletivo', $id_processo_seletivo)->orderBy('id', 'DESC')->paginate(15);
        $processo_seletivo = ProcessoSeletivo::findOrFail($id_processo_seletivo);
        return view('processoSeletivo.comunicados.index', [
            'data' => $data,            
            'processo_seletivo' => $processo_seletivo
        ]);
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
    public function store(Request $request, int $id_processo_seletivo)
    {
        $validatedData = $request->validate([
            'titulo' => 'required',
        ]);
        if(@$request->file){
            // $request->file->storeAs("public/editais/$id", 'resultado.pdf');
            $fileName = \Str::random(64) . '.'.$request->file->extension();
            $request->file->storeAs("public/comunicados/$id_processo_seletivo", $fileName);
        }
        $validatedData["id_processo_seletivo"] = $id_processo_seletivo;
        $validatedData["documento"] = $fileName;
        $new = ProcessoSeletivoComunicado::create($validatedData);
        return redirect()->route("pscom.index", $id_processo_seletivo)->with('success', 'Registro adicionado com sucesso!');
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
    public function edit(int $id_processo_seletivo, int $id)
    {
        $data = ProcessoSeletivoComunicado::orderBy('id', 'DESC')->paginate(15);
        $data_comunicado = ProcessoSeletivoComunicado::findOrFail($id);
        $processo_seletivo = ProcessoSeletivo::findOrFail($id_processo_seletivo);
        return view('processoSeletivo.comunicados.index', [
            'data' => $data,     
            'data_comunicado' => $data_comunicado,       
            'processo_seletivo' => $processo_seletivo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id_processo_seletivo, $id)
    {
        $data = ProcessoSeletivoComunicado::findOrFail($id);
        $validatedData = $request->validate([
            'titulo' => 'required',
        ]);
        if(@$request->file('file')){
            // $request->file->storeAs("public/editais/$id", 'edital.pdf');
            $fileName = \Str::random(64) . '.'.$request->file->extension();
            $request->file->storeAs("public/comunicados/$id_processo_seletivo", $fileName);
            $validatedData["documento"] = $fileName;
            // Se está passando um arquivo, então, deve-se deletar o arquivo anterior
            if (Storage::exists("public/comunicados/".$id_processo_seletivo."/".$data->documento)){
                Storage::delete('public/comunicados/'.$id_processo_seletivo.'/'.$data->documento);
            }
        }     
        $data->update($validatedData);
        return redirect()->route("pscom.index", $id_processo_seletivo)->with('success', 'Registro editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id_processo_seletivo, int $id)
    {
        $data = ProcessoSeletivoComunicado::findOrFail($id);
        // return $data->documento;
        // return File::delete(public_path().'/comunicados/'.$id.'/'.$data->documento);
        // echo $data;
        if (Storage::exists("public/comunicados/".$id_processo_seletivo."/".$data->documento)){
            Storage::delete('public/comunicados/'.$id_processo_seletivo.'/'.$data->documento);
        }
        $data->delete();
        return redirect()->route("pscom.index", $id_processo_seletivo)->with('success', 'Registro excluído com sucesso!');
    }
}
