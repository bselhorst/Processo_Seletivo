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

	{{-- <!-- Theme JS files -->
	<script src="{{ asset('assets/js/vendor/visualization/echarts/echarts.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/maps/echarts/world.js') }}"></script> --}}
	<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/validation/validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/uploaders/fileinput/fileinput.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>

	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="{{ asset('assets/demo/pages/uploader_bootstrap.js') }}"></script>
	<script src="{{ asset('assets/demo/pages/form_validation_styles.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_validation_library.js') }}"></script>
	<script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
	{{-- <script src="{{ asset('assets/demo/charts/pages/dashboard_6/area_gradient.js') }}"></script>
	<script src="{{ asset('assets/demo/charts/pages/dashboard_6/map_europe_effect.js') }}"></script>
	<script src="{{ asset('assets/demo/charts/pages/dashboard_6/progress_sortable.js') }}"></script>
	<script src="{{ asset('assets/demo/charts/pages/dashboard_6/bars_grouped.js') }}"></script>
	<script src="{{ asset('assets/demo/charts/pages/dashboard_6/line_label_marks.js') }}"></script> --}}
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-expand-xl navbar-static shadow">
		<div class="container-fluid">
			<div class="navbar-brand flex-1">
				<a href="/" class="d-inline-flex align-items-center">
					<img src="{{ asset('images/logo_dark.png') }}" class="h-48px" alt="">
					{{-- <img src="../../../assets/images/logo_icon.svg" alt="">
					<img src="../../../assets/images/logo_text_dark.svg" class="d-none d-sm-inline-block h-16px invert-dark ms-3" alt=""> --}}
				</a>
			</div>

			<div class="d-flex w-100 w-xl-auto overflow-auto overflow-xl-visible scrollbar-hidden border-top border-top-xl-0 order-1 order-xl-0 pt-2 pt-xl-0 mt-2 mt-xl-0">
				<ul class="nav gap-1 justify-content-center flex-nowrap flex-xl-wrap mx-auto">
					<li class="nav-item">
						<a href="/" class="navbar-nav-link rounded">
						{{-- <a href="index.html" class="navbar-nav-link rounded active"> --}}
							<i class="ph-house me-2"></i>
							Home
						</a>
					</li>

					<li class="nav-item nav-item-dropdown-xl dropdown">
						<a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown">
							<i class="ph-scroll me-2"></i>
							Formulários
						</a>

						<div class="dropdown-menu">
							<a href="/inscricao" class="dropdown-item rounded">Inscrição</a>
						</div>
					</li>

					{{-- <li class="nav-item nav-item-dropdown-xl dropdown">
						<a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown">
							<i class="ph-arrows-clockwise me-2"></i>
							Switch
						</a>

						<div class="dropdown-menu dropdown-menu-end">
							<div class="dropdown-submenu dropdown-submenu-start">
								<a href="#" class="dropdown-item dropdown-toggle">
									<i class="ph-layout me-2"></i>
									Layouts
								</a>
								<div class="dropdown-menu">
									<a href="../../layout_1/full/index.html" class="dropdown-item">Default layout</a>
									<a href="../../layout_2/full/index.html" class="dropdown-item">Layout 2</a>
									<a href="../../layout_3/full/index.html" class="dropdown-item">Layout 3</a>
									<a href="../../layout_4/full/index.html" class="dropdown-item">Layout 4</a>
									<a href="../../layout_5/full/index.html" class="dropdown-item">Layout 5</a>
									<a href="index.html" class="dropdown-item active">Layout 6</a>
									<a href="../../layout_7/full/index.html" class="dropdown-item disabled">
										Layout 7
										<span class="opacity-75 fs-sm ms-auto">Coming soon</span>
									</a>
								</div>
							</div>
							<div class="dropdown-submenu dropdown-submenu-start">
								<a href="#" class="dropdown-item dropdown-toggle">
									<i class="ph-swatches me-2"></i>
									Themes
								</a>
								<div class="dropdown-menu">
									<a href="index.html" class="dropdown-item active">Default</a>
									<a href="../../../LTR/material/full/index.html" class="dropdown-item disabled">
										Material
										<span class="opacity-75 fs-sm ms-auto">Coming soon</span>
									</a>
									<a href="../../../LTR/clean/full/index.html" class="dropdown-item disabled">
										Clean
										<span class="opacity-75 fs-sm ms-auto">Coming soon</span>
									</a>
								</div>
							</div>
						</div>
					</li> --}}
                    <li class="nav-item">
						@if (@Auth::user()->name)
							<li class="nav-item">
								<a href="/processoseletivo" class="navbar-nav-link rounded">
								{{-- <a href="index.html" class="navbar-nav-link rounded active"> --}}
									<i class="ph-folder-lock me-2"></i>
									Sistema Interno
								</a>
							</li>
							<li class="nav-item nav-item-dropdown-xl dropdown">
								<a href="#" class="navbar-nav-link dropdown-toggle rounded" data-bs-toggle="dropdown">
									<i class="ph-user me-2"></i>
									{{ @Auth::user()->name }}
								</a>

								<div class="dropdown-menu">
									<a href="{{ route('profile.perfil') }}" class="dropdown-item">
										<i class="ph-identification-card me-2"></i>
										Perfil
									</a>
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
						@else
							<a href="{{ route("login") }}" class="navbar-nav-link rounded">
								<i class="ph-user me-2"></i>
								Login
							</a>
						@endif
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content container d-lg-flex">
						<div class="d-flex">
							<h4 class="page-title mb-0">
								@yield('header')
							</h4>

							<a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
								<i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content container pt-0">

                    @yield('content')

				</div>
				<!-- /content area -->


				<!-- Footer -->
				<div class="navbar navbar-sm navbar-footer border-top">
					<div class="container-fluid">
						<span>&copy; {{ date('Y') }} <a href="/">IEPTEC - Instituto de Educação Profissional e Tecnológico</a></span>
					</div>
				</div>
				<!-- /footer -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    @stack('scripts')
</body>
</html>
