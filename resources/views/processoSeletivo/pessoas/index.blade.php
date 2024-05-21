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
        <h5 class="mb-0">Pesquisa de Pessoas Inscritas</h5>
    </div>

    <div class="card border-top border-top-width-1 border-bottom border-bottom-width-1 rounded-0" style="margin: 10px">
        <div class="card-header">
            <h6 class="mb-0">Filtro</h6>
        </div>

        <form method=GET" action="{{ route('ps.pessoaIndexSearch') }}">
            @csrf
            <div class="d-flex justify-content-center border rounded p-2">
                <div class="col-lg-5 py-2 px-3 rounded">
                    <input type="text" name="pesquisa" class="form-control" placeholder="Pesquisa por nome ou documento">
                </div>
                <div class="col-lg-1 py-2 px-3 rounded">
                    <button type="submit" class="btn btn-outline-light">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>

    {{-- <a href="{{ route('ps.create') }}" class="btn btn-outline-success col-lg-1" style="margin-left: 10px">Cadastrar</a> --}}
    
    <div class="card" style="margin: 10px">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    <th>Nome</th>
                    <th style="width: 50%">Processo Seletivo</th>
                    <th>Curso</th>
                    <th>Município</th>
                    
                    {{-- <th class="text-center">Ações</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->tipo_documento->nome." : ".$item->numero_documento }}</td>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->curso->processo_seletivo->titulo }}</td>
                        <td>{{ $item->curso->titulo }}</td>
                        <td>{{ $item->curso->municipio->nome }}</td>
                        {{-- <td>
                            @if (strtotime($item->data_encerramento) >= strtotime('now'))
                                <span class="badge bg-success bg-opacity-10 text-success">Ativo</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-danger">Encerrado</span>
                            @endif
                        </td> --}}
                        {{-- <td class="text-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('ps.resultado', $item->id) }}" class="dropdown-item">
                                            <i class="ph-users-four me-2"></i>
                                            Download do Resultado
                                        </a>
                                        <a href="{{ route('ps.indeferidos', $item->id) }}" class="dropdown-item">
                                            <i class="ph-user-minus me-2"></i>
                                            Download dos Indeferidos
                                        </a>
                                        @if (strtotime($item->data_encerramento) < strtotime('now'))
                                            <a href="{{ route('ps.resultadoForm', $item->id) }}" class="dropdown-item">
                                                <i class="ph-file-plus me-2"></i>
                                                Publicar Resultado
                                            </a>
                                        @endif
                                        <a href="{{ route('pi.index', $item->id) }}" class="dropdown-item">
                                            <i class="ph-identification-badge me-2"></i>
                                            Inscrições
                                        </a>
                                        <a href="{{ route('pc.index', $item->id) }}" class="dropdown-item">
                                            <i class="ph-graduation-cap me-2"></i>
                                            Perfis Profissionais
                                        </a>
                                        <a href="{{ route('ps.edit', $item->id) }}" class="dropdown-item">
                                            <i class="ph-note-pencil me-2"></i>
                                            Editar Processo Seletivo
                                        </a>
                                        <form id="delete_form_{{$item->id}}" method="POST" action="{{ route('ps.destroy', $item->id) }}">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="delete_data" />
                                            <button type="button" class="dropdown-item" onclick="deleteForm({{ $item->id }})">
                                                <i class="ph-trash text-danger"></i>
                                                <div style="padding-left: 10px" class="text-danger">Excluir Processo Seletivo</div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <div class="d-flex align-items-center" style="margin-left: 20px; margin-right: 20px; margin-bottom: 20px">
            {{--
            * Aqui temos o $data->firstItem() que pega o primeiro item da página enquanto o $data->lastItem() pega o último item da página, ou seja, se a paginação
            está na primeira página, e temos 10 itens por página, o firstItem será 1 e o lastItem será o 10, se for na segunda página, o firstItem será o 11 e o last será
            o 20.
            * $data->total() mostra a quantidade total de registros
            --}}
            <span class="text-muted me-auto">Mostrando {{ $data->firstItem() }} até {{ $data->lastItem() }} de {{ $data->total() }} registros</span>
            {{--
            * currentPage() mostra a página atual que está selecionado e o lastPage() mostra a última página ou o total de páginas, isso é automático ao utilizar o paginate()
            --}}
            <span class="text-muted me-3">{{ $data->currentPage() }} de {{ $data->lastPage() }}</span>
            <ul class="pagination pagination-flat">
                {{--
                * Aqui eu verifico se o currentPage é maior que 1 ou seja, se a pagina não está na primeira página daí ele aparece como desabilitado o símbolo de voltar uma
                página, porque quando se está na primeira página, você não pode voltar uma página pois não existem páginas para trás
                --}}
                <li class="page-item {{ ($data->currentPage() > 1) ? '' : 'disabled' }}">
                    <a href="{{ $data->previousPageUrl() }}" class="page-link rounded">←</a>
                </li>
                {{--
                * É verificado se a pagina atual é maior que 4, caso seja, eu mostro o número 1 para ele voltar para a primeira página a qualquer momento
                --}}
                @if ($data->currentPage() > 4)
                    <li class="page-item">
                        {{--
                        * $data->url(1) vai gerar o url da pagina inicial
                        --}}
                        <a href="{{ $data->url(1) }}" class="page-link rounded">1</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link rounded">...</a>
                    </li>
                @endif
                {{--
                * Se a paginação for maior ou igual a 3, ele vai mostrar dois números abaixo na paginação, ou seja, se estiver na página 3, ele vai mostrar o 2 e o 1
                --}}
                @if ($data->currentPage() >= 3)
                    @for ($i = $data->currentPage()-2; $i <= $data->currentPage(); $i++)
                        @if ($i == $data->currentPage())
                            <li class="page-item active">
                                <a href="{{ (@$_GET['pesquisa']) ? $data->url($i).'&pesquisa='.@$_GET['pesquisa'] : $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ (@$_GET['pesquisa']) ? $data->url($i).'&pesquisa='.@$_GET['pesquisa'] : $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                @else
                    @for ($i = 1; $i <= $data->currentPage(); $i++)
                        @if ($i == $data->currentPage())
                            <li class="page-item active">
                                <a href="{{ (@$_GET['pesquisa']) ? $data->url($i).'&pesquisa='.@$_GET['pesquisa'] : $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ (@$_GET['pesquisa']) ? $data->url($i).'&pesquisa='.@$_GET['pesquisa'] : $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                @endif
                @if ($data->lastPage()-$data->currentPage() < 3)
                    @for ($i = $data->currentPage()+1; $i <= $data->lastPage(); $i++)
                        <li class="page-item">
                            <a href="{{ (@$_GET['pesquisa']) ? $data->url($i).'&pesquisa='.@$_GET['pesquisa'] : $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                        </li>
                    @endfor
                @else
                    @for ($i = $data->currentPage()+1; $i <= $data->currentPage()+2; $i++)
                        <li class="page-item">
                            <a href="{{ (@$_GET['pesquisa']) ? $data->url($i).'&pesquisa='.@$_GET['pesquisa'] : $data->url($i) }}" class="page-link rounded">{{ $i }}</a>
                        </li>
                    @endfor
                @endif
                @if ($data->lastPage()-$data->currentPage() >= 4)
                    <li class="page-item">
                        <a href="#" class="page-link rounded">...</a>
                    </li>
                    <li class="page-item">
                        <a href="{{ (@$_GET['pesquisa']) ? $data->url($data->lastPage()).'&pesquisa='.@$_GET['pesquisa'] : $data->url($data->lastPage()) }}" class="page-link rounded">{{ $data->lastPage() }}</a>
                    </li>
                @endif
                <li class="page-item {{ ($data->hasMorePages()) ? '' : 'disabled' }}">
                    <a href="{{ (@$_GET['pesquisa']) ? $data->nextPageUrl().'&pesquisa='.@$_GET['pesquisa'] : $data->nextPageUrl() }}" class="page-link rounded">→</a>
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
