<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessoSeletivo;
use App\Models\ProcessoSeletivoCurso;
use App\Models\ProcessoSeletivoInscricao;
use App\Models\ProcessoSeletivoInscricaoNota;

use Illuminate\Support\Facades\DB;

use App\Mail\Confirmacao;
use Illuminate\Support\Facades\Mail;

class ProcessoSeletivoInscricaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_processo_seletivo)
    {
        $processo_seletivo = ProcessoSeletivo::findOrFail($id_processo_seletivo);
        $data = DB::table('processo_seletivo_inscricaos')
                    ->distinct('processo_seletivo_inscricaos.id')
                    ->join('processo_seletivo_cursos', 'processo_seletivo_inscricaos.id_processo_seletivo_curso', 'processo_seletivo_cursos.id')
                    ->join('auxiliar_tipo_documentos', 'processo_seletivo_inscricaos.id_tipo_documento', 'auxiliar_tipo_documentos.id')
                    ->join('auxiliar_municipios', 'processo_seletivo_cursos.id_municipio', 'auxiliar_municipios.id')
                    ->leftjoin('processo_seletivo_inscricao_notas', 'processo_seletivo_inscricaos.id', 'processo_seletivo_inscricao_notas.id_inscricao')
                    ->select('processo_seletivo_inscricaos.id as id', 'auxiliar_tipo_documentos.nome as tipo_documento', 'processo_seletivo_inscricaos.numero_documento', 'processo_seletivo_inscricaos.nome', 'processo_seletivo_inscricao_notas.status as status', 'titulo as curso', 'auxiliar_municipios.nome as cidade')
                    ->where('processo_seletivo_cursos.id_processo_seletivo', $id_processo_seletivo)
                    ->orderBy('processo_seletivo_inscricao_notas.status')
                    ->orderBy('processo_seletivo_inscricaos.nome')
                    ->paginate(15);
        // $data = ProcessoSeletivoInscricao::orderBy('nome')->paginate(15);
        // return $data;
        return view('processoSeletivo.inscricoes.index', [
            'id_processo_seletivo' => $id_processo_seletivo,
            'data' => $data,
            'processo_seletivo' => $processo_seletivo,
        ]);
    }

    public function json($id_processo_seletivo)
    {
        $processo_seletivo = ProcessoSeletivo::findOrFail($id_processo_seletivo);
        $data = DB::table('processo_seletivo_inscricaos')
                    ->distinct('processo_seletivo_inscricaos.id')
                    ->join('processo_seletivo_cursos', 'processo_seletivo_inscricaos.id_processo_seletivo_curso', 'processo_seletivo_cursos.id')
                    ->join('auxiliar_tipo_documentos', 'processo_seletivo_inscricaos.id_tipo_documento', 'auxiliar_tipo_documentos.id')
                    ->leftjoin('processo_seletivo_inscricao_notas', 'processo_seletivo_inscricaos.id', 'processo_seletivo_inscricao_notas.id_inscricao')
                    ->select('processo_seletivo_inscricaos.id as id', 'auxiliar_tipo_documentos.nome as tipo_documento', 'processo_seletivo_inscricaos.numero_documento', 'processo_seletivo_inscricaos.nome', 'processo_seletivo_inscricao_notas.status as status')
                    ->where('processo_seletivo_cursos.id_processo_seletivo', $id_processo_seletivo)
                    ->orderBy('processo_seletivo_inscricao_notas.status')
                    ->orderBy('processo_seletivo_inscricaos.nome')
                    ->paginate(15);
        return $data;
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
            'id_processo_seletivo_curso' => 'required',
            'id_tipo_documento' => 'required',
            'numero_documento' => 'required',
            'nome' => 'required',
            'endereco' => 'required',
            'bairro' => '',
            'numero_contato' => 'required',
            'email' => 'required',
            'data_nascimento' => 'required',
            'anexo_documento' => 'required',
            'anexo_comprovante_endereco' => '',
            'anexo_declaracao_disponibilidade' => '',
            'anexo_carta_intencao' => '',
            'anexo_curriculo' => '',
            'anexo_titulacao' => 'required',
            'anexo_qualificacao' => 'required',
            'anexo_escolaridade' => '',
            'anexo_experiencia_profissional' => '',
            'anexo_deficiencia' => '',
            'deficiencia' => 'required',
        ]);

        $new = ProcessoSeletivoInscricao::create($validatedData);
        
        if (@$request->file('anexo_documento')){
            foreach($request->file('anexo_documento') as $key => $file)
            {
                // $fileName = time().rand(1,99).'.'.$file->extension();
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$new->id/documentos", "$fileName");
            }
        }

        if (@$request->file('anexo_comprovante_endereco')){
            foreach($request->file('anexo_comprovante_endereco') as $key => $file)
            {
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$new->id/comprovante_endereco", "$fileName");
            }
        }

        if (@$request->file('anexo_declaracao_disponibilidade')){
            foreach($request->file('anexo_declaracao_disponibilidade') as $key => $file)
            {
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$new->id/declaracao_disponibilidade", "$fileName");
            }
        }

        if (@$request->file('anexo_carta_intencao')){
            foreach($request->file('anexo_carta_intencao') as $key => $file)
            {
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$new->id/carta_intencao", "$fileName");
            }
        }

        if (@$request->file('anexo_curriculo')){
            foreach($request->file('anexo_curriculo') as $key => $file)
            {
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$new->id/curriculos", "$fileName");
            }
        }

        if (@$request->file('anexo_deficiencia')){
            foreach($request->file('anexo_deficiencia') as $key => $file)
            {
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$new->id/deficiencia", "$fileName");
            }
        }

        if (@$request->file('anexo_escolaridade')){
            foreach($request->file('anexo_escolaridade') as $key => $file)
            {
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$new->id/escolaridade", "$fileName");
            }
        }

        if (@$request->file('anexo_titulacao')){
            foreach($request->file('anexo_titulacao') as $key => $file)
            {
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$new->id/titulacao", "$fileName");
            }
        }

        if (@$request->file('anexo_qualificacao')){
            foreach($request->file('anexo_qualificacao') as $key => $file)
            {
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$new->id/qualificacao", "$fileName");
            }
        }

        if (@$request->file('anexo_experiencia_profissional')){
            foreach($request->file('anexo_experiencia_profissional') as $key => $file)
            {
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$new->id/experiencia_profissional", "$fileName");
            }
        }

        Mail::to($request->email)->send(new Confirmacao($validatedData));

        return redirect()->route("inscricao")->with('success', 'inscrição realizada com sucesso. A confirmação da inscrição foi enviada para o seu email!');
        // return redirect()->route("inscricao")->with('success', 'inscrição realizada com sucesso.');
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

    public function indexSearch(Request $request, $id_processo_seletivo)
    {
	$processo_seletivo = ProcessoSeletivo::findOrFail($id_processo_seletivo);
    $data = DB::table('processo_seletivo_inscricaos')
                ->distinct('processo_seletivo_inscricaos.id')
                ->join('processo_seletivo_cursos', 'processo_seletivo_inscricaos.id_processo_seletivo_curso', 'processo_seletivo_cursos.id')
                ->join('auxiliar_tipo_documentos', 'processo_seletivo_inscricaos.id_tipo_documento', 'auxiliar_tipo_documentos.id')
                ->join('auxiliar_municipios', 'processo_seletivo_cursos.id_municipio', 'auxiliar_municipios.id')
                ->leftjoin('processo_seletivo_inscricao_notas', 'processo_seletivo_inscricaos.id', 'processo_seletivo_inscricao_notas.id_inscricao')
                ->select('processo_seletivo_inscricaos.id as id', 'auxiliar_tipo_documentos.nome as tipo_documento', 'processo_seletivo_inscricaos.numero_documento', 'processo_seletivo_inscricaos.nome', 'processo_seletivo_inscricao_notas.status as status', 'titulo as curso', 'auxiliar_municipios.nome as cidade')
                ->where('processo_seletivo_inscricaos.nome', 'LIKE', "%".$request->pesquisa."%")
                ->orWhere('auxiliar_municipios.nome', 'LIKE', '%'.$request->pesquisa.'%' )
                ->where('processo_seletivo_cursos.id_processo_seletivo', $id_processo_seletivo)
                ->orderBy('processo_seletivo_inscricao_notas.status')
                ->orderBy('processo_seletivo_inscricaos.nome')
                ->paginate(15);       
	// $data = ProcessoSeletivoInscricao::where('nome', 'LIKE', "%".$request->pesquisa."%")->paginate(15);
        //return $data;
	return view('processoSeletivo.inscricoes.index', [
            'id_processo_seletivo' => $id_processo_seletivo,
            'data' => $data,
            'processo_seletivo' => $processo_seletivo,
        ]);
    }

    public function detalhes($id_processo_seletivo, $id){
        $data = ProcessoSeletivoInscricao::findOrFail($id);
        $data_nota = ProcessoSeletivoInscricaoNota::where('id_inscricao', $id)->first();
        return view('processoSeletivo.inscricoes.detalhes', [
            'id_processo_seletivo' => $id_processo_seletivo,
            'data' => $data,
            'data_nota' => $data_nota,
        ]);
    }

    public function downloadArquivo($path){
        return Storage::download($path);
    }

}
