@extends('layouts.layout-guest')

@section('header')
    {{-- Processo Seletivo - <span class="fw-normal"> {{ @$edital->titulo }} </span> --}}
@stop

@section('content')

<!-- Course overview -->
<div class="card">
    <div class="card-header d-lg-flex">
        <h5 class="mb-0">{{ $data->titulo }}</h5>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="course-overview">
            <div class="card-body">
                @if (@$data)
                    @if (Storage::get("public/editais/$data->id/edital.pdf"))
                        <div class="mt-1 mb-4">
                            <h6>Edital</h6>
                            <a href="/storage/editais/{{$data->id}}/edital.pdf" target="_blank" class="btn btn-outline-danger flex-column">
                                <i class="ph-file-pdf ph-2x mb-1"></i>
                                Ver Edital
                            </a>
                        </div>                        
                    @endif
                @endif                
                <div class="mt-1 mb-4">
                    <h6>Descrição</h6>
                    <p style="text-align: justify">{{ $data->descricao }}</p>
                </div>
                @if (count(@$data_curso) > 0)
                    <h6>Vagas</h6>
                    <div class="card">        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Município</th>
                                    <th>Titulo</th>
                                    <th>Descrição</th>
                                    @if (count($salario) > 0)
                                        <th>Salário</th>
                                    @endif
                                    <th>Vagas</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_curso as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ App\Models\AuxiliarMunicipio::with('municipio')->findOrFail($item->id)->nome }}</td>
                                        <td>{{ $item->titulo }}</td>
                                        <td>{{ $item->descricao }}</td>
                                        @if (count($salario) > 0)
                                            <td>{{ $item->salario }}</td>
                                        @endif                                        
                                        <td>{{ $item->vagas }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('inscricao', ['id' => $data->id,'id_curso' => $item->id]) }}">Inscrição</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>               
                    </div>  
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /course overview -->
@stop