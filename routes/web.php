<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuxiliarMunicipioController;
use App\Http\Controllers\AuxiliarTipoDocumentoController;
use App\Http\Controllers\ProcessoSeletivoController;
use App\Http\Controllers\ProcessoSeletivoComunicadoController;
use App\Http\Controllers\ProcessoSeletivoCursoController;
use App\Http\Controllers\ProcessoSeletivoInscricaoController;
use App\Http\Controllers\ProcessoSeletivoInscricaoNotaController;
use App\Http\Controllers\ProcessoSeletivoNotaController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProcessoSeletivoDocumentosController;
use Illuminate\Support\Facades\Route;
use App\Models\AuxiliarTipoDocumento;
use App\Models\ProcessoSeletivo;
use App\Models\ProcessoSeletivoComunicado;
use App\Models\ProcessoSeletivoCurso;
use App\Models\ProcessoSeletivoInscricao;
use App\Models\ProcessoSeletivoInscricaoNota;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Mail\Confirmacao;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//ROTA AUXILIARES
Route::prefix('auxiliares')->group(function () {
    Route::prefix('municipios')->group(function () {
        Route::get('/', [AuxiliarMunicipioController::class, 'index'])->middleware(['auth', 'verified'])->name('aux.municipio.index');
        Route::post('/search', [AuxiliarMunicipioController::class, 'indexSearch'])->middleware(['auth', 'verified'])->name('aux.municipio.indexSearch');
        Route::get('/{id}', [AuxiliarMunicipioController::class, 'edit'])->middleware(['auth', 'verified'])->name('aux.municipio.edit');
        Route::post('/', [AuxiliarMunicipioController::class, 'store'])->middleware(['auth', 'verified'])->name('aux.municipio.store');
        Route::patch('/{id}', [AuxiliarMunicipioController::class, 'update'])->middleware(['auth', 'verified'])->name('aux.municipio.update');
        Route::delete('/{id}', [AuxiliarMunicipioController::class, 'destroy'])->middleware(['auth', 'verified'])->name('aux.municipio.destroy');
    });
    Route::prefix('tipo_documentos')->group(function () {
        Route::get('/', [AuxiliarTipoDocumentoController::class, 'index'])->middleware(['auth', 'verified'])->name('aux.tipodocumento.index');
        Route::post('/search', [AuxiliarTipoDocumentoController::class, 'indexSearch'])->middleware(['auth', 'verified'])->name('aux.tipodocumento.indexSearch');
        Route::get('/{id}', [AuxiliarTipoDocumentoController::class, 'edit'])->middleware(['auth', 'verified'])->name('aux.tipodocumento.edit');
        Route::post('/', [AuxiliarTipoDocumentoController::class, 'store'])->middleware(['auth', 'verified'])->name('aux.tipodocumento.store');
        Route::patch('/{id}', [AuxiliarTipoDocumentoController::class, 'update'])->middleware(['auth', 'verified'])->name('aux.tipodocumento.update');
        Route::delete('/{id}', [AuxiliarTipoDocumentoController::class, 'destroy'])->middleware(['auth', 'verified'])->name('aux.tipodocumento.destroy');
    });
});

//ROTA AUXILIARES
Route::prefix('usuarios')->middleware('admin')->group(function () {
    Route::get('/', [UsuariosController::class, 'index'])->middleware(['auth', 'verified'])->name('usuarios.index');
    Route::post('/search', [UsuariosController::class, 'indexSearch'])->middleware(['auth', 'verified'])->name('usuarios.indexSearch');
    Route::get('/{id}', [UsuariosController::class, 'edit'])->middleware(['auth', 'verified'])->name('usuarios.edit');
    Route::post('/', [UsuariosController::class, 'store'])->middleware(['auth', 'verified'])->name('usuarios.store');
    Route::patch('/{id}', [UsuariosController::class, 'update'])->middleware(['auth', 'verified'])->name('usuarios.update');
    Route::delete('/{id}', [UsuariosController::class, 'destroy'])->middleware(['auth', 'verified'])->name('usuarios.destroy');
});

