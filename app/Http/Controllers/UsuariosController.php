<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('name')->paginate(15);
        return view('usuarios.usuarios', ['data' => $data]);
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
        if(!$request->password){
            return redirect()->route("usuarios.index")->with('error', 'Senha é obrigatório');
        }

        if($request['password'] != $request['confirmPassword']){
            return redirect()->route("usuarios.index")->with('error', 'As senhas não são iguais');
        }

        // return $request;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isSuperAdmin' => (int) $request->isSuperAdmin
        ]);        

        return redirect()->route("usuarios.index")->with('success', 'Registro adicionado com sucesso!');
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
        $data = User::orderBy('name')->paginate(15);
        $data_user = User::findOrFail($id);
        return view('usuarios.usuarios', [
            'data' => $data, 
            'data_user' => $data_user
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
        if($request['password'] != $request['confirmPassword']){
            return redirect()->route("usuarios.index")->with('error', 'As senhas não são iguais');
        }

        if($request->password){
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => '',
                'password' => '',
                'isSuperAdmin' => 'required'
            ]);
            $validatedData['password'] = Hash::make($request->password); 
        }else{
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => '',
                'isSuperAdmin' => 'required'
            ]);          
        }
        User::whereId($id)->update($validatedData);
        return redirect()->route("usuarios.index")->with('success', 'Registro editado com sucesso!');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id)->delete();
        return redirect()->route("usuarios.index")->with('success', 'Registro excluído com sucesso!');
    }
}
