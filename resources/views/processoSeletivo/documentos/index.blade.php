@extends('layouts.layout')
@section('content')

<!-- Custom styles -->

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Processo Seletivo - Documentos do Processo Seletivo</h5>
    </div>
    
    <div class="card border-top border-top-width-1 border-bottom border-bottom-width-1 rounded-0" style="margin: 10px">
        <div class="card-header">
            <h6 class="mb-0">Cadastro</h6>
        </div>
        
        <form class="needs-validation" method='POST' action="{{ @$data_aux ? route('psdoc.update', $data_aux->id) : route('psdoc.store') }}" enctype='multipart/form-data' novalidate>
            @csrf
            @if (@$data_aux)
                @method('patch')
            @endif
            <div class="card" style="padding-top: 20px">            
                <div class="row mb-3">
                    <label class="col-form-label col-lg-2 offset-lg-1">Nome <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" name="nome" class="form-control" placeholder="Documento" value="{{ (@$data_aux->nome) ? $data_aux->nome : '' }}" required>
                        <div class="invalid-feedback">Campo obrigatório!</div>
                        <div class="valid-feedback">Campo válido</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-lg-2 offset-lg-1">Descrição</label>
                    <div class="col-lg-8">
                        <input type="text" name="descricao" class="form-control" placeholder="Descrição" value="{{ (@$data_aux->descricao) ? $data_aux->descricao : '' }}">
                        <div class="invalid-feedback">Campo obrigatório!</div>
                        <div class="valid-feedback">Campo válido</div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    @if (@$data_aux)
                        <a href="{{ route('psdoc.index') }}" class="btn btn-outline-primary">Cancelar </a>
                        <button type="submit" class="btn btn-outline-success">Editar </button>
                    @else
                        <button type="submit" class="btn btn-outline-success">Cadastrar </button>
                    @endif
                </div>
            </div>        
        </form>
        
    </div>

    <div class="card border-top border-top-width-1 border-bottom border-bottom-width-1 rounded-0" style="margin: 10px">
        <div class="card-header">
            <h6 class="mb-0">Filtro</h6>
        </div>
        
        <form method="POST" action="{{ route('psdoc.indexSearch') }}">
            @csrf
            <div class="d-flex justify-content-center border rounded p-2">
                <div class="col-lg-5 py-2 px-3 rounded">
                    <input type="text" name="pesquisa" class="form-control" placeholder="Pesquisa por nome">
                </div>
                <div class="col-lg-1 py-2 px-3 rounded">
                    <button type="submit" class="btn btn-outline-light">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>

    {{-- <a href="" class="btn btn-outline-success col-lg-1" style="margin-left: 10px">Cadastrar</a> --}}
    
    <div class="card" style="margin: 10px">        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->descricao }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('psdoc.edit', $item->id) }}" class="dropdown-item">
                                            <i class="ph-note-pencil me-2"></i>
                                            Editar Documento
                                        </a>
                                        <form id="delete_form_{{$item->id}}" method="POST" action="{{ route('psdoc.destroy', $item->id) }}">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="delete_data" />
                                            <button type="button" class="dropdown-item" onclick="deleteForm({{ $item->id }})">
                                                <i class="ph-trash text-danger"></i>
                                                <div style="padding-left: 10px" class="text-danger">Excluir Documento</div> 
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <div class="d-flex align-items-center" style="margin-left: 20px; margin-right: 20px; margin-bottom: 20px">
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
        </div>
    </div>
</div>

<script>
    function deleteForm(id){
        bootbox.confirm({
            title: 'Aviso!',
            message: 'Você tem certeza que deseja excluir esse registro? As alterações são irreversíveis.',
            buttons: {
                confirm: {
                    label: 'Confirmar',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-link'
                }
            },
            callback: function (result) {
                if(result == true){
                    document.getElementById("delete_form_"+id).submit();
                }
            }
        });
    }
</script>

@stop
