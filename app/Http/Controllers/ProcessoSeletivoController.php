<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessoSeletivo;
use App\Models\ProcessoSeletivoAnalise;
use App\Models\ProcessoSeletivoConfiguracao;
use App\Models\ProcessoSeletivoCurso;
use App\Models\ProcessoSeletivoDocumento;
use App\Models\ProcessoSeletivoNota;
use App\Models\ProcessoSeletivoInscricao;
use App\Models\ProcessoSeletivoInscricaoNota;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Collection;

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
        $documentos = ProcessoSeletivoDocumento::orderBy('nome')->get();
        return view('processoSeletivo.form', [
            'documentos' => $documentos
        ]);
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

        // Responsável pela adição da configuração do processo seletivo
        foreach ($request->documentos as $key => $documento){
            if (@$documento["ativo"]){
                $configuracao = [
                    "id_processo_seletivo" => $new->id,
                    "id_processo_seletivo_doc" => $key,
                    "obrigatorio" => @$documento["required"] ? true : false,
                    "pontuacao" => @$documento["score"] ? true : false,
                    "multiplos_arquivos" => @$documento["multiple"] ? true : false
                ];
                ProcessoSeletivoConfiguracao::create($configuracao);
            }
        }

        $request->file('file')->storeAs("public/editais/$new->id", 'edital.pdf');
        if (@$request->file('documentos_adicionais')){
            foreach($request->file('documentos_adicionais') as $key => $file)
            {
                $file->storeAs("public/editais/$new->id/documentos_adicionais", $file->getClientOriginalName());
            }
        }
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
        $documentos = ProcessoSeletivoDocumento::orderBy('nome')->get();
        $configuracao = ProcessoSeletivoConfiguracao::where('id_processo_seletivo', $id)->get()->keyBy('id_processo_seletivo_doc');
        return view('processoSeletivo.form', [
            'data' => $data,
            'documentos' => $documentos,
            'configuracao' => $configuracao
            // 'configuracao' => response()->json($configuracao)
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
        // Deletar que possuem o processo seletivo na base de configuração
        ProcessoSeletivoConfiguracao::where('id_processo_seletivo', $id)->delete();
        // Responsável pela alteração da configuração do processo seletivo
        foreach ($request->documentos as $key => $documento){
            if (@$documento["ativo"]){
                $configuracao = [
                    "id_processo_seletivo" => $id,
                    "id_processo_seletivo_doc" => $key,
                    "obrigatorio" => @$documento["required"] ? true : false,
                    "pontuacao" => @$documento["score"] ? true : false,
                    "multiplos_arquivos" => @$documento["multiple"] ? true : false
                ];
                ProcessoSeletivoConfiguracao::create($configuracao);
            }
        }
        if (@$request->file('documentos_adicionais')){
            foreach($request->file('documentos_adicionais') as $key => $file)
            {
                $file->storeAs("public/editais/$id/documentos_adicionais", $file->getClientOriginalName());
            }
        }
        if(@$request->file('file')){
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

    public function resultado($id){
        // Dados com as informações necessárias
        $data = ProcessoSeletivoAnalise::selectRaw(
                                                    'processo_seletivo_analises.id, 
                                                    processo_seletivo_analises.id_inscricao, 
                                                    auxiliar_municipios.nome as municipio,
                                                    processo_seletivo_cursos.titulo as curso, 
                                                    processo_seletivo_inscricaos.nome'
                                                    )
        // joins específicos
        ->join('processo_seletivo_notas', 'processo_seletivo_analises.id', 'processo_seletivo_notas.id_processo_seletivo_analise')
        ->join('processo_seletivo_inscricaos', 'processo_seletivo_inscricaos.id', 'processo_seletivo_analises.id_inscricao')
        ->join('processo_seletivo_cursos', 'processo_seletivo_cursos.id', 'processo_seletivo_inscricaos.id_processo_seletivo_curso')
        ->join('auxiliar_municipios', 'auxiliar_municipios.id', 'processo_seletivo_cursos.id_municipio')
        // WhereIn é responsável de trazer apenas a última análise
        ->whereIn('processo_seletivo_analises.id', function($query){
            $query->select(DB::raw('MAX(processo_seletivo_analises.id)'))
            ->from('processo_seletivo_analises')
            ->groupBy('processo_seletivo_analises.id_inscricao');
        })
        // Where responsável para trazer apenas as informações daquele processo seletivo
        ->where('processo_seletivo_cursos.id_processo_seletivo', $id)
        // Tem que fazer o agrupamento das informações
        ->groupBy('processo_seletivo_analises.id', 
                'processo_seletivo_analises.id_inscricao', 
                'processo_seletivo_cursos.id', 
                'processo_seletivo_cursos.titulo', 
                'processo_seletivo_cursos.id_municipio', 
                'auxiliar_municipios.nome', 
                'processo_seletivo_inscricaos.nome')
        // Ordenações, primeiro pelo município, depois pelo curso e por último, pelo total em ordem decrescente
        ->orderBy('municipio')
        ->orderBy('curso')
        ->orderByDesc(DB::raw('SUM(processo_seletivo_notas.nota)'))
        ->get();

        // Info para pegar o nome dos documentos e criar um dicionário
        $info = ProcessoSeletivoConfiguracao::join('processo_seletivo_documentos', 'processo_seletivo_documentos.id', 'processo_seletivo_configuracaos.id_processo_seletivo_doc')
        ->where('id_processo_seletivo', $id)
        ->get()
        ->keyBy('id_processo_seletivo_doc');

        // Processamento de notas
        $data = $data->map(function ($data) use ($info) {
            $notas = DB::table('processo_seletivo_notas')
            ->where('processo_seletivo_notas.id_processo_seletivo_analise', $data->id)
            ->orderBy('processo_seletivo_notas.id_processo_seletivo_doc')
            ->pluck('nota', 'id_processo_seletivo_doc')
            ->toArray();

            //adicionar as notas como novas colunas no resultado
            $total = 0;
            foreach ($notas as $index => $nota){
                $data->{'Nota '. ($info[$index]->nome)} = $nota;
                $total += $nota; 
            }
            $data->total = $total;

            return $data;
        });

        // return $data;

        // Pega a configuração do processo seletivo
        $configuracao = ProcessoSeletivoConfiguracao::join('processo_seletivo_documentos', 'processo_seletivo_documentos.id', 'processo_seletivo_configuracaos.id_processo_seletivo_doc')
        ->where('id_processo_seletivo', $id)
        ->get();
        
        // Cria as colunas que vai no arquivo do excel
        $columns = collect(['ID', 'Inscrição', 'Município', 'Curso', 'Nome']);
        // Itera a configuração de da push na coluna das notas
        foreach ($configuracao as $conf){
            if($conf->pontuacao){
                $columns->push("Nota ".$conf->nome);
            }
        }
        // Adiciona as informações finais
        $columns->push('Total');

        // Nome do Arquivo
        $filename = 'Resultado.csv';
        
        $arquivo = fopen('php://output', 'w');

        // Definir cabeçalho para forçar download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'. $filename .'"');

        fputcsv($arquivo, $columns->all());

        foreach ($data->toArray() as $item){
            // Para pular uma linha de um curso pra outro
            if($item['curso'] != @$old_titulo && @$old_titulo != null){
                fputcsv($arquivo, []);
                fputcsv($arquivo, $columns->all());
            }
            $old_titulo = $item['curso'];     
            fputcsv($arquivo, (array)$item);
        }

        fclose($arquivo);

        exit;

        // Headers
        // $headers = array(
        //     "Content-type"        => "text/csv",
        //     "Content-Disposition" => "attachment; filename=$fileName",
        //     "Pragma"              => "no-cache",
        //     "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        //     "Expires"             => "0"
        // );

        // return $columns;


        // $callback = function() use($data, $columns) {
        //     $file = fopen('php://output', 'w');
        //     fputcsv($file, $columns);

        //     foreach ($data as $item) {
        //         if ($item->inscricao->curso->titulo != @$old_titulo && @$old_titulo != null){
                    
        //             foreach ($columns as $column){
        //                 $row[$column] = '';
        //             }

        //             // $row['ID']  = '';
        //             // $row['Município']  = '';
        //             // $row['Curso']  = '';
        //             // $row['Nome']    = '';
        //             // $row['Nota Titulação']    = '';
        //             // $row['Nota Qualificação']    = '';
        //             // $row['Nota Exp. Profissional']    = '';
        //             // $row['Nota Comprovante de Endereço']    = '';
        //             // $row['Nota Carta de Intenção']    = '';
        //             // $row['Total']    = '';
        //             // $row['Criado em']    = '';
		//             // $row['Mensagem']    = '';
        //             fputcsv($file, array($row['ID'], $row['Município'], $row['Curso'], $row['Nome'], $row['Nota Titulação'], $row['Nota Qualificação'], $row['Nota Exp. Profissional'], $row['Nota Comprovante de Endereço'], $row['Nota Carta de Intenção'], $row['Total'], $row['Criado em'], $row['Mensagem']));
        //         }
        //         $row['ID']  = $item->id_inscricao;
        //         $row['Município']  = $item->inscricao->curso->municipio->nome;
        //         $row['Curso']  = $item->inscricao->curso->titulo;
        //         $row['Nome']    = $item->inscricao->nome;
        //         $row['Nota Titulação']    = $item->nota_titulacao;
        //         $row['Nota Qualificação']    = $item->nota_qualificacao;
        //         $row['Nota Exp. Profissional']    = $item->nota_exp_profissional;
        //         $row['Nota Comprovante de Endereço']    = $item->nota_comprovante_endereco;
        //         $row['Nota Carta de Intenção']    = $item->nota_carta_intencao;
        //         $row['Total']    = $item->total;
        //         $row['Criado em']    = $item->inscricao->created_at;
		//         $row['Mensagem']    = $item->mensagem;
        //         $old_titulo = $item->inscricao->curso->titulo;

        //         fputcsv($file, array($row['ID'], $row['Município'], $row['Curso'], $row['Nome'], $row['Nota Titulação'], $row['Nota Qualificação'], $row['Nota Exp. Profissional'], $row['Nota Comprovante de Endereço'], $row['Nota Carta de Intenção'], $row['Total'], $row['Criado em'], $row['Mensagem']));
        //     }

        //     fclose($file);
        // };

        // return response()->stream($callback, 200, $headers);

        // array_splice($columns, 3, 0, $configuracao);
        // $columns = array('ID', 'Município', 'Curso', 'Nome', 'Nota Titulação', 'Nota Qualificação', 'Nota Exp. Profissional', 'Nota Comprovante de Endereço', 'Nota Carta de Intenção', 'Total', 'Criado em', 'Mensagem');
        // array_push($columns, $configuracao);
        // return $columns;

       

        // $data = ProcessoSeletivoInscricaoNota::select('*', DB::raw('nota_titulacao + nota_qualificacao + nota_exp_profissional + nota_comprovante_endereco + nota_carta_intencao as total') )
        // ->whereIn('id_inscricao', $inscricao)
        // ->where('status', 'Deferido')
        // ->orderBy('total', 'DESC')
        // ->get()
        // ->sortBy(
        //     function($item){
        //         return $item->inscricao->curso->municipio->nome;
        //     }
        // )
        // ->sortBy(
        //     function($item){
        //         return $item->inscricao->curso->titulo;
        //     }
        // );
        // $data = ProcessoSeletivoNota::select('*', DB::raw('nota_titulacao + nota_qualificacao + nota_exp_profissional + nota_comprovante_endereco + nota_carta_intencao as total') )
        // ->whereIn('id_inscricao', $inscricao)
        // ->where('status', 'Deferido')
        // ->orderBy('total', 'DESC')
        // ->get()
        // ->sortBy(
        //     function($item){
        //         return $item->inscricao->curso->municipio->nome;
        //     }
        // )
        // ->sortBy(
        //     function($item){
        //         return $item->inscricao->curso->titulo;
        //     }
        // );
        
        // $data = ProcessoSeletivoNota::selectRaw('id_processo_seletivo_analise, sum(nota)')->whereIn('id_processo_seletivo_analise', $ultimas_analises)->groupBy('id_processo_seletivo_analise')->get();
        // $data = $data->groupBy('id_processo_seletivo_analise');

        // return $data;

        //Exportar o Excel
        // $fileName = 'Resultado.csv';        
        // $headers = array(
        //     "Content-type"        => "text/csv",
        //     "Content-Disposition" => "attachment; filename=$fileName",
        //     "Pragma"              => "no-cache",
        //     "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        //     "Expires"             => "0"
        // );
        // $columns = array('ID', 'Município', 'Curso', 'Nome', 'Nota Titulação', 'Nota Qualificação', 'Nota Exp. Profissional', 'Nota Comprovante de Endereço', 'Nota Carta de Intenção', 'Total', 'Criado em', 'Mensagem');

        // $callback = function() use($data, $columns) {
        //     $file = fopen('php://output', 'w');
        //     fputcsv($file, $columns);

        //     foreach ($data as $item) {
        //         if ($item->inscricao->curso->titulo != @$old_titulo && @$old_titulo != null){
        //             $row['ID']  = '';
        //             $row['Município']  = '';
        //             $row['Curso']  = '';
        //             $row['Nome']    = '';
        //             $row['Nota Titulação']    = '';
        //             $row['Nota Qualificação']    = '';
        //             $row['Nota Exp. Profissional']    = '';
        //             $row['Nota Comprovante de Endereço']    = '';
        //             $row['Nota Carta de Intenção']    = '';
        //             $row['Total']    = '';
        //             $row['Criado em']    = '';
		//             $row['Mensagem']    = '';
        //             fputcsv($file, array($row['ID'], $row['Município'], $row['Curso'], $row['Nome'], $row['Nota Titulação'], $row['Nota Qualificação'], $row['Nota Exp. Profissional'], $row['Nota Comprovante de Endereço'], $row['Nota Carta de Intenção'], $row['Total'], $row['Criado em'], $row['Mensagem']));
        //         }
        //         $row['ID']  = $item->id_inscricao;
        //         $row['Município']  = $item->inscricao->curso->municipio->nome;
        //         $row['Curso']  = $item->inscricao->curso->titulo;
        //         $row['Nome']    = $item->inscricao->nome;
        //         $row['Nota Titulação']    = $item->nota_titulacao;
        //         $row['Nota Qualificação']    = $item->nota_qualificacao;
        //         $row['Nota Exp. Profissional']    = $item->nota_exp_profissional;
        //         $row['Nota Comprovante de Endereço']    = $item->nota_comprovante_endereco;
        //         $row['Nota Carta de Intenção']    = $item->nota_carta_intencao;
        //         $row['Total']    = $item->total;
        //         $row['Criado em']    = $item->inscricao->created_at;
		//         $row['Mensagem']    = $item->mensagem;
        //         $old_titulo = $item->inscricao->curso->titulo;

        //         fputcsv($file, array($row['ID'], $row['Município'], $row['Curso'], $row['Nome'], $row['Nota Titulação'], $row['Nota Qualificação'], $row['Nota Exp. Profissional'], $row['Nota Comprovante de Endereço'], $row['Nota Carta de Intenção'], $row['Total'], $row['Criado em'], $row['Mensagem']));
        //     }

        //     fclose($file);
        // };

        // return response()->stream($callback, 200, $headers);
    }

    public function indeferidos($id){
        $cursos = ProcessoSeletivoCurso::where('id_processo_seletivo', $id)->orderBy('titulo')->pluck('id');
        $inscricao = ProcessoSeletivoInscricao::whereIn('id_processo_seletivo_curso', $cursos)->orderBy('id_processo_seletivo_curso')->pluck('id');
        $data = ProcessoSeletivoInscricaoNota::select('*', DB::raw('nota_titulacao + nota_qualificacao + nota_exp_profissional + nota_comprovante_endereco + nota_carta_intencao as total') )
        ->whereIn('id_inscricao', $inscricao)
        ->where('status', 'Indeferido')
        ->orderBy('total', 'DESC')
        ->get()
        ->sortBy(
            function($item){
                return $item->inscricao->curso->municipio->nome;
            }
        )
        ->sortBy(
            function($item){
                return $item->inscricao->curso->titulo;
            }
        );

        //Exportar o Excel
        $fileName = 'Lista de Indeferidos.csv';        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('ID', 'Município', 'Curso', 'Nome', 'Nota Titulação', 'Nota Qualificação', 'Nota Exp. Profissional', 'Total', 'Criado em', 'Mensagem');

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $item) {
                if ($item->inscricao->curso->titulo != @$old_titulo && @$old_titulo != null){
                    $row['ID']  = '';
                    $row['Município']  = '';
                    $row['Curso']  = '';
                    $row['Nome']    = '';
                    $row['Nota Titulação']    = '';
                    $row['Nota Qualificação']    = '';
                    $row['Nota Exp. Profissional']    = '';
                    $row['Total']    = '';
                    $row['Criado em']    = '';
		            $row['Mensagem']    = '';
                    fputcsv($file, array($row['ID'], $row['Município'], $row['Curso'], $row['Nome'], $row['Nota Titulação'], $row['Nota Qualificação'], $row['Nota Exp. Profissional'], $row['Total'], $row['Criado em'], $row['Mensagem']));
                }
                $row['ID']  = $item->id_inscricao;
                $row['Município']  = $item->inscricao->curso->municipio->nome;
                $row['Curso']  = $item->inscricao->curso->titulo;
                $row['Nome']    = $item->inscricao->nome;
                $row['Nota Titulação']    = $item->nota_titulacao;
                $row['Nota Qualificação']    = $item->nota_qualificacao;
                $row['Nota Exp. Profissional']    = $item->nota_exp_profissional;
                $row['Total']    = $item->total;
                $row['Criado em']    = $item->inscricao->created_at;
		        $row['Mensagem']    = $item->mensagem;
                $old_titulo = $item->inscricao->curso->titulo;

                fputcsv($file, array($row['ID'], $row['Município'], $row['Curso'], $row['Nome'], $row['Nota Titulação'], $row['Nota Qualificação'], $row['Nota Exp. Profissional'], $row['Total'], $row['Criado em'], $row['Mensagem']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function resultadoForm($id){
        $cursos = ProcessoSeletivoCurso::where('id_processo_seletivo', $id)->orderBy('titulo')->pluck('id');
        $inscricao = ProcessoSeletivoInscricao::whereIn('id_processo_seletivo_curso', $cursos)->orderBy('id_processo_seletivo_curso')->pluck('id');
        $data = ProcessoSeletivoInscricaoNota::select('*', DB::raw('nota_titulacao + nota_qualificacao + nota_exp_profissional as total') )
        ->whereIn('id_inscricao', $inscricao)
        ->where('status', 'Deferido')
        ->orderBy('total', 'DESC')
        ->get()
        ->sortBy(
            function($item){
                return $item->inscricao->curso->municipio->nome;
            }
        )
        ->sortBy(
            function($item){
                return $item->inscricao->curso->titulo;
            }
        );
        return view('processoSeletivo.formResultado', [
            'id_processo_seletivo' => $id,
            'data' => $data
        ]);
    }

    public function resultadoStore(Request $request, $id){
        if($request->file){
            $request->file->storeAs("public/editais/$id", 'resultado.pdf');
        }
        $request["resultado"] = true;
        $validatedData = $request->validate([
            'resultado' => 'required',
        ]);
        // return $validatedData;
        ProcessoSeletivo::whereId($id)->update($validatedData);
        return redirect()->route("ps.index")->with('success', 'Resultado cadastrado com sucesso!');
    }

    public function removeFile($id, $fileName){
        Storage::delete('public/editais/'.$id.'/documentos_adicionais/'.$fileName);
        return redirect()->back();
    }

    public function pessoasIndex(){
        // $data = ProcessoSeletivo::orderBy('id', 'DESC')->paginate(10);
        $data = ProcessoSeletivoInscricao::orderBy('id', 'DESC')->paginate(10);
        // return $data;
        return view('processoSeletivo.pessoas.index', [
            'data' => $data,
        ]);
    }

    public function pessoaIndexSearch(Request $request){
        $data = ProcessoSeletivoInscricao::where('nome', 'LIKE', "%".$request->pesquisa."%")->orWhere('numero_documento', '=', $request->pesquisa)->orderBy('id', 'DESC')->paginate(20);
        return view('processoSeletivo.pessoas.index', [
            'data' => $data,
        ]);
    }
}