//ROTA PROCESSO SELETIVO E CURSOS
Route::prefix('processoseletivo')->group(function () {
    //PARTE GERAL DO PROCESSO SELETIVO
    Route::get('/', [ProcessoSeletivoController::class, 'index'])->middleware(['auth', 'verified'])->name('ps.index');
    Route::post('/search', [ProcessoSeletivoController::class, 'indexSearch'])->middleware(['auth', 'verified'])->name('ps.indexSearch');
    Route::get('/form', [ProcessoSeletivoController::class, 'create'])->middleware(['auth', 'verified'])->name('ps.create');
    Route::get('/form/{id}', [ProcessoSeletivoController::class, 'edit'])->middleware(['auth', 'verified'])->name('ps.edit');
    Route::post('/', [ProcessoSeletivoController::class, 'store'])->middleware(['auth', 'verified'])->name('ps.store');
    Route::patch('/{id}', [ProcessoSeletivoController::class, 'update'])->middleware(['auth', 'verified'])->name('ps.update');
    Route::delete('/{id}', [ProcessoSeletivoController::class, 'destroy'])->middleware(['auth', 'verified'])->name('ps.destroy');
    Route::get('/{id}/resultado', [ProcessoSeletivoController::class, 'resultado'])->middleware(['auth', 'verified'])->name('ps.resultado');
    Route::get('/{id}/indeferidos', [ProcessoSeletivoController::class, 'indeferidos'])->middleware(['auth', 'verified'])->name('ps.indeferidos');
    // Route::get('/{id}/resultadoForm', [ProcessoSeletivoController::class, 'resultadoForm'])->middleware(['auth', 'verified'])->name('ps.resultadoForm');
    Route::patch('/{id}/resultadoForm', [ProcessoSeletivoController::class, 'resultadoStore'])->middleware(['auth', 'verified'])->name('ps.resultadoStore');
    Route::get('/removeFile/{id}/{filename}', [ProcessoSeletivoController::class, 'removeFile'])->middleware(['auth', 'verified'])->name('ps.removeFile');

    //PESQUISA DE PESSOAS EM TODOS OS PROCESSO SELETIVOS
    Route::get('/pessoas', [ProcessoSeletivoController::class, 'pessoasIndex'])->middleware(['auth', 'verified'])->name('ps.pessoaIndex');
    Route::match(array('GET', 'POST'), '/pessoas/search', [ProcessoSeletivoController::class, 'pessoaIndexSearch'])->middleware(['auth', 'verified'])->name('ps.pessoaIndexSearch');

    //Classificação e Resultado
    Route::get('/{id}/resultadoForm', [ProcessoSeletivoController::class, 'resultadoForm'])->middleware(['auth', 'verified'])->name('ps.resultadoForm');

    //CURSOS COM UM PREFIXO DE CURSOS
    Route::prefix('{id_processo_seletivo}/comunicados')->group(function () {
        Route::get('/', [ProcessoSeletivoComunicadoController::class, 'index'])->middleware(['auth', 'verified'])->name('pscom.index');
        // Route::post('/search', [ProcessoSeletivoCursoController::class, 'indexSearch'])->middleware(['auth', 'verified'])->name('pc.indexSearch');
        // Route::get('/form', [ProcessoSeletivoCursoController::class, 'create'])->middleware(['auth', 'verified'])->name('pc.create');
        Route::get('/{id}', [ProcessoSeletivoComunicadoController::class, 'edit'])->middleware(['auth', 'verified'])->name('pscom.edit');
        Route::post('/', [ProcessoSeletivoComunicadoController::class, 'store'])->middleware(['auth', 'verified'])->name('pscom.store');
        Route::patch('/{id}', [ProcessoSeletivoComunicadoController::class, 'update'])->middleware(['auth', 'verified'])->name('pscom.update');
        Route::delete('/{id}', [ProcessoSeletivoComunicadoController::class, 'destroy'])->middleware(['auth', 'verified'])->name('pscom.destroy');
    });

    //CURSOS COM UM PREFIXO DE CURSOS
    Route::prefix('{id_processo_seletivo}/cursos')->group(function () {
        Route::get('/', [ProcessoSeletivoCursoController::class, 'index'])->middleware(['auth', 'verified'])->name('pc.index');
        Route::post('/search', [ProcessoSeletivoCursoController::class, 'indexSearch'])->middleware(['auth', 'verified'])->name('pc.indexSearch');
        Route::get('/form', [ProcessoSeletivoCursoController::class, 'create'])->middleware(['auth', 'verified'])->name('pc.create');
        Route::get('/form/{id}', [ProcessoSeletivoCursoController::class, 'edit'])->middleware(['auth', 'verified'])->name('pc.edit');
        Route::post('/', [ProcessoSeletivoCursoController::class, 'store'])->middleware(['auth', 'verified'])->name('pc.store');
        Route::patch('/{id}', [ProcessoSeletivoCursoController::class, 'update'])->middleware(['auth', 'verified'])->name('pc.update');
        Route::delete('/{id}', [ProcessoSeletivoCursoController::class, 'destroy'])->middleware(['auth', 'verified'])->name('pc.destroy');
    });

    //CURSOS COM UM PREFIXO DE CURSOS
    Route::prefix('{id_processo_seletivo}/inscricoes')->group(function () {
        Route::get('/json', [ProcessoSeletivoInscricaoController::class, 'json'])->middleware(['auth', 'verified'])->name('pi.json');
        Route::get('/', [ProcessoSeletivoInscricaoController::class, 'index'])->middleware(['auth', 'verified'])->name('pi.index');
        Route::post('/', [ProcessoSeletivoNotaController::class, 'store'])->middleware(['auth', 'verified'])->name('pn.store');
        Route::patch('/detalhes/{id}', [ProcessoSeletivoNotaController::class, 'update'])->middleware(['auth', 'verified'])->name('pn.update');
        // Route::post('/', [ProcessoSeletivoInscricaoNotaController::class, 'store'])->middleware(['auth', 'verified'])->name('pn.store');
        // Route::patch('/detalhes/{id}', [ProcessoSeletivoInscricaoNotaController::class, 'update'])->middleware(['auth', 'verified'])->name('pn.update');
        Route::match(array('get', 'post'), '/search', [ProcessoSeletivoInscricaoController::class, 'indexSearch'])->middleware(['auth', 'verified'])->name('pi.indexSearch');
        Route::get('/{id}', [ProcessoSeletivoInscricaoController::class, 'detalhes'])->middleware(['auth', 'verified'])->name('pi.detalhes');
        Route::get('/{path}', [ProcessoSeletivoInscricaoController::class, 'downloadArquivo'])->middleware(['auth', 'verified'])->name('pi.download.arquivo');
    });

    // Auxiliar de documentos do processo seletivo
    Route::prefix('documentos')->group(function () {
        Route::get('/', [ProcessoSeletivoDocumentosController::class, 'index'])->middleware(['auth', 'verified'])->name('psdoc.index');
        Route::post('/search', [ProcessoSeletivoDocumentosController::class, 'indexSearch'])->middleware(['auth', 'verified'])->name('psdoc.indexSearch');
        Route::get('/{id}', [ProcessoSeletivoDocumentosController::class, 'edit'])->middleware(['auth', 'verified'])->name('psdoc.edit');
        Route::post('/', [ProcessoSeletivoDocumentosController::class, 'store'])->middleware(['auth', 'verified'])->name('psdoc.store');
        Route::patch('/{id}', [ProcessoSeletivoDocumentosController::class, 'update'])->middleware(['auth', 'verified'])->name('psdoc.update');
        Route::delete('/{id}', [ProcessoSeletivoDocumentosController::class, 'destroy'])->middleware(['auth', 'verified'])->name('psdoc.destroy');
    });
});

