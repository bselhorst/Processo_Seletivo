@extends('layouts.layout-guest')

@section('header')
    {{-- Processo Seletivo - <span class="fw-normal"> {{ @$edital->titulo }} </span> --}}
@stop

@section('content')

<style>
	a {
		color: #4CAF50;
	}

	a:hover {
		color: #388E3C
	}
</style>

<!-- Course overview -->
<div class="card">
    <div class="card-header text-center" >
        {{-- <h5 class="mb-0">{{ $data->titulo }}</h5> --}}
        <h4 class="mb-0" style="color: #4CAF50; font-weight: 500">{{ $data->titulo }}</h4>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="course-overview">
            <div class="card-body" style="margin-top: 40px">
                <div class="row">
                    <div class="col-lg-4 offset-lg-2">
                        <div class="mb-3 text-center">
                            <i class="ph-users-four ph-2x mb-1"></i>
                            <h3 class="mb-0 fw-medium text-center pb-2">Vagas</h3>
                            <p style="font-size: 16px">{{ $data->cursos->sum('vagas') > 0 ? $data->cursos->sum('vagas') : 'Cadastro de Reserva' }}</p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3 text-center">
                            <i class="ph-calendar ph-2x mb-1"></i>
                            <h3 class="mb-0 fw-medium text-center pb-2">Período de Inscrições</h3>
                            <p style="font-size: 16px">De {{ date('d/m/Y', strtotime($data->data_abertura)) }} até {{ date('d/m/Y', strtotime($data->data_encerramento)) }} às {{ date('H:i:s', strtotime($data->encerramento)) }}, horário de Rio Branco/AC</p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    {{-- @if (Storage::get("public/editais/$data->id/resultado.pdf"))
        <div class="tab-content">
            <div class="tab-pane fade show active" id="course-overview">
                <div class="card-body">
                    <h3 class="mb-0 fw-medium text-center pb-4">RESULTADO</h3>
                    
                    @if (@$data)
                            <div class="card p-3">
                                <h4 class="mb-0 fw-medium"><a href="/storage/editais/{{$data->id}}/resultado.pdf" target="_blank"></a></h4>
                            </div>                        
                    @endif 
                </div>
            </div>
        </div>
    @endif --}}
    
    <div class="tab-content">
        <div class="tab-pane fade show active" id="course-overview">
            <div class="card-body">
                <h3 class="mb-0 fw-medium text-center pb-4">EDITAIS, COMUNICAÇÕES E INFORMAÇÕES</h3>
                
                @if(count(@$comunicados) > 0)
                    @foreach ($comunicados as $comunicado)
                        <div class="card p-3">        
                            <p class="fw-medium">{{ date('d/m/Y H:i:s', strtotime($comunicado->created_at)) }}</p>
                            <h4 class="mb-0 fw-medium"><a href="/storage/comunicados/{{$data->id}}/{{$comunicado->documento}}" target="_blank">{{ $comunicado->titulo }}</a></h4>           
                        </div>
                    @endforeach
                @endif                     
                <div class="card p-3">     
                    <p class="fw-medium">{{ date('d/m/Y H:i:s', strtotime($data->created_at)) }}</p>
                    <h4 class="mb-0 fw-medium"><a href="/storage/editais/{{$data->id}}/edital.pdf" target="_blank">Edital de Abertura</a></h4>           
                </div> 
            </div>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="course-overview">
            <div class="card-body">
                <h3 class="mb-0 fw-medium text-center pb-4">DOCUMENTOS ADICIONAIS</h3>
                @php
                    $documentos_adicionais = Storage::files("public/editais/$data->id/documentos_adicionais");
                @endphp
                @if (@$documentos_adicionais)
                    <div class="mt-1 mb-4">
                        @foreach ($documentos_adicionais as $documento)
                        {{-- <div class="card p-3">         --}}
                            {{-- <p class="fw-medium">11/06/2024 11:00</p> --}}
                            <h4 class="mb-0 fw-medium pb-2 text-center">
                                <a href="{{ Storage::url($documento) }}" target="_blank" class="btn {{ (explode(".", explode("/", $documento)[4])[1] == 'pdf')?'btn-outline-danger':'btn-outline-primary' }}" >
                                    <i class="{{ (explode(".", explode("/", $documento)[4])[1] == 'pdf')?'ph-file-pdf':'ph-file-doc' }} ph-2x mb-1"></i>
                                    {{ explode("/", $documento)[4] }}
                                </a>
                            </h4>           
                        {{-- </div> --}}
                        @endforeach
                    </div>
                @endif  
            </div>
        </div>
    </div>
    
    <div class="tab-content">
        <div class="tab-pane fade show active" id="course-overview">
            <div class="card-body">
                <h3 class="mb-0 fw-medium text-center pb-4">CARGOS</h3>
                @if (count(@$data->cursos) > 0)
                    <div class="card">
                        <div class="table-responsive border rounded">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Município / Regional</th>
                                        <th>Área de Atuação</th>
                                        <th>Perfil / Profissional</th>
                                        @if (count($salario) > 0)
                                            <th>Remuneração</th>
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
                                            <td>
                                                {{ $item->municipio->nome }} 
                                                @if (@$item->municipio->descricao)
                                                    <i class='ph-question ms-2' data-bs-popup='tooltip' data-bs-placement='top' data-bs-original-title='{{ @$item->municipio->descricao }}'></i>
                                                @endif
                                            </td>
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
                    </div>  
                @endif
            </div>
        </div>
    </div>
    
    {{-- <hr> --}}
    {{-- <div class="tab-content">
        <div class="tab-pane fade show active" id="course-overview">
            <div class="card-body">
                <h6 class="fw-semibold">Single or multiple icons</h6>
                <p class="mb-3">Content in block or inline elements can contain text, image, SVG, or icon. Here text link contains icon only</p>

                <a href="#collapse-icon" class="text-body collapsed" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="ph-arrow-circle-down"></i>
                </a>
                <a href="#collapse-icon2" class="text-body collapsed" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="ph-arrow-circle-down"></i>
                </a>

                <div class="collapse" id="collapse-icon" style="">
                    <div class="mt-3">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                    </div>
                </div>

                <div class="collapse" id="collapse-icon2" style="">
                    <div class="mt-3">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="tab-content">
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
                @php
                    $documentos_adicionais = Storage::files("public/editais/$data->id/documentos_adicionais");
                @endphp
                @if (@$documentos_adicionais)
                    <div class="mt-1 mb-4">
                        <h6>Documentos Adicionais</h6>
                        @foreach ($documentos_adicionais as $documento)
                        <a href="{{ Storage::url($documento) }}" target="_blank" class="btn {{ (explode(".", explode("/", $documento)[4])[1] == 'pdf')?'btn-outline-danger':'btn-outline-primary' }} flex-column">
                            <i class="{{ (explode(".", explode("/", $documento)[4])[1] == 'pdf')?'ph-file-pdf':'ph-file-doc' }} ph-2x mb-1"></i>
                            {{ explode("/", $documento)[4] }}
                        </a>
                        @endforeach
                    </div>
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
                                    <th>Área de Atuação</th>
                                    <th>Perfil / Profissional</th>
                                    @if (count($salario) > 0)
                                        <th>Remuneração</th>
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
    </div> --}}
</div>
<!-- /course overview -->
@stop