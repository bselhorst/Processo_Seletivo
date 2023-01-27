<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessoSeletivo;
use Illuminate\Support\Facades\Storage;

class ProcessoSeletivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProcessoSeletivo::orderBy('id', 'DESC')->paginate(10);
        return view('processoSeletivo.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('processoSeletivo.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required',
            'descricao' => 'required',
            'data_abertura' => 'required',
            'data_encerramento' => 'required',
            'file' => 'required'
        ]);
        $new = ProcessoSeletivo::create($validatedData);
        $request->file->storeAs("public/editais/$new->id", 'edital.pdf');
        return redirect()->route("ps.index")->with('success', 'Registro adicionado com sucesso!');
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
        $data = ProcessoSeletivo::findOrFail($id);
        return view('processoSeletivo.form', [
            'data' => $data,
        ]);
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
        if($request->file){
            $request->file->storeAs("public/editais/$id", 'edital.pdf');
        }
        $validatedData = $request->validate([
            'titulo' => 'required',
            'descricao' => 'required',
            'data_abertura' => 'required',
            'data_encerramento' => 'required',
            'file' => 'exclude'
        ]);
        ProcessoSeletivo::whereId($id)->update($validatedData);
        return redirect()->route("ps.index")->with('success', 'Registro editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = ProcessoSeletivo::findOrFail($id)->delete();
        Storage::deleteDirectory("public/editais/$id");
        return redirect()->route("ps.index")->with('success', 'Registro excluído com sucesso!');
    }

    public function fileUpload(Request $req){
        $req->validate([
        'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);
        $fileModel = new File;
        if($req->file()) {
            $fileName = time().'_'.$req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->name = time().'_'.$req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
   }

    public function downloadEdital($id){
        return Storage::download("editais/$id/edital.pdf");
    }

    public function indexSearch(Request $request)
    {
        $data = ProcessoSeletivo::where('titulo', 'LIKE', "%".$request->pesquisa."%")->orderBy('id', 'DESC')->paginate(10);
        return view('processoSeletivo.index', [
            'data' => $data,
        ]);
    }
}