//ROTA DO EDITAL
Route::get('/edital/{id}', function ($id) {
    return view('edital', [
        'data' => ProcessoSeletivo::findOrFail($id),
        'data_curso' => ProcessoSeletivoCurso::where("id_processo_seletivo", $id)->get(),
        'comunicados' => ProcessoSeletivoComunicado::where("id_processo_seletivo", $id)->get(),
        'salario' => ProcessoSeletivoCurso::where("id_processo_seletivo", $id)->where("salario", ">", 0)->get(),
    ]);
})->name('edital');

//ROTA DO RESULTADO
Route::get('/resultado/{id}', function ($id) {
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
    return view('resultado', [
        'id_processo_seletivo' => $id,
        'inscritos' => $data,
        'data' => ProcessoSeletivo::findOrFail($id),
    ]);
})->name('resultado');

//ROTA FORMULÁRIO DE INSCRIÇÃO
Route::get('/inscricao/{id?}/{id_curso?}', function ($id = null, $id_curso = null) {
    return view('visitantes.formularioInscricao', [
        'vagas' => DB::table('processo_seletivo_cursos')
                    ->join('auxiliar_municipios', 'processo_seletivo_cursos.id_municipio', 'auxiliar_municipios.id')
                    ->join('processo_seletivos', 'processo_seletivo_cursos.id_processo_seletivo', 'processo_seletivos.id')
                    ->select('processo_seletivo_cursos.id as id', 'auxiliar_municipios.nome as municipio', 'processo_seletivo_cursos.titulo as titulo', 'processo_seletivos.titulo as processo_seletivo')
                    ->whereRaw("processo_seletivos.data_abertura <= CURRENT_TIMESTAMP")
                    ->whereRaw("processo_seletivos.data_encerramento >= CURRENT_TIMESTAMP")
                    ->orderBy('processo_seletivo_cursos.id_processo_seletivo')
                    ->orderBy('auxiliar_municipios.nome')
                    ->orderBy('processo_seletivo_cursos.titulo')
                    ->get(),
        'id_processo' => $id,
        'id_vaga' => $id_curso,
        'configuracao' => DB::table('processo_seletivo_configuracaos')
                            ->join('processo_seletivo_documentos', 'processo_seletivo_configuracaos.id_processo_seletivo_doc', 'processo_seletivo_documentos.id')
                            ->where('processo_seletivo_configuracaos.id_processo_seletivo', $id)
                            ->get(),
        'tipo_documentos' => AuxiliarTipoDocumento::orderBy("nome")->get(),
    ]);
})->name('inscricao');

