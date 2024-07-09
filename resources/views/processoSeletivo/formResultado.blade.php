<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
?>
@extends('layouts.layout')
@section('content')

<!-- Custom styles -->
<div class="card">
    <form class="needs-validation" method='POST' action="{{ route('ps.resultadoStore', $id_processo_seletivo) }}" enctype='multipart/form-data' novalidate>
        @csrf
        @method('patch')
        <div class="card-body">            
            <div class="fw-bold border-bottom pb-2 mb-3 ">Publicar Resultado</div>
            <p class="mb-4  offset-lg-1">Adicione o PDF do resultado abaixo.</p>
            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Resultado <code>(PDF)</code> <span class="text-danger">*</span></label>
                <div class="col-lg-6">
                    <input type="file" name="file" id="file" class="{{ (@$data)? 'file-input': 'file-input-required' }}" data-msg-required="Por favor selecione um arquivo" accept=".pdf">
                </div>
                <div class="col-lg-3">
                    @if (@$data)
                        @if (Storage::get("public/editais/$id_processo_seletivo/resultado.pdf"))
                            <a href="/storage/editais/{{$id_processo_seletivo}}/resultado.pdf" target="_blank" class="btn btn-outline-danger flex-column py-2 mx-2">
                                <i class="ph-file-pdf ph-2x mb-1"></i>
                                Ver Resultado Atual
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            {{-- <div class="row mb-3">
                <div class="col-lg-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10%">Classificação</th>
                                <th>Documento</th>
                                <th>Nome</th>
                                <th>Idade</th>
                                <th>PCD</th>
                                <th>Titulação</th>
                                <th>Qualificação</th>
                                <th>Exp. Profissional</th>
                                <th>Pontuação Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($old_titulo = null)
                            
                            @foreach ($data as $item) 
                                
                                @if (($item->inscricao->curso->titulo != @$old_titulo && @$old_titulo != null) OR @$old_titulo == null)
                                    @php($classificacao = 1)
                                    <tr>
                                        <td colspan="9" style="font-size: 16px"><b>{{ $item->inscricao->curso->municipio->nome." / ".$item->inscricao->curso->titulo }}</td>
                                    </tr>                                        
                                @endif

                                <tr>
                                    <td>{{ $classificacao }}</td>
                                    <td>{{ $item->inscricao->tipo_documento->nome.": ".$item->inscricao->numero_documento }}</td>
                                    <td>{{ $item->inscricao->nome }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->inscricao->data_nascimento)->diff(\Carbon\Carbon::now())->format('%y anos')  }}</td>
                                    <td>{{ $item->inscricao->deficiencia == 1 ? 'SIM' : 'NÃO' }}</td>
                                    <td>{{ $item->nota_titulacao }}</td>
                                    <td>{{ $item->nota_qualificacao }}</td>
                                    <td>{{ $item->nota_exp_profissional }}</td>
                                    <td>{{ $item->total }}</td>
                                </tr>
                                    
                                @php($old_titulo = $item->inscricao->curso->titulo)
                                @php($classificacao++)
                            @endforeach
                        </tbody>
                    </table>
                </div>                
            </div> --}}

            <div class="card-footer text-end">
                <a href="{{ route('ps.index') }}" class="btn btn-danger">Cancelar </a>
                @if (@$data_edit)
                    <button type="submit" class="btn btn-success">Editar </button>
                @else
                    <button type="submit" class="btn btn-success">Publicar Resultado </button>
                @endif
            </div>
        </div>        
    </form>
</div>

@stop