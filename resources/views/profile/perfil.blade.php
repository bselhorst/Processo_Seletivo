@extends('layouts.layout')
@section('content')

<!-- Custom styles -->
<div class="card">
    <form class="needs-validation" method='POST' action="{{ route('profile.update') }}" novalidate>
        @csrf
        @method('patch')
        <div class="card-body">            
            <div class="fw-bold border-bottom pb-2 mb-3">Informações do Perfil</div>
            <p class="mb-4">Atualize a informação do perfil e o endereço de email.</p>
            <div class="row mb-3">
                <label class="col-form-label col-lg-3">Nome <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ old('name', $user->name) }}" required>
                    <div class="invalid-feedback">Invalid feedback</div>
                    <div class="valid-feedback">Valid feedback</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-lg-3">Email <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="email" name="email" class="form-control" placeholder="Nome" value="{{ old('email', $user->email) }}" required>
                    <div class="invalid-feedback">Invalid feedback</div>
                    <div class="valid-feedback">Valid feedback</div>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Salvar </button>
            </div>
        </div>        
    </form>
</div>

<div class="card">
    <form class="form-validate-jquery" method='POST' action="{{ route('password.update') }}" novalidate>
        @csrf
        @method('put')
        <div class="card-body">            
            <div class="fw-bold border-bottom pb-2 mb-3">Atualizar Senha</div>
            <p class="mb-4">Assegure que sua conta está usando um password forte para continuar seguro.</p>
            <div class="row mb-3">
                <label class="col-form-label col-lg-3">Senha Atual <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input type="password" name="current_password" class="form-control" placeholder="Senha atual" required>
                </div>
            </div>

			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Senha Nova <span class="text-danger">*</span></label>
				<div class="col-lg-9">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Senha nova (min: 8 caracteres)" required>
                </div>
			</div>

			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Confirme a senha nova <span class="text-danger">*</span></label>
				<div class="col-lg-9">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar senha nova" required>
                </div>
			</div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Salvar </button>
            </div>
        </div>        
    </form>
</div>


@stop
