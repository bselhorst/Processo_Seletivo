<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuxiliarMunicipio;

class AuxiliarMunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AuxiliarMunicipio::orderBy('nome')->paginate(15);
        return view('auxiliares.municipios', [
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
        $validatedData = $request->validate([
            'nome' => 'required',
            'descricao' => '',
        ]);
        AuxiliarMunicipio::create($validatedData);
        return redirect()->route("aux.municipio.index")->with('success', 'Registro adicionado com sucesso!');
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
        $data = AuxiliarMunicipio::orderBy('nome')->paginate(15);
        $data_aux = AuxiliarMunicipio::findOrFail($id);
        return view('auxiliares.municipios', [
            'data' => $data,
            'data_aux' => $data_aux,
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
        $validatedData = $request->validate([
            'nome' => 'required',
            'descricao' => '',
        ]);
        AuxiliarMunicipio::whereId($id)->update($validatedData);
        return redirect()->route("aux.municipio.index")->with('success', 'Registro editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AuxiliarMunicipio::findOrFail($id)->delete();
        return redirect()->route("aux.municipio.index")->with('success', 'Registro excluído com sucesso!');
    }

    public function indexSearch(Request $request)
    {
        $data = AuxiliarMunicipio::where('nome', 'LIKE', "%".$request->pesquisa."%")->orderBy('nome')->paginate(15);
        return view('auxiliares.municipios', [
            'data' => $data,
        ]);
    }
}
