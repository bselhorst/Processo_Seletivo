@extends('layouts.layout')
@section('content')

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Processo Seletivo - {{ $processo_seletivo->titulo }}</h5>
    </div>
    
    <div class="card border-top border-top-width-1 border-bottom border-bottom-width-1 rounded-0" style="margin: 10px">
        <div class="card-header">
            <h6 class="mb-0">Filtro</h6>
        </div>
        
        <form method="GET" action="{{ route('pi.indexSearch', $id_processo_seletivo) }}">
            @csrf
            <div class="d-flex justify-content-center border rounded p-2">
                <div class="col-lg-5 py-2 px-3 rounded">
                    <input type="text" name="pesquisa" class="form-control" placeholder="Pesquisa por nome ou município">
                </div>
                <div class="col-lg-1 py-2 px-3 rounded">
                    <button type="submit" class="btn btn-outline-light">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card" style="margin: 10px">        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    {{-- <th>Número</th> --}}
                    <th>Curso</th>
                    <th>Município</th>
                    <th>Nome</th>
                    <th>Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->tipo_documento.": ".$item->numero_documento }}</td>
                        <td>{{ $item->curso }}</td>
                        <td>{{ $item->cidade }}</td>
                        <td>{{ $item->nome }}</td>
                        <td>
                            @if (@$item->status)
                                @if ($item->status == 'Deferido')
                                    <span class="badge bg-success bg-opacity-10 text-success">Deferido</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-danger">Indeferido</span>
                                @endif
                            @else
                                <span class="badge bg-success bg-opacity-10 text-warning">A ser analisado</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('pi.detalhes', [$id_processo_seletivo, $item->id]) }}" class="dropdown-item">
                                            <i class="ph-check-square-offset me-2"></i>
                                            Ver Inscrição
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        {{ Request()->pesquisa }}
        @include('components.pagination', ['data' => $data, 'search' => Request()->pesquisa])
        {{-- <div class="d-flex align-items-center" style="margin-left: 20px; margin-right: 20px; margin-bottom: 20px">
            <span class="text-muted me-auto">Mostrando {{ $data->firstItem() }} até {{ $data->lastItem() }} de {{ $data->total() }} registros</span>
            <span class="text-muted me-3">{{ $data->currentPage() }} de {{ $data->lastPage() }}</span>
            <ul class="pagination pagination-flat">
                <li class="page-item {{ ($data->currentPage() > 1) ? '' : 'disabled' }}">
                    <a href="{{ $data->previousPageUrl() }}" class="page-link rounded">←</a>
                </li>
                @if ($data->currentPage() > 4)
                    <li class="page-item">
                        <a href="{{ $data->url(1) }}" class="page-link rounded">1</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link rounded">...</a>
                    </li>                   
                @endif
                @if ($data->currentPage() >= 3)
                    @for ($i = $data->currentPage()-2; $i <= $data->currentPage(); $i++)
                        @if ($i == $data->currentPage())
                            <li class="page-item active">
                                <a href="{{ $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                            </li>
                        @endif                    
                    @endfor
                @else
                    @for ($i = 1; $i <= $data->currentPage(); $i++)
                        @if ($i == $data->currentPage())
                            <li class="page-item active">
                                <a href="{{ $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                            </li>
                        @endif                    
                    @endfor
                @endif
                @if ($data->lastPage()-$data->currentPage() < 3)
                    @for ($i = $data->currentPage()+1; $i <= $data->lastPage(); $i++)
                        <li class="page-item">
                            <a href="{{ $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                        </li>                   
                    @endfor
                @else
                    @for ($i = $data->currentPage()+1; $i <= $data->currentPage()+2; $i++)
                        <li class="page-item">
                            <a href="{{ $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                        </li>              
                    @endfor
                @endif
                @if ($data->lastPage()-$data->currentPage() >= 4)
                    <li class="page-item">
                        <a href="#" class="page-link rounded">...</a>
                    </li>
                    <li class="page-item">
                        <a href="{{ $data->url($data->lastPage()) }}" class="page-link rounded">{{ $data->lastPage() }}</a>
                    </li>                   
                @endif
                <li class="page-item {{ ($data->hasMorePages()) ? '' : 'disabled' }}">
                    <a href="{{ $data->nextPageUrl() }}" class="page-link rounded">→</a>
                </li>
            </ul>
        </div> --}}
        {{-- {{$data}} --}}
        {{-- <x-pagination data="{{ $data }}" /> --}}
    </div>
    
</div>
<!-- /basic datatable -->

@stop
