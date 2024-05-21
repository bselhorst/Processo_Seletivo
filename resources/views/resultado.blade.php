@extends('layouts.layout-guest')

@section('header')
    {{-- Processo Seletivo - <span class="fw-normal"> {{ @$edital->titulo }} </span> --}}
@stop

@section('content')

<!-- Course overview -->
<div class="card">
    <div class="card-header d-lg-flex bg-success bg-opacity-10" style="justify-content: center">
        <h5 class="mb-0">RESULTADO DA ANÁLISE CURRICULAR</h5>
    </div>
    <div class="card-header d-lg-flex">
        <h5 class="mb-0">{{ $data->titulo }}</h5>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="course-overview">
            <div class="card-body">
                {{-- <h6>Resultado da Análise Curricular</h6> --}}
                @if ($data->resultado)
                <div class="col-lg-12">
                    {{-- <table class="table"> --}}                        
                    @php($old_titulo = null)
                    
                    @foreach ($inscritos as $item) 
                        
                        @if (($item->inscricao->curso->titulo != @$old_titulo && @$old_titulo != null))
                            </table>
                        @endif
                        @if (($item->inscricao->curso->titulo != @$old_titulo OR @$old_titulo == null))
                            <table class="table">
                            @php($classificacao = 1)
                            <tr>
                                <td colspan="5" style="font-size: 16px"><b>{{ $item->inscricao->curso->municipio->nome." / ".$item->inscricao->curso->titulo }}</td>
                            </tr>                                        

                            <tr>
                                <th style="width: 10%">Classificação</th>
                                <th>Documento</th>
                                <th>Nome</th>
                                <th>PCD</th>
                                <th>Pontuação</th>
                            </tr>
                        @endif
                        <tbody>
                            <tr>
                                <td>{{ $classificacao }}</td>
                                <td>{{ $item->inscricao->tipo_documento->nome.": ".$item->inscricao->numero_documento }}</td>
                                <td>{{ $item->inscricao->nome }}</td>
                                <td>{{ $item->inscricao->deficiencia == 1 ? 'SIM' : 'NÃO' }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                        </tbody>
                        @php($old_titulo = $item->inscricao->curso->titulo)
                        @php($classificacao++)
                    @endforeach                         
                    </table>
                </div> 
                @else
                    Resultado não publicado
                @endif                 
            </div>
        </div>
    </div>
</div>
<!-- /course overview -->
@stop