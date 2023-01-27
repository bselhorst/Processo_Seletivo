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
                <label class="col-form-label col-lg-2 offset-lg-1">Edital (PDF) <span class="text-danger">*</span></label>
                <div class="col-lg-6">
                    <input type="file" name="file" id="file" class="{{ (@$data)? 'file-input': 'file-input-required' }}" data-msg-required="Por favor selecione um arquivo" >
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