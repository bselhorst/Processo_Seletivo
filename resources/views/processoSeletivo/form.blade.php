<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
?>
@extends('layouts.layout')
@section('content')

<!-- Custom styles -->
<div class="card">
    <form class="needs-validation" method='POST' action="{{ @$data ? route('ps.update', $data->id) : route('ps.store') }}" enctype='multipart/form-data' novalidate>
        @csrf
        @if (@$data)
            @method('patch')
        @endif
        <div class="card-body">            
            <div class="fw-bold border-bottom pb-2 mb-3 ">Informações do Processo Seletivo</div>
            <p class="mb-4  offset-lg-1">Adicione um novo processo seletivo com as informações abaixo.</p>
            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Título <span class="text-danger">*</span></label>
                <div class="col-lg-8">
                    <input type="text" name="titulo" class="form-control" placeholder="Título" value="{{ (@$data->titulo) ? $data->titulo : '' }}" required>
                    <div class="invalid-feedback">Campo obrigatório!</div>
                    <div class="valid-feedback">Campo válido</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Descrição <span class="text-danger">*</span></label>
                <div class="col-lg-8">
                    <textarea name="descricao" rows="7" class="form-control" placeholder="Descrição" required>{{ (@$data->descricao) ? $data->descricao : '' }}</textarea>
                    <div class="invalid-feedback">Campo obrigatório!</div>
                    <div class="valid-feedback">Campo válido</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Data de Abertura <span class="text-danger">*</span></label>
                <div class="col-lg-3">
                    <input type="datetime-local" id="data_abertura" name="data_abertura" class="form-control" value="{{ (@$data->data_abertura) ? $data->data_abertura : '' }}" required>
                    <div class="invalid-feedback">Campo obrigatório!</div>
                    <div class="valid-feedback">Campo válido</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Data de Encerramento <span class="text-danger">*</span></label>
                <div class="col-lg-3">
                    <input type="datetime-local" id="data_encerramento" name="data_encerramento" class="form-control" value="{{ (@$data->data_encerramento) ? $data->data_encerramento : '' }}" required>
                    <div class="invalid-feedback">Campo obrigatório!</div>
                    <div class="valid-feedback">Campo válido</div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Documentos do Processo Seletivo<span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <div class="table-responsive border rounded col-lg-9">
                        <table class="table">
                            <tr>
                                <th>Ativo</th>
                                <th>Documento</th>
                                <th>É obrigatório</th>
                                <th>Possui Pontuação</th>
                                <th>Pode enviar vários arquivos</th>
                            </tr>
                            @foreach ($documentos as $item)
                                <tr>
                                    {{-- <td class='text-center'><input type="checkbox" name="documentos[{{ tirarAcentos(preg_replace("/\s+/", "_",strtolower($item->nome))) }}][ativo]" class="form-check-input"></td> --}}
                                    <td class='text-center'><input type="checkbox" name="documentos[{{ $item->id }}][ativo]" class="form-check-input" {{ @$configuracao[$item->id] ? 'checked' : '' }}></td>
                                    {{-- <td>{{ preg_replace("/\s+/", "_",strtolower($item->nome)) }}</td> --}}
                                    <td>{{$item->nome}}</td>
                                    <td class='text-center'><input type="checkbox" name="documentos[{{ $item->id }}][required]" class="form-check-input" {{ @$configuracao[$item->id]->obrigatorio ? 'checked' : '' }}></td>
                                    <td class='text-center'><input type="checkbox" name="documentos[{{ $item->id }}][score]" class="form-check-input" {{ @$configuracao[$item->id]->pontuacao ? 'checked' : '' }}></td>
                                    <td class='text-center'><input type="checkbox" name="documentos[{{ $item->id }}][multiple]" class="form-check-input" {{ @$configuracao[$item->id]->multiplos_arquivos ? 'checked' : '' }}></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {{-- @foreach ($documentos as $item)
                        <input type="checkbox" name="vehicle1" id="vehicle1" class=""> <label for="vehicle1">{{$item->nome}}</label>
                    @endforeach --}}
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Edital <code>(PDF)</code> <span class="text-danger">*</span></label>
                <div class="col-lg-6">
                    <input type="file" name="file" id="file" class="{{ (@$data)? 'file-input': 'file-input-required' }}" data-msg-required="Por favor selecione um arquivo" accept=".pdf">
                </div>
                <div class="col-lg-3">
                    @if (@$data)
                        @if (Storage::get("public/editais/$data->id/edital.pdf"))
                            <a href="/storage/editais/{{$data->id}}/edital.pdf" target="_blank" class="btn btn-outline-danger flex-column py-2 mx-2">
                                <i class="ph-file-pdf ph-2x mb-1"></i>
                                Ver Edital Atual
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Documentos Adicionais <code>(PDF, DOC e DOCX)</code> <span class="text-danger">*</span></label>
                <div class="col-lg-6">
                    <input type="file" name="documentos_adicionais[]" id="documentos_adicionais" class="{{ (@$data)? 'file-input': 'file-input-required' }}" data-msg-required="Por favor selecione um arquivo" multiple="multiple" accept=".pdf,.doc,.docx">
                </div>
            </div>
            @if (@$data)
                <div class="row mb-3">
                    <div class="col-lg-6 offset-lg-3">
                        @php
                            $documentos_adicionais = Storage::files("public/editais/$data->id/documentos_adicionais");
                        @endphp
                        @if (@$documentos_adicionais)
                        <h6>Documentos Adicionais</h6>    
                            <table class="table">
                                <th>Arquivo</th>
                                <th>Ação</th>
                                @foreach ($documentos_adicionais as $documento)
                                    <tr>
                                        <td>{{ explode("/", $documento)[4] }}</td>
                                        <td><a class="btn btn-danger" href="{{ route('ps.removeFile', [$data->id, explode("/", $documento)[4]]) }}">Deletar</a></td>
                                    </tr>
                                    {{-- <a href="{{ Storage::url($documento) }}" target="_blank" class="btn {{ (explode(".", explode("/", $documento)[4])[1] == 'pdf')?'btn-outline-danger':'btn-outline-primary' }} flex-column">
                                        <i class="{{ (explode(".", explode("/", $documento)[4])[1] == 'pdf')?'ph-file-pdf':'ph-file-doc' }} ph-2x mb-1"></i>
                                        {{ explode("/", $documento)[4] }}
                                    </a>
                                    <button>Deletar</button> --}}
                                @endforeach
                            </table>
                        @else
                            <h6>Não possui documentos adicionais</h6> 
                        @endif   
                    </div>
                </div>
            @endif

            <div class="card-footer text-end">
                <a href="{{ route('ps.index') }}" class="btn btn-primary">Cancelar </a>
                @if (@$data)
                    <button type="submit" class="btn btn-primary">Editar </button>
                @else
                    <button type="submit" class="btn btn-primary">Salvar </button>
                @endif
            </div>
        </div>        
    </form>
</div>

@stop