// Redirecionamento ao selecionar a vaga
Route::get('/redirecionamento/inscricao/{id}', function ($id_curso) {
    $curso = ProcessoSeletivoCurso::findOrFail($id_curso);
    return redirect()->route('inscricao', ['id' => $curso->id_processo_seletivo, 'id_curso' => $id_curso]);
});

Route::get('/inscricao/{id?}/{id_curso?}/teste', function ($id = null, $id_curso = null) {
    return DB::table('processo_seletivo_cursos')
                    ->join('auxiliar_municipios', 'processo_seletivo_cursos.id_municipio', 'auxiliar_municipios.id')
                    ->join('processo_seletivos', 'processo_seletivo_cursos.id_processo_seletivo', 'processo_seletivos.id')
                    ->select('processo_seletivo_cursos.id as id', 'auxiliar_municipios.nome as municipio', 'processo_seletivo_cursos.titulo as titulo', 'processo_seletivos.titulo as processo_seletivo')
                    ->whereRaw("processo_seletivos.data_abertura <= CURRENT_TIMESTAMP")
                    ->whereRaw("processo_seletivos.data_encerramento >= CURRENT_TIMESTAMP")
                    ->get();
                    
})->name('inscricao-teste');

Route::post('/inscricao', [ProcessoSeletivoInscricaoController::class, 'store'])->name('inscricao.store');

// //ROTA RESULTADO
// Route::get("/resultado", function(){
//     $data = ProcessoSeletivoInscricao::whereRelation('curso.municipio', 'id', 2)->get();
//     return $data;
// });

Route::get('/{id}/downloadEdital', [ProcessoSeletivoController::class, 'downloadEdital'])->middleware(['auth', 'verified'])->name('download.edital');

Route::get('/cursos', [ProcessoSeletivoCursoController::class, 'index'])->middleware(['auth', 'verified'])->name('psc.index');

Route::get('/teste', function(){
    return Auth::user();
});

Route::get('/perfil', function(){
    return view('profile.perfil', [
            'user' => Auth::user(),
        ]);
})->middleware('auth')->name('profile.perfil');

Route::get('/', function () {
    return view('index', [
        'data' => ProcessoSeletivo::where('data_abertura', '<=', date('Y-m-d h:i:s'))->orderBy('data_abertura', 'DESC')->orderBy('data_encerramento', 'DESC')->orderBy('id', 'DESC')->paginate(10),
    ]);
});

Route::get('/dashboard', function () {
    return redirect()->route('ps.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/register', function () {
//     return view('auth.register');
// })->middleware(['auth', 'verified', 'admin']);

// Route::get('/register', function () {
//     return redirect()->route("usuarios.index");
// })->middleware('admin');

// Route::get('/emailteste/{email}', function($email) {
//     $teste = [
//         "nome" => "Tiago Marcos de Souza Pereira",
//         "id_processo_seletivo" => 1,
//         "id_processo_seletivo_curso" => 2,
//         "id_tipo_documento" => 1,
//         "numero_documento" => "132132132",
//         "numero_contato" => "32132132132",
//         "email" => "teste@teste.com"
//     ];

//     Mail::to($email)->send(new Confirmacao($teste));
// });

Route::get('/emailteste', function() {
    $teste = [
        "nome" => "Bruno Oliveira Selhorst",
        "id_processo_seletivo" => 1,
        "id_processo_seletivo_curso" => 2,
        "id_tipo_documento" => 1,
        "numero_documento" => "132132132",
        "numero_contato" => "32132132132",
        "email" => "teste@teste.com"
    ];
    return view('mail.confirmacao' , [
        'data' => $teste
    ]);
});

Route::get('/teste/paginaprincipal', function () {
    return view('teste.paginaprincipal');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
