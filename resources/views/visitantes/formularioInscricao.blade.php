@extends('layouts.layout-guest')
{{-- @section('header')
    Formulário - <span class="fw-normal">Inscrição</span>
@stop --}}

@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-header text-center" style="background-color: #4CAF50; color: white; font-size: 28px; font-weight: 500">
            Formulário de Inscrição
        </div>
        <form class="form-validate-jquery" method='POST' id="formulario-inscricao" action="{{ route('inscricao.store') }}" enctype='multipart/form-data'
            novalidate>
            @csrf

            <style>
                .titulo {
                    color: #4CAF50;
                    font-size: 20px;
                }
            </style>

            <div class="card-body">
                <div class="fw-bold border-bottom pb-2 mb-3 titulo">Dados do Processo Seletivo</div>
                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">Vaga<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        {{-- <select name="id_processo_seletivo_curso" onchange="esconderCampos(this.value)" class="form-select" required=""> --}}
                        <select name="id_processo_seletivo_curso" onchange="mudarVaga(this.value)" class="form-select" required="">
                            <option value="">Escolha uma vaga abaixo</option>
                            {{ $old = '' }}
                            @foreach ($vagas as $vaga)
                                @if ($vaga->processo_seletivo != $old)
                                    @if ($old != '')
                                        </optgroup>
                                    @endif
                                    {{ $old = $vaga->processo_seletivo }}
                                    <optgroup label="{{ \Illuminate\Support\Str::limit($vaga->processo_seletivo,100, $end='...') }}">
                                @endif
                                <option value="{{ $vaga->id }}" {{ @$id_vaga == $vaga->id ? 'selected' : '' }} label="{{ \Illuminate\Support\Str::limit($vaga->municipio." / ".$vaga->titulo,150, $end='...') }}">
                                    {{ $vaga->municipio }} / {{ $vaga->titulo }}</option>
                            @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="fw-bold border-bottom pb-2 mb-3 titulo">Dados de Inscrição</div>
                <p class="mb-4">NOTA: Por favor, leia com atenção os campos e preencha corretamente as informações abaixo.
                </p>
                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">Pessoa com deficiência <span
                            class="text-danger">*</span></label>
                    <div class="col-lg-9 mt-1">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="deficiencia" id="inlineRadio1"
                                value="1" required>
                            <label class="form-check-label" for="inlineRadio1">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="deficiencia" id="inlineRadio2"
                                value="2" required>
                            <label class="form-check-label" for="inlineRadio2">Não</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">Nome Completo <span class="text-danger">*</span></label>
                    <div class="col-lg-5">
                        <input type="text" name="nome" id="nome" class="form-control" required=""
                            placeholder="Nome completo sem abreviações" aria-invalid="false">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">Data de Nascimento <span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" required=""
                            aria-invalid="false">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">Tipo de Documento <span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <select name="id_tipo_documento" id="id_tipo_documento" class="form-select" required="">
                            <option value="">Escolha um tipo de documento abaixo</option>
                            @foreach (@$tipo_documentos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">Número do documento <span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <input type="text" name="numero_documento" id="numero_documento" class="form-control" required=""
                            placeholder="Ex: 12345678901" aria-invalid="false">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">Endereço<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="endereco" id="endereco" class="form-control" required=""
                            placeholder="Ex: Rua 7 de Setembro, 000" aria-invalid="false">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">Bairro</label>
                    <div class="col-lg-4">
                        <input type="text" name="bairro" id="bairro" class="form-control" placeholder="Ex: Centro"
                            aria-invalid="false">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">Número para contato (DDD + número (somente número)) <span
                            class="text-danger">*</span></label>
                    <div class="col-lg-3">
                        <input type="text" name="numero_contato" id="numero_contato" class="form-control" required=""
                            placeholder="68999999999">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-lg-3">Email <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="email" name="email" class="form-control" required id="email"
                            placeholder="Adicione um email válido" aria-invalid="true">
                    </div>
                </div>

                {{-- A PARTIR DAQUI COMEÇAM OS DOCUMENTOS --}}

                <div class="card area_deficiencia d-none">
                    <div class="card-header">
                        <h5 class="mb-0">Documento comprobatório da deficiência <code>(PDF)</code>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="fw-semibold">Pré visualização</p>
                        <input type="file" name="anexo_deficiencia[]" class="file-input" multiple="multiple"
                            accept=".pdf" id="anexo_deficiencia" >
                    </div>
                </div>

                <div class="fw-bold border-bottom pb-2 mb-3 titulo">Documentos Comprobatórios</div>
                {{-- {{ $configuracao }} --}}
                {{-- {{$configuracao}} --}}
                @foreach ($configuracao as $conf)
                    @php
                        $name = \App\Helpers\StringHelper::removerAcentos(preg_replace("/\s+/", "_",strtolower($conf->nome)))
                    @endphp
                    {{-- {{$conf->obrigatorio}} --}}
                    <x-upload-file 
                        header_description="{{$conf->descricao}}"
                        name="{{$name}}" 
                        multiple="{{$conf->multiplos_arquivos}}"
                        required="{{$conf->obrigatorio}}"
                    />
                @endforeach
                {{-- <x-upload-file 
                    header_description="Descrição do documento a ser adicionado" 
                    name="Nome" 
                    multiple=true
                    required=true
                /> --}}

                {{-- <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Documento com foto (RG, CNH, Carteira de Identidade Profissional) <code>(PDF)</code></h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Exemplo de documentos (com foto): RG, Passaporte, Carteira de Trabalho.</p>
                        <p class="fw-semibold">Pré visualização</p>
                        <input type="file" name="anexo_documento[]" class="file-input-required"
                            accept=".pdf" multiple>
                    </div>
                </div> --}}

                {{-- @if (@$id_processo == 15)

                    <div class="card div-comprovante">
                        <div class="card-header">
                            <h5 class="mb-0">Comprovante de endereço <code>(PDF)</code></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Exemplo de documentos: Conta de água, luz, telefone ou qualquer outro que comprove residência.</p>
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" id="anexo_comprovante_endereco" name="anexo_comprovante_endereco[]" class="file-input-required"
                            accept=".pdf">
                        </div>
                    </div>
                    
                    <div class="card div-declaracao">
                        <div class="card-header">
                            <h5 class="mb-0">Declaração de disponibilidade <code>(PDF)</code></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Declaração de disponibilidade preenchida e assinada.</p>
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" id="anexo_declaracao_disponibilidade" name="anexo_declaracao_disponibilidade[]" class="file-input-required"
                            accept=".pdf">
                        </div>
                    </div>
                    
                    <div class="card div-carta">
                        <div class="card-header">
                            <h5 class="mb-0">Carta de intenção <code>(PDF)</code></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Especifica as razões pelas quais deseja ser tutor do cursp: organização das ideias/concepções (coerência e coesão); correção e propriedade da redação; capacidade de síntese. Que consta no anexo VI.</p>
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" id="anexo_carta_intencao" name="anexo_carta_intencao[]" class="file-input-required"
                            accept=".pdf">
                        </div>
                    </div>  

                @else

                    <div class="card div-comprovante d-none">
                        <div class="card-header">
                            <h5 class="mb-0">Comprovante de endereço <code>(PDF)</code></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Exemplo de documentos: Conta de água, luz, telefone ou qualquer outro que comprove residência.</p>
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" id="anexo_comprovante_endereco" name="anexo_comprovante_endereco[]" class="file-input"
                            accept=".pdf">
                        </div>
                    </div>
                    
                    <div class="card div-declaracao d-none">
                        <div class="card-header">
                            <h5 class="mb-0">Declaração de disponibilidade <code>(PDF)</code></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Declaração de disponibilidade preenchida e assinada.</p>
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" id="anexo_declaracao_disponibilidade" name="anexo_declaracao_disponibilidade[]" class="file-input"
                            accept=".pdf">
                        </div>
                    </div>
                    
                    <div class="card div-carta d-none">
                        <div class="card-header">
                            <h5 class="mb-0">Carta de intenção <code>(PDF)</code></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Especifica as razões pelas quais deseja ser tutor do cursp: organização das ideias/concepções (coerência e coesão); correção e propriedade da redação; capacidade de síntese. Que consta no anexo VI.</p>
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" id="anexo_carta_intencao" name="anexo_carta_intencao[]" class="file-input"
                            accept=".pdf">
                        </div>
                    </div>  

                @endif --}}
                
                {{-- @if (@$id_processo == 17)
                    <div class="card div-declaracao">
                        <div class="card-header">
                            <h5 class="mb-0">Declaração de disponibilidade <code>(PDF)</code></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Declaração de disponibilidade preenchida e assinada.</p>
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" id="anexo_declaracao_disponibilidade" name="anexo_declaracao_disponibilidade[]" class="file-input-required"
                            accept=".pdf">
                        </div>
                    </div>
                @else
                    <div class="card div-declaracao d-none">
                        <div class="card-header">
                            <h5 class="mb-0">Declaração de disponibilidade <code>(PDF)</code></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Declaração de disponibilidade preenchida e assinada.</p>
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" id="anexo_declaracao_disponibilidade" name="anexo_declaracao_disponibilidade[]" class="file-input"
                            accept=".pdf">
                        </div>
                    </div>
                @endif
                
                @if (@$id_processo == 17)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Certificado de Ensino Médio <code>(PDF)</code>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" name="anexo_titulacao[]" class="file-input-required" multiple="multiple"
                                accept=".pdf">
                        </div>
                    </div>
                @endif

                @if (@$id_processo != 17)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Escolaridade (Graduação, Especialização, Mestrado, Doutorado) <code>(PDF)</code>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" name="anexo_titulacao[]" class="file-input-required" multiple="multiple"
                                accept=".pdf">
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Qualificação e aperfeiçoamento profissional <code>(PDF)</code></h5>
                        </div>
                        <div class="card-body">
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" name="anexo_qualificacao[]" class="file-input-required" multiple="multiple"
                                accept=".pdf">
                        </div>
                    </div>
                @endif                

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Experiência Profissional <code>(PDF)</code></h5>
                    </div>
                    <div class="card-body">
                        <p class="fw-semibold">Pré visualização</p>
                        <input type="file" name="anexo_experiencia_profissional[]" class="file-input"
                            multiple="multiple" accept=".pdf">
                    </div>
                </div>

                @if (@$id_processo != 17)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Currículo <code>(PDF)</code></h5>
                        </div>
                        <div class="card-body">
                            <p class="fw-semibold">Pré visualização</p>
                            <input type="file" name="anexo_curriculo[]" class="file-input-required"
                                multiple="multiple" accept=".pdf">
                        </div>
                    </div>
                @endif --}}

                {{-- <x-upload-file 
                    header_description="Descrição do documento a ser adicionado" 
                    name="Nome" 
                    multiple=true
                    required=true
                /> --}}

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" id="submit-button" style="background-color: #4CAF50; border-color: #4CAF50">Fazer Inscrição </button>
                </div>
            </div>
        </form>
    </div>
@stop

@push('scripts')   
    <script>
        document.getElementById('formulario-inscricao').addEventListener('submit', function(event) {   
            if(
                !document.getElementById('nome').value ||
                !document.getElementById('data_nascimento').value ||
                !document.getElementById('id_tipo_documento').value ||
                !document.getElementById('numero_documento').value ||
                !document.getElementById('endereco').value ||
                !document.getElementById('numero_contato').value ||
                !document.getElementById('email').value
            ){
                // alert("Você esqueceu de preencher algum campo obrigatório!")
                return
            }         
            // Desabilita o botão de envio
            const submitBtn = document.getElementById('submit-button');
            submitBtn.disabled = true;

            const fileInputs = document.querySelectorAll('.file-input-required');
            let isValid = true;

            fileInputs.forEach(function(input) {
                // console.log(input.files.length);
                if(input.files.length == 0){
                    isValid = false;
                    return
                }
                // if(!input.hasAttribute('aria-invalid', 'false')){
                //     isValid = false;
                //     // alert("teste");
                //     return;
                // }
            })

            // Se algum campo não for válido, impede o envio
            if (!isValid) {
                alert("Está faltando algum documento obrigatório!");
                event.preventDefault();
                // Desabilita o botão de envio
                // if (document.getElementByName("data_nascimento").value)
                const submitBtn = document.getElementById('submit-button');
                submitBtn.disabled = false;
                return; // não envia o formulário
            }        
        });

        document.addEventListener('DOMContentLoaded', function() {

            let inputs = document.querySelectorAll('input[name="deficiencia"]');
            let deficienciaId = document.getElementById('anexo_deficiencia');

            inputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    if (this.value == '1') {
                        document.querySelector('.area_deficiencia').classList.remove('d-none');
                        //adicionar file-input-required no input de deficiencia
                        deficienciaId.classList.add('file-input-required');

                    } else if (this.value == '2') {
                        document.querySelector('.area_deficiencia').classList.add('d-none');
                        //remover file-input-required no input de deficiencia
                        deficienciaId.classList.remove('file-input-required');
                    }
                });
            });           

        });

        function mudarVaga(id_curso) {
            window.location.href = "/redirecionamento/inscricao/"+id_curso;
        }

        function esconderCampos(id_curso){
            // let anexoComprovante = document.getElementById('anexo_comprovante_endereco');
            let anexoDeclaracao = document.getElementById('anexo_declaracao_disponibilidade');
            // let anexoCarta = document.getElementById('anexo_carta_intencao');

            if (id_curso == 17){
                // document.querySelector('.div-comprovante').classList.remove('d-none');
                document.querySelector('.div-declaracao').classList.remove('d-none');
                // document.querySelector('.div-carta').classList.remove('d-none');
                // anexoComprovante.classList.add('file-input-required');
                anexoDeclaracao.classList.add('file-input-required');
                // anexoCarta.classList.add('file-input-required');
            }else{
                // document.querySelector('.div-comprovante').classList.add('d-none');
                document.querySelector('.div-declaracao').classList.add('d-none');
                // document.querySelector('.div-carta').classList.add('d-none');
                // anexoComprovante.classList.remove('file-input-required');
                anexoDeclaracao.classList.remove('file-input-required');
                // anexoCarta.classList.remove('file-input-required');
            }
        }

        // document.addEventListener('DOMContentLoaded', function() {
        //     let processo = document.querySelectorAll('input[name="id_processo_seletivo_curso"]')
        //     // let processoId = document.getElementById('div_especifico')
        //     processo.forEach(function(hidden_div){
        //         hidden_div.addEventListener('change', function() {
        //             alert(this.value);
        //             // if (this.value == 1 || this.value == 2) {
        //             //     document.querySelector('.div-especifico').classList.remove('d-none');
        //             // }else{
        //             //     document.querySelector('.div-especifico').classList.add('d-none');
        //             // }
        //         });
        //     });
        // });
    </script>
@endpush

@php
    // function tirarAcentos($string){
    //     return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/", "/(ç)/", "/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
    // }
@endphp