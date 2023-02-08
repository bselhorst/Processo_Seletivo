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
                @if (count(@$data->cursos) > 0)
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
                                    @if (date(strtotime($data->data_encerramento)) >= time())
                                        @if (date(strtotime($data->data_abertura)) <= time())
                                            <th class="text-center">Ações</th>
                                        @endif
                                    @endif 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->cursos as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->municipio->nome }}</td>
                                        <td>{{ $item->titulo }}</td>
                                        <td>{{ $item->descricao }}</td>
                                        @if (count($salario) > 0)
                                            <td>{{ $item->salario }}</td>
                                        @endif                                        
                                        <td>{{ ($item->vagas > 0)? $item->vagas : 'Cadastro de Reserva' }}</td>
                                        @if (date(strtotime($data->data_encerramento)) >= time())
                                            @if (date(strtotime($data->data_abertura)) <= time())
                                                <td class="text-center">                                          
                                                    <a href="{{ route('inscricao', ['id' => $data->id,'id_curso' => $item->id]) }}">Inscrição</a>                                                                                                                                 
                                                </td>
                                            @endif
                                        @endif 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>               
                    </div>  
                @endif
                @if (@$data)
                    @if (Storage::get("public/editais/$data->id/resultado.pdf"))
                        <div class="mt-1 mb-4">
                            <h6>Resultado</h6>
                            <a href="/storage/editais/{{$data->id}}/resultado.pdf" target="_blank" class="btn btn-outline-danger flex-column">
                                <i class="ph-file-pdf ph-2x mb-1"></i>
                                Ver Resultado
                            </a>
                        </div>                        
                    @endif
                @endif 
            </div>
        </div>
    </div>
</div>
<!-- /course overview -->
@stop