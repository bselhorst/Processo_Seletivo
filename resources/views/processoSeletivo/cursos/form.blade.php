<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
?>
@extends('layouts.layout')
@section('content')

<!-- Custom styles -->
<div class="card">
    <form class="needs-validation" method='POST' action="{{ @$data ? route('pc.update', [$id_processo_seletivo, $data->id]) : route('pc.store', $id_processo_seletivo) }}" enctype='multipart/form-data' novalidate>
        @csrf
        @if (@$data)
            @method('patch')
        @endif
        <div class="card-body">            
            <div class="fw-bold border-bottom pb-2 mb-3 ">Informações do Processo Seletivo</div>
            <p class="mb-4  offset-lg-1">Adicione um novo processo seletivo com as informações abaixo.</p>

            <div class="mb-3 row">
                <label class="col-form-label col-lg-2 offset-lg-1">Municípios</label>
                <div class="col-lg-4">
                    <select class="form-control select" name="id_municipio" required>
                        <option value="">Selecione um município</option>
                        @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}" {{ (@$data->id_processo_seletivo == $municipio->id)? 'selected':'' }}>{{ $municipio->nome }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Campo obrigatório!</div>
                    <div class="valid-feedback">Campo válido</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Título <span class="text-danger">*</span></label>
                <div class="col-lg-8">
                    <input type="text" name="titulo" class="form-control" placeholder="Título" value="{{ (@$data->titulo) ? $data->titulo : '' }}" required>
                    <div class="invalid-feedback">Campo obrigatório!</div>
                    <div class="valid-feedback">Campo válido</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Descrição</label>
                <div class="col-lg-8">
                    <textarea name="descricao" rows="7" class="form-control" placeholder="Descrição">{{ (@$data->descricao) ? $data->descricao : '' }}</textarea>
                    <div class="invalid-feedback">Campo obrigatório!</div>
                    <div class="valid-feedback">Campo válido</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Salário</label>
                <div class="col-lg-2">
                    <input type="number" min="0.00" step="0.01" name="salario" class="form-control" placeholder="0.00" value="{{ (@$data->salario) ? $data->salario : '' }}">
                    <div class="invalid-feedback">Campo obrigatório!</div>
                    <div class="valid-feedback">Campo válido</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Carga Horária <span class="text-danger">*</span></label>
                <div class="col-lg-2">
                    <input type="number" min=0 step=1 name="carga_horaria" placeholder="0" class="form-control number" value="{{ (@$data->carga_horaria) ? $data->carga_horaria : '' }}" required>
                    <div class="invalid-feedback">Campo obrigatório!</div>
                    <div class="valid-feedback">Campo válido</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-lg-2 offset-lg-1">Vagas <span class="text-danger">*</span></label>
                <div class="col-lg-2">
                    <input type="number" min=0 step=1 name="vagas" placeholder="0" class="form-control number" value="{{ (@$data->vagas) ? $data->vagas : '' }}" required>
                    <div class="invalid-feedback">Campo obrigatório!</div>
                    <div class="valid-feedback">Campo válido</div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('pc.index', $id_processo_seletivo) }}" class="btn btn-primary">Cancelar </a>
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