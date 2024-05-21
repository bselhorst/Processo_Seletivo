@extends('layouts.layout-guest')

@section('header')
    Principal - <span class="fw-normal">Processos Seletivos</span>
@stop

@section('content')

<div class="card">
    <div class="card-header d-flex py-0">	
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
								@if (Storage::get("public/editais/$item->id/resultado.pdf"))
									<code>RESULTADO PUBLICADO</code>
								@endif
								<ul class="list-inline list-inline-bullet text-muted mb-0">
									<li class="list-inline-item">Abertura: {{ date('d/m/Y h:i', strtotime($item->data_abertura)) }}</li>
									<li class="list-inline-item">Encerramento: {{ date('d/m/Y h:i', strtotime($item->data_encerramento)) }}</li>
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

									<div class="mt-2 mt-sm-0">
										<a href="{{ route('edital', $item->id) }}">
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

									<div class="mt-2 mt-sm-0">
										<b>NOVO</b>
									</div>

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

								<div class="mt-2 mt-sm-0">
									<b>ENCERRADO</b>
								</div>

								<div class="mt-2 mt-sm-0">
									<a href="{{ route('edital', $item->id) }}">
										Acessar
										<i class="ph-arrow-right ms-2"></i>
									</a>
								</div>
							</div>
							@if ($item->resultado)
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
							@endif							
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