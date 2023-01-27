<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>IEPTEC</title>

	<!-- Global stylesheets -->
	<link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('assets/demo/demo_configurator.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
	<!-- /core JS files -->

    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/validation/validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/uploaders/fileinput/fileinput.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/notifications/bootbox.min.js') }}"></script>

	<!-- Theme JS files -->
	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="{{ asset('assets/demo/pages/uploader_bootstrap.js') }}"></script>
	<script src="{{ asset('assets/demo/pages/form_validation_styles.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_validation_library.js') }}"></script>
	<script src="{{ asset('assets/demo/pages/datatables_basic.js') }}"></script>
	<script src="{{ asset('assets/demo/pages/components_modals.js') }}"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
		<div class="container-fluid">
			<div class="d-flex d-lg-none me-2">
				<button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
					<i class="ph-list"></i>
				</button>
			</div>

			<div class="navbar-brand flex-1 flex-lg-0">
				<a href="/" class="d-inline-flex align-items-center">
					<img src="{{ asset('images/logo_light.png') }}" class="h-32px" alt="">
					{{-- <img src="../../../assets/images/logo_text_light.svg" class="d-none d-sm-inline-block h-16px ms-3" alt=""> --}}
				</a>
                <div style="margin-left: 10px">
                    Sistema de Processo Seletivo
                </div>
			</div>

			<ul class="nav flex-row justify-content-end order-1 order-lg-2">

				<li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
					<a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
						<span class="d-none d-lg-inline-block mx-lg-2">{{ Auth::user()->name }}</span>
					</a>

					<div class="dropdown-menu dropdown-menu-end">
						<a href="{{ route('profile.perfil') }}" class="dropdown-item">
							<i class="ph-identification-card me-2"></i>
							Perfil
						</a>
						<div class="dropdown-divider"></div>
						{{-- <a href="#" class="dropdown-item">
							<i class="ph-gear me-2"></i>
							Account settings
						</a> --}}
						
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                <i class="ph-sign-out me-2"></i>
                                Logout
                            </button>
                        </form>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- Sidebar header -->
				<div class="sidebar-section">
					<div class="sidebar-section-body d-flex justify-content-center">
						<h5 class="sidebar-resize-hide flex-grow-1 my-auto">Menu</h5>

						<div>
							<button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
								<i class="ph-arrows-left-right"></i>
							</button>

							<button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
								<i class="ph-x"></i>
							</button>
						</div>
					</div>
				</div>
				<!-- /sidebar header -->


				<!-- Main navigation -->
				<div class="sidebar-section">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						<li class="nav-item-header pt-0">
							<div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
							<i class="ph-dots-three sidebar-resize-show"></i>
						</li>
						<li class="nav-item">
							<a href="/" class="nav-link">
								<i class="ph-house"></i>
								<span>
									Principal
									{{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
								</span>
							</a>
						</li>
						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link">
								<i class="ph-clipboard-text"></i>
								<span>Auxiliares</span>
							</a>
							<ul class="nav-group-sub collapse">
								<li class="nav-item"><a href="{{ route('aux.municipio.index') }}" class="nav-link">Municípios</a></li>
							</ul>
						</li>
						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link">
								<i class="ph-swatches"></i>
								<span>Processos Seletivos</span>
							</a>
							<ul class="nav-group-sub collapse">
								<li class="nav-item"><a href="{{ route('ps.index') }}" class="nav-link">Listar</a></li>
								<li class="nav-item"><a href="{{ route('ps.create') }}" class="nav-link">Cadastrar</a></li>
								<li class="nav-item"><a href="../../../LTR/material/full/index.html" class="nav-link disabled">Cursos <span class="badge align-self-center ms-auto">Coming soon</span></a></li>
							</ul>
						</li>
						<!-- /page kits -->
					</ul>
				</div>
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Content area -->
				<div class="content">

						
					@yield('content')


				</div>
				<!-- /content area -->


				<!-- Footer -->
				<div class="navbar navbar-sm navbar-footer border-top">
					<div class="container-fluid">
						<span>&copy; 2023 <a href="http://ieptec.acre.gov.br">IEPTEC - Instituto Profissional e Tecnológico</a></span>

					</div>
				</div>
				<!-- /footer -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


</body>
</html>
