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
						<div class="card-body">
							{{-- <div class="card-img-actions me-sm-3 mb-3 mb-sm-0">
								<a href="{{ route('edital', $item->id) }}" class="d-inline-block position-relative" data-bs-toggle="modal">
									<img src="../../../assets/images/demo/carousel/6.jpg" class="img-fluid card-img" alt="">
								</a>
							</div> --}}

							<div class="mb-3">
								<h5 class="d-flex flex-nowrap my-1" style="text-align: justify">
									<a href="{{ route('edital', $item->id) }}" class="me-2">{{ $item->titulo }}</a>
									{{-- <span class="text-success ms-auto">$49.99</span> --}}
								</h5>

								<ul class="list-inline list-inline-bullet text-muted mb-0">
									{{-- <li class="list-inline-item">By <a href="#" class="text-body">Eugene Kopyov</a></li> --}}
									<li class="list-inline-item">Abertura: {{ date('d/m/Y h:i', strtotime($item->data_abertura)) }}</li>
									<li class="list-inline-item">Encerramento: {{ date('d/m/Y h:i', strtotime($item->data_encerramento)) }}</li>
								</ul>
							</div>

							<p style="text-align: justify">{{ $item->descricao }}</p>

						</div>

						<div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
							<ul class="list-inline mb-0">
								{{-- <li class="list-inline-item"><i class="ph-users me-1"></i> 382</li>
								<li class="list-inline-item"><i class="ph-book me-1"></i> 12</li>
								<li class="list-inline-item"><i class="ph-clock me-1"></i> 60 hours</li> --}}
							</ul>

							<div class="mt-2 mt-sm-0">
								<a href="{{ route('edital', $item->id) }}">
									Acessar
									<i class="ph-arrow-right ms-2"></i>
								</a>
							</div>
						</div>
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