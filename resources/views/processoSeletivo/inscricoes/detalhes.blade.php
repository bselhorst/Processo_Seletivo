@extends('layouts.layout')
@section('content')

<div class="card">
    <div class="card-header d-lg-flex">
        <h5 class="mb-0">{{ $data->nome }} #{{ $data->id }}</h5>
    </div>
    <form action="#" method="POST">
        @csrf
        <div class="tab-content">
            <div class="tab-pane fade show active" id="course-overview">
                <div class="card-body">
                    <div class="mt-1 mb-4">
                        <h6>Dados do Inscrito</h6>
                        <p style="text-align: justify">Processo Seltivo: <span class="fw-semibold">{{ $data->curso->processo_seletivo->titulo }}</span></p>
                        <p style="text-align: justify">Vaga: <span class="fw-semibold">{{ $data->curso->vagas }}</span></p>
                        <p style="text-align: justify">Documento: <span class="fw-semibold">({{ $data->tipo_documento->nome }}) {{ $data->numero_documento }}</span></p>
                        <p style="text-align: justify">Endereço: <span class="fw-semibold">{{ $data->endereco }}</span></p>
                        @if ($data->bairro)
                            <p style="text-align: justify">Bairro: <span class="fw-semibold">{{ $data->bairro }}</span></p>
                        @endif                    
                        <p style="text-align: justify">Contato: <span class="fw-semibold">{{ $data->numero_contato }}</span></p>
                        @if ($data->email)
                            <p style="text-align: justify">Email: <span class="fw-semibold">{{ $data->email }}</span></p>
                        @endif 
                    </div>
                    <?php
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
                                @if (@$anexo_titulacao)
                                    <input type="text" class="form-control" placeholder="">
                                @else
                                    <input type="text" class="form-control" value=0 placeholder="" disabled>
                                @endif
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
                                @if (@$anexo_qualificacao)
                                    <input type="text" class="form-control" placeholder="">
                                @else
                                    <input type="text" class="form-control" value=0 placeholder="" disabled>
                                @endif
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
                                @if (@$anexo_experiencia_profissional)
                                    <input type="text" class="form-control" placeholder="">
                                @else
                                    <input type="text" class="form-control" value=0 placeholder="" disabled>
                                @endif
                                <span class="form-text"></span>
                            </div>
                        </div>
                    </div>       
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-outline-danger">Indeferir Inscrição</button>
            <button class="btn btn-outline-success">Deferir Inscrição</button>
        </div>
    </form>
</div>

@stop
