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
                        @if (Storage::get("public/editais/$data->id/resultado.pdf"))
                            <a href="/storage/editais/{{$data->id}}/resultado.pdf" target="_blank" class="btn btn-outline-danger flex-column py-2 mx-2">
                                <i class="ph-file-pdf ph-2x mb-1"></i>
                                Ver Resultado Atual
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