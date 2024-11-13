@extends('layouts.layout-guest')

{{-- @section('header')
    <span class="fw-normal">Processos Seletivos</span>
@stop --}}

@section('content')

<style>
	a {
		color: #4CAF50;
	}

	a:hover {
		color: #388E3C
	}
	
	.ribbon-2 {
	--f: 10px; /* control the folded part*/
	--r: 15px; /* control the ribbon shape */
	--t: 10px; /* the top offset */
	
	position: absolute;
	inset: var(--t) calc(-1*var(--f)) auto auto;
	padding: 0 10px var(--f) calc(10px + var(--r));
	clip-path: 
		polygon(0 0,100% 0,100% calc(100% - var(--f)),calc(100% - var(--f)) 100%,
		calc(100% - var(--f)) calc(100% - var(--f)),0 calc(100% - var(--f)),
		var(--r) calc(50% - var(--f)/2));
	background: #BD1550;
	box-shadow: 0 calc(-1*var(--f)) 0 inset #0005;
	color: white; 
	font-size: 16px; 
	font-weight: bold;
	}
	


</style>

<div class="card">
    <div class="card-header text-center" style="background-color: #4CAF50; color: white; font-size: 28px; font-weight: 500">
		Processos Seletivos
	</div>
    <div class="row" style="margin-left: 10px; margin-top: 15px; margin-right: 10px">
        @if (@$data)
			@foreach ($data as $item)
				<div class="col-xl-12">
					<div class="card blog-horizontal">
						<div class="card-body bg-opacity-10 {{ (date(strtotime($item->data_encerramento)) >= time())? ((date(strtotime($item->data_abertura)) <= time())? '' : 'bg-success' ) : 'bg-danger' }}">
							<div class="mb-3">
								<h5 class="d-flex flex-nowrap my-1" style="text-align: justify">
									<a href="{{ route('edital', $item->id) }}" class="me-2">{{ $item->titulo }}</a> 									
								</h5>
								{{-- @if (Storage::get("public/editais/$item->id/resultado.pdf"))
									<code>RESULTADO PUBLICADO</code>
								@endif --}}
								<ul class="list-inline list-inline-bullet text-muted mb-0">
									<li class="list-inline-item">Abertura: {{ date('d/m/Y H:i', strtotime($item->data_abertura)) }}</li>
									<li class="list-inline-item">Encerramento: {{ date('d/m/Y H:i', strtotime($item->data_encerramento)) }}</li>
								</ul>
							</div>
							<p style="text-align: justify">{{ $item->descricao }}</p>

						</div>
						@php
						date_default_timezone_set('America/Rio_Branco');	
						@endphp
						@if (date(strtotime($item->data_encerramento)) > date(strtotime('now')))
							@if (date(strtotime($item->data_abertura)) < date(strtotime('now')))
								<div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
									<ul class="list-inline mb-0">
										{{-- <li class="list-inline-item"><i class="ph-users me-1"></i> {{ App\Models\ProcessoSeletivoCurso::where('id_processo_seletivo', $item->id)->sum('vagas') }}</li> --}}
										<li class="list-inline-item"><i class="ph-book me-1"></i> {{ count(App\Models\ProcessoSeletivoCurso::where('id_processo_seletivo', $item->id)->get()) }}</li>
									</ul>
									<div class="ribbon-2" style="background: #4C9A2A">ABERTO</div>
									<div class="mt-2 mt-sm-0">
										<a href="{{ route('edital', $item->id) }}" style="font-size: 16px; font-weight: bold">
											Acessar
											<i class="ph-arrow-right ms-2"></i>
										</a>
									</div>
								</div>
							@else
								<div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center bg-success bg-opacity-10">
									<ul class="list-inline mb-0">
										{{-- <li class="list-inline-item"><i class="ph-users me-1"></i> {{ App\Models\ProcessoSeletivoCurso::where('id_processo_seletivo', $item->id)->sum('vagas') }}</li> --}}
										<li class="list-inline-item"><i class="ph-book me-1"></i> {{ count(App\Models\ProcessoSeletivoCurso::where('id_processo_seletivo', $item->id)->get()) }}</li>
									</ul>
									<div class="ribbon-2" style="background: #1F4D7A">NOVO</div>

									<div class="mt-2 mt-sm-0">
										<a href="{{ route('edital', $item->id) }}">
											Acessar
											<i class="ph-arrow-right ms-2"></i>
										</a>
									</div>
								</div>
							@endif
						@else
							<div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center bg-danger bg-opacity-10">
								<ul class="list-inline mb-0">
									<li class="list-inline-item"><i class="ph-book me-1"></i> {{ count(App\Models\ProcessoSeletivoCurso::where('id_processo_seletivo', $item->id)->get()) }}</li>
								</ul>

								{{-- <div class="mt-2 mt-sm-0">
									<b>ENCERRADO</b>
								</div> --}}

								<div class="ribbon-2">ENCERRADO</div>

								<div class="mt-2 mt-sm-0">
									<a href="{{ route('edital', $item->id) }}" style="font-size: 16px; font-weight: bold">
										Acessar
										<i class="ph-arrow-right ms-2"></i>
									</a>
								</div>
								
							</div>
							{{-- @if ($item->resultado)
								<div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center bg-success bg-opacity-10">
									<div class="mt-2 mt-sm-0">
										<b>RESULTADO DA ANÁLISE CURRICULAR</b>
									</div>
									<div class="mt-2 mt-sm-0">
										<a href="{{ route('resultado', $item->id) }}">
											Acessar Resultado
											<i class="ph-arrow-right ms-2"></i>
										</a>
									</div>
								</div>
							@endif							 --}}
						@endif
					</div>
				</div>
			@endforeach
		@else
			<div class="col-xl-12">
				<div class="card">
					<div class="card-body text-center">
						<h4>Não foi encontrado nenhum edital.</h4>
					</div>
				</div>
			</div>
		@endif

    </div>
</div>
@stop