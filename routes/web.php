<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuxiliarMunicipioController;
use App\Http\Controllers\AuxiliarTipoDocumentoController;
use App\Http\Controllers\ProcessoSeletivoController;
use App\Http\Controllers\ProcessoSeletivoCursoController;
use Illuminate\Support\Facades\Route;
use App\Models\AuxiliarTipoDocumento;
use App\Models\ProcessoSeletivo;
use App\Models\ProcessoSeletivoCurso;
use Illuminate\Support\Facades\DB;

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
});

//ROTA DO EDITAL
Route::get('/edital/{id}', function ($id) {
    return view('edital', [
        'data' => ProcessoSeletivo::findOrFail($id),
        'data_curso' => ProcessoSeletivoCurso::where("id_processo_seletivo", $id)->get(),
        'salario' => ProcessoSeletivoCurso::where("salario", ">", 0)->get(),
    ]);
})->name('edital');

//ROTA FORMULÁRIO DE INSCRIÇÃO
Route::get('/inscricao/{id?}/{id_curso?}', function ($id = null, $id_curso = null) {
    return view('visitantes.formularioInscricao', [
        'vagas' => DB::table('processo_seletivo_cursos')
                    ->join('auxiliar_municipios', 'processo_seletivo_cursos.id_municipio', 'auxiliar_municipios.id')
                    ->join('processo_seletivos', 'processo_seletivo_cursos.id_processo_seletivo', 'processo_seletivos.id')
                    ->select('processo_seletivo_cursos.id as id', 'auxiliar_municipios.nome as municipio', 'processo_seletivo_cursos.titulo as titulo', 'processo_seletivos.titulo as processo_seletivo')
                    ->get(),
        'id_vaga' => $id_curso,
        'tipo_documentos' => AuxiliarTipoDocumento::orderBy("nome")->get(),
    ]);
})->name('inscricao');



//CURSOS COM UM PREFIXO DE CURSOS
// Route::get('/processoseletivo/{id_processoseletivo}/cursos', [ProcessoSeletivoCursoController::class, 'index'])->middleware(['auth', 'verified'])->name('psc2.index');
// Route::post('/processoseletivo/{id_processoseletivo}/curso_search', [ProcessoSeletivoCursoController::class, 'indexSearch'])->middleware(['auth', 'verified'])->name('psc.indexSearch');
// Route::get('/processoseletivo/{id_processoseletivo}/curso_form', [ProcessoSeletivoCursoController::class, 'create'])->middleware(['auth', 'verified'])->name('psc.create');
// Route::get('/processoseletivo/{id_processoseletivo}/curso_form/{id}', [ProcessoSeletivoCursoController::class, 'edit'])->middleware(['auth', 'verified'])->name('psc.edit');
// Route::post('/processoseletivo/{id_processoseletivo}/curso', [ProcessoSeletivoCursoController::class, 'store'])->middleware(['auth', 'verified'])->name('psc.store');
// Route::patch('/processoseletivo/{id_processoseletivo}/curso/{id}', [ProcessoSeletivoCursoController::class, 'update'])->middleware(['auth', 'verified'])->name('psc.update');
// Route::delete('/processoseletivo/{id_processoseletivo}/curso/{id}', [ProcessoSeletivoCursoController::class, 'destroy'])->middleware(['auth', 'verified'])->name('psc.destroy');

Route::get('/{id}/downloadEdital', [ProcessoSeletivoController::class, 'downloadEdital'])->middleware(['auth', 'verified'])->name('download.edital');

Route::get('/cursos', [ProcessoSeletivoCursoController::class, 'index'])->middleware(['auth', 'verified'])->name('psc.index');

Route::get('/teste', function(){
    return view('teste', [
            'user' => Auth::user(),
        ]);
});

Route::get('/perfil', function(){
    return view('profile.perfil', [
            'user' => Auth::user(),
        ]);
})->middleware('auth')->name('profile.perfil');

Route::get('/', function () {
    return view('index', [
        'data' => ProcessoSeletivo::orderBy('data_encerramento', 'DESC')->orderBy('data_abertura', 'DESC')->orderBy('id', 'DESC')->paginate(10),
    ]);
});





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard2', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard2');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
