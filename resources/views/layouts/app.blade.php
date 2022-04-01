<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	
	<link rel="stylesheet" media="screen, print" href="{{asset('custom/css/vendors.bundle.css')}}">
    <link rel="stylesheet" media="screen, print" href="{{asset('custom/css/app.bundle.css')}}">
	<link rel="stylesheet" media="screen, print" href="{{asset('custom/css/myStyles.css')}}">
	<link rel="stylesheet" media="screen, print" href="{{asset('custom/css/datatables.bundle.css')}}">
	
	<!--<link rel="stylesheet" type="text/css" href="{{asset('smartAdmin/css/datatables.bundle.css')}}>-->
 

	
	
	<!--This means we can define a css section-->
	@yield('css')
</head>
<body>
    <!-- BEGIN Page Wrapper -->
	<div class="page-wrapper">
		@auth
		<aside class="page-sidebar">
			@include('partials/nav')
		</aside>
		@endauth
		<div class="page-inner">		
			<div class="container">
				
				<div id="app">
					<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
						<div class="container"><!--test container-->
							<a class="navbar-brand" href="{{ url('/') }}">
								{{ config('app.name', 'Laravel') }}
							</a>
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
								<span class="navbar-toggler-icon"></span>
							</button>

							<div class="collapse navbar-collapse" id="navbarSupportedContent">
								<!-- Right Side Of Navbar -->
								<ul class="navbar-nav ml-auto">
									<!-- Authentication Links -->
									@guest
										<li class="nav-item">
											<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
										</li>
										@if (Route::has('register'))
											<li class="nav-item">
												<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
											</li>
										@endif
									@else
										<li class="nav-item dropdown">
											<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
												{{ Auth::user()->name }} <span class="caret"></span>
											</a>

											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
												
												<a class="dropdown-item" href="">
													My Profile
												</a>
												
												<a class="dropdown-item" href="{{ route('logout') }}"
												   onclick="event.preventDefault();
															document.getElementById('logout-form').submit();">
													{{ __('Logout') }}
												</a>

												<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
													@csrf
												</form>
											</div> <!--end dropdown-menu-->
										</li>
									@endguest
								</ul>
							</div><!--end navbarSupportedContent-->
						</div><!--end test container-->
					</nav>
				</div><!-- end app -->
				
				
				<div class="container my-5">
									
					<!--begin message alerts panel-->
					@if(session()->has('success'))
						<div class="alert alert-success">
							{{session()->get('success')}}
						</div>
					@endif
					
					@if(session()->has('error'))
						<div class="alert alert-danger">
							{{session()->get('error')}}
						</div>
					@endif										
				</div><!--end alerts container-->
				@yield('content')
				
			</div><!--end container-->
			
		<!--@auth	
		@else
			@yield('content')
		@endauth-->

			
		</div><!--end page inner-->							
	</div><!--end page wrapper-->
				
                 	
	<!-- this overlay is activated only when mobile menu is triggered 
	<div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>-->
				
    
	
	<!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}"></script> This one works for cms tutorial-->
	
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link rel="stylesheet"href="css/bs_leftnavi.css">
	<script src="js/bs_leftnavi.js"></script>
	<script src="{{asset('custom/js/navbar.js')}}"></script>--><!--css for the sidebar nav accordion plugin-->
	<script src="{{asset('custom/js/vendors.bundle.js')}}"></script>	
    <script src="{{asset('custom/js/app.bundle.js')}}"></script>
	<script src="{{asset('custom/js/myScripts.js')}}"></script>
	<script src="{{asset('custom/js/gauge.min.js')}}"></script>
	<!--<script src="{{asset('custom/jQuery-3.3.1/jquery-3.3.1.js')}}"></script>-->
	
	<!-- This makes menu not work. <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
	
	<!--added 3/10/2020 for datatables-->
	<script type="text/javascript" charset="utf8" src="{{asset('smartAdmin\js\datagrid\datatables\datatables.bundle.js')}}"></script>
	<script type="text/javascript" charset="utf8" src="{{asset('smartAdmin\js\datagrid\datatables\datatables.export.js')}}"></script>
	
	
	<script type="text/javascript" src="{{asset('jQuery-3.3.1/jquery.dataTables.js')}}"></script>
	
	<!--added for colReorder, but won't work<script type="text/javascript" src="{{asset('custom/js/jquery.dataTables_1_10_20.min.js')}}"></script>-->
	<script type="text/javascript" src="{{asset('custom/js/dataTables.colReorder.min.js')}}"></script>
	<script src="{{asset('custom/php_scripts/php_functions.php')}}"></script>
	<!--added for dateRangePicker-->	
	<!--<script type="text/javascript" src="{{asset('smartAdmin\js\dependency\moment.js')}}"></script>
	<script type="text/javascript" src="{{asset('smartAdmin\js\formplugins\bootstrap-datepicker.js')}}"></script>-->
	
	
	
	
	
	<!--added 3/28/2020 for modals-->
	<script type="text/javascript" src="{{asset('custom/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('custom/js/popper.min.js')}}"></script>
	
	<!--<script type="text/javascript" src="{{asset('custom/js/datatables.bundle.js')}}"></script>-->
	<script>
    	$(document).ready( function () {
				$('#dt-basic-example').DataTable({"paging" : true,
					responsive: true,
					colReorder: true,
					stateSave:  true
				});
				$('.dataTables_length').addClass('bs-select');
				<!--$('#dt-basic-example').DataTable({"responsive" : true});-->      
			   	
    	});
    	
    	
    
    	/*$.pickDate = function(){
        	$('#myDatepicker').datepicker('show');
        };
    
    	function displayCal() {
			$.pickDate();
 		};*/
    	
	</script>


	
	
		
	@yield('scripts')
</body>
</html>
