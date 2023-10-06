@extends('layouts.layout')
@section('content')

<div class="card">
    <div class="card-header d-lg-flex">
        <h5 class="mb-0">{{ $data->nome }} #{{ $data->id }} {!! (@$data_nota)? "<code>(Analisado por: ".$data_nota->analisado_por.")</code>" : '' !!}</h5>
    </div>

    <form action="{{ (@$data_nota) ? route('pn.update', [$id_processo_seletivo, $data_nota->id]) : route('pn.store', $id_processo_seletivo) }}" method="POST">
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
                        <p style="text-align: justify">Processo Seltivo: <span class="fw-semibold">{{ $data->curso->processo_seletivo->titulo }}</span></p>
                        <p style="text-align: justify">Vaga: <span class="fw-semibold">{{ $data->curso->titulo }}</span></p>
			            <p style="text-align: justify">Data de Nascimento: <span class="fw-semibold">{{ $data->data_nascimento }}</span></p>
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
                        <p style="text-align: justify">Mensagem: <span class="fw-semibold">{{ @$data_nota->mensagem }}</span></p> 
                    </div>
                    <?php
                        $anexo_curriculo = Storage::files("public/inscricao/$data->id/curriculos");
                        $anexo_documentos = Storage::files("public/inscricao/$data->id/documentos");
                        $anexo_titulacao = Storage::files("public/inscricao/$data->id/titulacao");
                        $anexo_qualificacao = Storage::files("public/inscricao/$data->id/qualificacao");
                        $anexo_experiencia_profissional = Storage::files("public/inscricao/$data->id/experiencia_profissional");
                    ?>
                                    
                    <div class="mt-1 mb-4">
                        <h6>Documentos</h6>
                        @if (@$anexo_documentos) 
                            @foreach ($anexo_documentos as $documento)
                            <a href="{{ Storage::url($documento) }}" target="_blank" class="btn btn-outline-danger flex-column">
                                <i class="ph-file-pdf ph-2x mb-1"></i>
                                Ver Arquivo
                            </a>
                            @endforeach
                        @else
                            Não Possui
                        @endif
                    </div>

                    <div class="mt-1 mb-4">
                        <h6>Currículo</h6>
                        @if (@$anexo_curriculo) 
                            @foreach ($anexo_curriculo as $documento)
                            <a href="{{ Storage::url($documento) }}" target="_blank" class="btn btn-outline-danger flex-column">
                                <i class="ph-file-pdf ph-2x mb-1"></i>
                                Ver Arquivo
                            </a>
                            @endforeach
                        @else
                            Não Possui
                        @endif
                    </div>
                                        
                    <div class="mt-1 mb-4">
                        <h6>Titulação</h6>
                        @if (@$anexo_titulacao)
                            @foreach ($anexo_titulacao as $documento)
                            <a href="{{ Storage::url($documento) }}" target="_blank" class="btn btn-outline-danger flex-column">
                                <i class="ph-file-pdf ph-2x mb-1"></i>
                                Ver Arquivo
                            </a>
                            @endforeach
                        @else
                            Não Possui
                        @endif
                        <div class="col-lg-1" style="padding-top: 10px">
                            <div class="mb-4">
                                <label class="form-label">Pontuação</label>
                                {{-- <input type="number" min=0 {{ ($anexo_titulacao)?'':'max=0' }} name="nota_titulacao" class="form-control" value="0"> --}}
                                <input type="number" min=0 name="nota_titulacao" class="form-control" value="{{ @$data_nota? $data_nota->nota_titulacao : 0 }}">
                                <span class="form-text"></span>
                            </div>
                        </div>
                    </div>
			
                    <div class="mt-1 mb-4">
                        <h6>Qualificação</h6>
                        @if (@$anexo_qualificacao)
                            @foreach ($anexo_qualificacao as $documento)
                            <a href="{{ Storage::url($documento) }}" target="_blank" class="btn btn-outline-danger flex-column">
                                <i class="ph-file-pdf ph-2x mb-1"></i>
                                Ver Documento
                            </a>
                            @endforeach
                        @else
                            Não Possui
                        @endif
                        <div class="col-lg-1" style="padding-top: 10px">
                            <div class="mb-4">
                                <label class="form-label">Pontuação</label>
                                {{-- <input type="number" min=0 {{ ($anexo_qualificacao)?'':'max=0' }} name="nota_qualificacao" class="form-control" value="0"> --}}
                                <input type="number" min=0 name="nota_qualificacao" class="form-control" value="{{ (@$data_nota)? $data_nota->nota_qualificacao : '0' }}">
                                <span class="form-text"></span>
                            </div>
                        </div>
                    </div>      
                    <div class="mt-1 mb-4">
                        <h6>Experiencia Profissional</h6>
                        @if (@$anexo_experiencia_profissional) 
                            @foreach ($anexo_experiencia_profissional as $documento)
                            <a href="{{ Storage::url($documento) }}" target="_blank" class="btn btn-outline-danger flex-column">
                                <i class="ph-file-pdf ph-2x mb-1"></i>
                                Ver Documento
                            </a>
                            @endforeach
                        @else
                            Não Possui
                        @endif
                        <div class="col-lg-1" style="padding-top: 10px">
                            <div class="mb-4">
                                <label class="form-label">Pontuação</label>
                                {{-- <input type="number" min=0 {{ ($anexo_experiencia_profissional)?'':'max=0' }} name="nota_exp_profissional" class="form-control" value="0"> --}}
                                <input type="number" min=0 name="nota_exp_profissional" class="form-control" value="{{ (@$data_nota)? $data_nota->nota_exp_profissional : '0' }}">
                                <span class="form-text"></span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-1 mb-4">
                        <h6>Mensagem (Caso tenha indeferimento)</h6>
                        <div class="col-lg-8" style="padding-top: 10px">
                            <div class="mb-4">
                                <input type="text" name="mensagem" class="form-control" value="{{ @$data_nota? $data_nota->nota_mensagem : '' }}" placeholder="">
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

@stop
