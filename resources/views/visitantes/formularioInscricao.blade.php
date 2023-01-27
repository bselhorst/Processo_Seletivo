@extends('layouts.layout-guest')

@section('header')
    Formulário - <span class="fw-normal">Inscrição</span>
@stop

@section('content')
<div class="card">
    <form class="form-validate-jquery" method='POST' action="{{ route('password.update') }}" novalidate>
        @csrf
        @method('put')
        <div class="card-body">
			<div class="fw-bold border-bottom pb-2 mb-3">Dados do Processo Seletivo</div>            
            <div class="row mb-3">
				<label class="col-form-label col-lg-3">Processo Seletivo<span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<select name="styled_select" class="form-select" required="">
						<option value="">Escolha um tipo de ducumento abaixo</option> 
						<option value="AK">CNH</option>
						<option value="AK">RG</option>
						<option value="HI">CPF</option>
						<option value="CA">Passaporte</option>
						<option value="CA">Documento de Classe</option>
					</select>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Vaga<span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<select name="styled_select" class="form-select" required="">
						<option value="">Escolha um tipo de ducumento abaixo</option> 
						<option value="AK">CNH</option>
						<option value="AK">RG</option>
						<option value="HI">CPF</option>
						<option value="CA">Passaporte</option>
						<option value="CA">Documento de Classe</option>
					</select>
				</div>
			</div>

			<div class="fw-bold border-bottom pb-2 mb-3">Dados de Inscrição</div>
            <p class="mb-4">NOTA: Por favor, leia com atenção os campos e preencha corretamente as informações abaixo.</p>
            <div class="row mb-3">
				<label class="col-form-label col-lg-3">Nome Completo <span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<input type="text" name="name" class="form-control" required="" placeholder="Nome completo sem abreviações" aria-invalid="false">
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Tipo de Documento (Com foto) <span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<select name="styled_select" class="form-select" required="">
						<option value="">Escolha um tipo de ducumento abaixo</option> 
						<option value="AK">CNH</option>
						<option value="AK">RG</option>
						<option value="HI">CPF</option>
						<option value="CA">Passaporte</option>
						<option value="CA">Documento de Classe</option>
					</select>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Número do documento <span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<input type="text" name="cpf" class="form-control" required="" placeholder="Ex: 12345678901" aria-invalid="false">
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Endereço<span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<input type="text" name="endereco" class="form-control" required="" placeholder="Ex: Rua 7 de Setembro, 000" aria-invalid="false">
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Bairro</label>
				<div class="col-lg-9">
					<input type="text" name="endereco" class="form-control" placeholder="Ex: Centro" aria-invalid="false">
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Número para contato (DDD + número (somente número)) <span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<input type="text" name="digits" class="form-control" required="" placeholder="68999999999">
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Email</label>
				<div class="col-lg-9">
					<input type="email" name="email" class="form-control" id="email" placeholder="Adicione um email válido" aria-invalid="true">
				</div>
			</div>

			<div class="fw-bold border-bottom pb-2 mb-3">Documentos Comprobatórios</div>

			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Documento com foto (RG, Passaporte, Carteira de Trabalho)</h5>
				</div>
				<div class="card-body">
					<p class="mb-3">Bootstrap <code>file input</code> html, video, audio, flash, and objects.</p>					
					<p class="fw-semibold">Pré visualização</p>
					<input type="file" class="file-input" multiple="multiple" required>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Titulação (Mestrado, dourotado)</h5>
				</div>
				<div class="card-body">					
					<p class="fw-semibold">Pré visualização</p>
					<input type="file" class="file-input" multiple="multiple" required>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Qualificação e aperfeiçoamento profissional</h5>
				</div>
				<div class="card-body">					
					<p class="fw-semibold">Pré visualização</p>
					<input type="file" class="file-input" multiple="multiple" required>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Experiência Profissional</h5>
				</div>
				<div class="card-body">					
					<p class="fw-semibold">Pré visualização</p>
					<input type="file" class="file-input" multiple="multiple" required>
				</div>
			</div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Fazer Inscrição </button>
            </div>
        </div>        
    </form>
</div>
@stop