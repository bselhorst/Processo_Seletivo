@extends('layouts.layout')
@section('content')

<div class="card">
    <div class="card-header d-lg-flex">
        <h5 class="mb-0">{{ $data->nome }} #{{ $data->id }} {!! (@$data_analise) ? "<code>(Analisado por: ".@$data_analise->analisado_por.")</code>" : '' !!}</h5>
    </div>

    <form action="{{ (@$data_nota) ? route('pn.update', [$id_processo_seletivo, $data->id]) : route('pn.store', $id_processo_seletivo) }}" method="POST">
        @csrf
        @if (@$data_nota)
            @method('patch')
        @endif
        <input type="hidden" name="id_processo_seletivo" value="{{ $id_processo_seletivo }}" />
        <input type="hidden" name="id_inscricao" value="{{ $data->id }}" />
        <div class="tab-content">
            <div class="tab-pane fade show active" id="course-overview">
                <div class="card-body">
                    <div class="mt-1 mb-4">
                        <h6>Dados do Inscrito</h6>
                        <p style="text-align: justify">Processo Seletivo: <span class="fw-semibold">{{ $data->curso->processo_seletivo->titulo }}</span></p>
                        <p style="text-align: justify">Vaga: <span class="fw-semibold">{{ $data->curso->titulo }}</span></p>
			            <p style="text-align: justify">Data de Nascimento: <span class="fw-semibold">{{ date('d/m/Y', strtotime($data->data_nascimento)) }}</span></p>
                        <p style="text-align: justify">Documento: <span class="fw-semibold">({{ $data->tipo_documento->nome }}) {{ $data->numero_documento }}</span></p>
                        <p style="text-align: justify">Endereço: <span class="fw-semibold">{{ $data->endereco }}</span></p>
                        @if ($data->bairro)
                            <p style="text-align: justify">Bairro: <span class="fw-semibold">{{ $data->bairro }}</span></p>
                        @endif                    
                        <p style="text-align: justify">Contato: <span class="fw-semibold">{{ $data->numero_contato }}</span></p>
                        @if ($data->email)
                            <p style="text-align: justify">Email: <span class="fw-semibold">{{ $data->email }}</span></p>
                        @endif
                        <p style="text-align:justify">PCD: <span class="fw-semibold">{{ ($data->deficiencia == 1)?'SIM':'NÃO' }}</span></p>
                        <p style="text-align: justify">Mensagem: <span class="fw-semibold">{{ @$data_analise->mensagem }}</span></p> 
                    </div>
                    @if (@$configuracoes)
                        @foreach ($configuracoes as $conf)
                            @php
                                // Transforma o nome em path                        
                                $path_name = \App\Helpers\StringHelper::removerAcentos(preg_replace("/\s+/", "_",strtolower($conf->documento->nome)));
                                // Verifica se tem arquivos dentro da pasta
                                $documentos = Storage::files("public/inscricao/$data->id/$path_name");
                            @endphp
                            <div class="mt-1 mb-4">
                                <h6>{{$conf->documento->nome}}</h6>
                                
                                @if (@$documentos) 
                                    @php
                                        $contador = 1;
                                    @endphp
                                    @foreach ($documentos as $documento)
                                    <a href="{{ Storage::url($documento) }}" target="_blank" class="btn btn-outline-danger flex-column" onclick="alterarCorLink(this, event)">
                                        <i class="ph-file-pdf ph-2x mb-1"></i>
                                        Ver Arquivo
                                        {{$contador}}
                                    </a>
                                    @php
                                        $contador++;
                                    @endphp
                                    @endforeach
                                @else
                                    Não Possui
                                @endif

                                @if ($conf->pontuacao)
                                    <div class="col-lg-1" style="padding-top: 10px">
                                        <div class="mb-4">
                                            <label class="form-label">Pontuação</label>
                                            <input type="number" min=0 name="nota_{{$path_name}}" value="{{ @$data_nota[$conf->documento->id] ? $data_nota[$conf->documento->id]->nota : 0 }}" class="form-control" >
                                            {{-- <input type="number" min=0 name="nota_{{$path_name}}" class="form-control" value="{{ @$data_nota? $data_nota->nota_.$path_name : 0 }}"> --}}
                                            <span class="form-text"></span>
                                        </div>
                                    </div>
                                @endif                            
                            </div>
                        @endforeach
                    @endif                   

                    <div class="mt-1 mb-4">
                        <h6>Mensagem (Caso tenha indeferimento)</h6>
                        <div class="col-lg-8" style="padding-top: 10px">
                            <div class="mb-4">
                                <input type="text" name="mensagem" class="form-control" value="{{ @$data_analise->mensagem }}" placeholder="">
                                <span class="form-text"></span>
                            </div>
                        </div>
                    </div>       
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input class="btn btn-outline-danger" type="submit" name="status" value="Indeferido" />
            <input class="btn btn-outline-success" type="submit" name="status" value="Deferido" />
        </div>
    </form>
</div>
<script>
    function alterarCorLink(elemento, evento) {
        // Altera a cor do link para verde (ou qualquer outra cor)
        elemento.classList.remove('btn-outline-danger');
        elemento.classList.add('btn-outline-success');
        
        // Adiciona a classe 'clicado' para manter o estilo
        elemento.classList.add('clicado');
        
        // Previne a navegação normal do link (abrir o arquivo)
        evento.preventDefault();
        
        // Agora abre o arquivo depois de um pequeno delay (para garantir que a cor tenha mudado)
        setTimeout(function() {
            window.open(elemento.href, '_blank');  // Isso simula o comportamento do link (abre o arquivo)
        }, 100);
    }
</script>

<style>
    /* Estilos para links clicados */
    .documento-btn.clicado {
        background-color: #28a745 !important; /* Cor de fundo verde */
        color: white; /* Cor do texto */
    }
</style>
@stop

@push('scripts')
    
@endpush