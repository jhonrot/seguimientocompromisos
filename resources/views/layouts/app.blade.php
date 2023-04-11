
<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
		<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('css/several.css')}}" rel="stylesheet" type="text/css"/>
		<title>Seguimiento Cali</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="maurice armitage, alcalde de cali, alcaldía de cali">
		<meta property="og:image" content="https://www.cali.gov.co/info/principal/media/galeria200991.jpg">
		<meta property="twitter:image" content="https://www.cali.gov.co/info/principal/media/galeria200991.jpg">

		<link rel="shortcut icon" href="https://www.cali.gov.co/info/principal/web/principal/img/favicon.ico">
		<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" media="screen" />
		<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="https://www.cali.gov.co/media/plugins/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css" />
		<link href="https://www.cali.gov.co/media/css/user.min.css" rel="stylesheet" type="text/css" />
		<link href="https://www.cali.gov.co/info/principal/web/principal/css/user.min.css" rel="stylesheet" type="text/css" />
		<link href="https://www.cali.gov.co/mod/Bloques/css/bloqueMegamenu.css" rel="stylesheet" type="text/css" />

		<script type="text/javascript" src="https://www.cali.gov.co/media/plugins/jquery/3.1.0/jquery-3.1.0.min.js"></script>
		<script type="text/javascript" src="{{asset('js/functions_generals.js')}}"></script>
		
		<!-- Referenciamos la libreria de los graficos -->
		<script src="https://code.highcharts.com/highcharts.js"></script>
    	<script src="https://code.highcharts.com/modules/exporting.js"></script>
    	<script src="https://code.highcharts.com/modules/export-data.js"></script>
    	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
		<script src="https://code.highcharts.com/modules/drilldown.js"></script>
		<style>
			.navbar-nav>li>.dropdown-menu {
				min-width: 100% !important;
			}
		</style>
		@yield('libraries_add')
    </head>
	
	<body class="dPrincipal">

		<header id="navbar">
		
			<div class="nxBlock nxBlock206057 nxBlockDesign1 nxBlockConfigTools nxBlockConfigTools nxBlockConfigTools  "style=".">

				<div class=" defaultConfigTools blockContent">

					<div class="contentLinkToolsHidden">
						<ul class="linkToolsHidden">
							<li><a title="Ir al contenido principal." href="#main-home" class="linkTools">Ir al contenido principal</a></li>
						</ul>
					</div>

					<script type="text/javascript">

						function switchConfigTools(typeDesc){
							$( "body" ).removeClass( "configDefaultTools configHighContrastTools configTextOnlyTools" );
							$( '[data-type="configTools"]' ).removeClass( "active" );

								switch(typeDesc){
									case 'default':
											$('[data-typedes="default"]').addClass("active");
											$( "body" ).addClass("configDefaultTools");
										break;
									case 'highContrast':
											$('[data-typedes="highContrast"]').addClass("active");
											$( "body" ).addClass("configHighContrastTools");
										break;
									case 'textOnly':
											$('[data-typedes="textOnly"]').addClass("active");
											$( "body" ).addClass("configTextOnlyTools");
										break;
								}
						}

						function switchConfigFont(typeDesc){
							$( "body" ).removeClass( "faFontLg faFont2x faFont3x" );
							$( '[data-type="configFont"]' ).removeClass( "active" );

							switch(typeDesc){
								case 'lg':
										$('[data-typedes="lg"]').addClass("active");
										$( "body" ).addClass("faFontLg");
									break;
								case '2x':
										$('[data-typedes="2x"]').addClass("active");
										$( "body" ).addClass("faFont2x");
									break;
								case '3x':
										$('[data-typedes="3x"]').addClass("active");
										$( "body" ).addClass("faFont3x");
									break;
							}
						}

						$(".btnConfigTools").click(function(e){

							e.preventDefault();
							var type = $(this).data("type");
							var typeDesc = $(this).data("typedes");
							console.log(type + " " + typeDesc);
							document.cookie = type+"="+typeDesc+"; path=/";

							if(type == "configTools"){
								switchConfigTools(typeDesc);
							}

							if(type == "configFont"){
								switchConfigFont(typeDesc);
							}

						});

						function readCookie(name) {
							var nameEQ = name + "=";
							var ca = document.cookie.split(';');
							for(var i=0;i < ca.length;i++) {
								var c = ca[i];
								while (c.charAt(0)==' ') c = c.substring(1,c.length);
								if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
							}
							return null;
						}

						$(document).ready(function(){

							var cookieConfigTools = readCookie('configTools');
							var cookieConfigFont = readCookie('configFont');

							if(readCookie('configTools')){
								switchConfigTools(cookieConfigTools);
							}

							if(readCookie('configFont')){
								switchConfigFont(cookieConfigFont);
							}
							
						});

					</script>

				</div>
			</div>

			<div class="tabla1 tablaBloque208  "style=".">
				<div class="contenido1">
					<div id="headerContent" class="container">
						<div class="row">
							<nav class="navbar navbar-default">
								<div class="navbar-header">
									<div id="brand" class="navbar-brand">
										<a href="{{ route('index_home') }}" title="Ir a la página principal">
											<div class="logo-gob">
												<div class='bloqueZona1  tipoDisplay'>
													<img class="img-responsive " src="https://www.cali.gov.co/info/principal/media/bloque207241.png" id="bloqueImg207241" alt="Puro Corazón por Cali"/>
					
												</div>
											</div>
											<div class="logo">
												<div class='bloqueZona1  tipoDisplay'>
													<img class="img-responsive " src="https://www.cali.gov.co/info/principal/media/bloque210342.png" id="bloqueImg210342" alt="Alcaldía de Santiago de Cali"/>
												</div>
											</div>
										</a>
										<h1>Alcaldía de Santiago de Cali</h1>
									</div>
								</div>

								<div class='bloqueZona1  tipoDisplay'>
									<!--        <div class="row-offcanvas row-offcanvas-right">-->
									<nav class="navbar navbar-default nxBlock nxBlockMegamenu nxBlockDesign1 nxBlockMegamenu376 megamenu col-md-9 pull-right navbar-right">
										<div class="navbar-header">
											<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".divNxBlockMegamenu376">
												<span class="sr-only">Desplegar navegaci&oacute;n</span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
											</button>
										</div>
										<div class="collapse navbar-collapse navbar-ex1-collapse divNxBlockMegamenu376 row">
											<ul class="nav navbar-nav navbar-right megamenu" >
												<li id="li_home" name="li_base">
													<a href="{{ route('home') }}" title='Inicio' id="lia_page_home"> <span class="glyphicon glyphicon-home"></span></a>                            
												</li>
												
												@can('planes.index')
													<li id="li_plan" name="li_base" >
														<a href="{{ route('planes.index') }}" title='Plan de trabajo' id="lia_page_planes"><span class="glyphicon glyphicon-list-alt"></span> Plan de trabajo</a>
													</li>
												@endcan

												<li id="li_seguimiento_temas" name="li_base" class="nav-item dropdown" >
													<a href='#' id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre ><span class="glyphicon glyphicon-bookmark"></span> Seguimiento compromisos</a>

													<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
													    
													    @canany(['seguimientos.index', 'seguimientos_assign_them.index'])
															<a href="{{ route('seguimiento.dashboard') }}" title='Seguimientos' id="lia_page_seguimiento"><span class="glyphicon glyphicon-list-alt"></span>Dashboard</a>
														@endcanany
														
														@canany(['temas.index', 'temas_assign.index'])
															<a href="{{ route('temas.index') }}" title='Temas' id="lia_page_tema"><span class="glyphicon glyphicon-list-alt"></span> Compromisos</a>
														@endcanany

														@canany(['seguimientos.index', 'seguimientos_assign_them.index'])
															<a href="{{ route('seguimientos.index') }}" title='Seguimientos' id="lia_page_seguimiento"><span class="glyphicon glyphicon-search"></span> Actividades</a>
														@endcanany

														@canany(['actividades.index', 'actividades_assign_them.index'])
															<a href="{{ route('actividades.index') }}" title='Actividades' id="lia_page_actividad"><span class="glyphicon glyphicon-list-alt"></span> Tareas</a>
														@endcanany

                                                        <!--
														@can('temas.inform')
															<a href="{{ route('temas.data_inform',  ['item1' => 4, 'item2' => 0, 'item3' => 0]  ) }}" title='Informes' id="lia_page_inform"><span class="glyphicon glyphicon-signal"></span> Informe</a>
														@endcan
														-->
													</div>
												</li>

												<li id="li_seguimiento_proyectos" name="li_base" class="nav-item dropdown" >
													<a href='#' id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre ><span class="glyphicon glyphicon-tasks"></span> Presupuestos participativos</a>

													<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
														@canany(['proyectos.index', 'proyectos_assig.index'])
															<a href="{{ route('proyectos.index') }}" title='Proyecto' id="lia_page_proyecto"><span class="glyphicon glyphicon-tower"></span> Proyecto</a>
														@endcanany
													</div>
												</li>

												<li id="li_despachos" name="li_base" class="nav-item dropdown" >
													<a href='#' id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre ><span class="glyphicon glyphicon-object-align-bottom"></span> Reuniones</a>

													<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
														@canany(['tema_despachos.index', 'tema_despachos_create.index'])
															<a href="{{ route('tema_despachos.index') }}" title='Temas despacho' id="lia_page_tema_despacho"><span class="glyphicon glyphicon-list-alt"></span> Reuniones</a>
														@endcanany

														@can('tarea_despachos.index')
															<a href="{{ route('tarea_despachos.index') }}" title='Tareas despacho' id="lia_page_tarea_despacho"><span class="glyphicon glyphicon-log-out"></span> Seguimiento compromisos</a>
														@endcan
													</div>
												</li>

												<li id="li_ajustes" name="li_base" class="nav-item dropdown" >
													<a href='#' id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre ><span class="glyphicon glyphicon-cog"></span> Ajustes</a>

													<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
														@can('equipos.index')	
															<a href="{{ route('equipos.index') }}" id="lia_page_equipos" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-lock"></span> Equipos de trabajo</a>
														@endcan

														@can('organismos.index')	
															<a href="{{ route('organismos.index') }}" id="lia_page_organismos" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-king"></span> Organismos</a>
														@endcan

														@can('prioridades.index')	
															<a href="{{ route('prioridades.index') }}" id="lia_page_prioridades" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-dashboard"></span> Prioridades</a>
														@endcan

														@can('indices.index')	
															<a href="{{ route('indices.index') }}" id="lia_page_indices" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-barcode"></span> Indices</a>
														@endcan

														@can('clasificaciones.index')	
															<a href="{{ route('clasificaciones.index') }}" id="lia_page_clasificaciones" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-filter"></span> Clasificaciones</a>
														@endcan

														@can('sub_clasificaciones.index')	
															<a href="{{ route('sub_clasificaciones.index') }}" id="lia_page_sub_clasificaciones" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-tasks"></span> Referencia transversal</a>
														@endcan

														@can('estado_seguimientos.index')	
															<a href="{{ route('estado_seguimientos.index') }}" id="lia_page_estado_seguimientos" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-record"></span> Estado seguimientos</a>
														@endcan

														@can('comunas.index')	
															<a href="{{ route('comunas.index') }}" id="lia_page_comunas" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-map-marker"></span> Comunas</a>
														@endcan

														@can('modalidades.index')	
															<a href="{{ route('modalidades.index') }}" id="lia_page_modalidades" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-tasks"></span> Modalidades</a>
														@endcan
														
														@can('procesos.index')	
															<a href="{{ route('procesos.index') }}" id="lia_page_procesos" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-tasks"></span> Procesos</a>
														@endcan

														@can('objetivos.index')	
															<a href="{{ route('objetivos.index') }}" id="lia_page_objetivos" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-tasks"></span> Objetivos</a>
														@endcan

														@can('obligaciones.index')	
															<a href="{{ route('obligaciones.index') }}" id="lia_page_obligaciones" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-tasks"></span> Obligaciones</a>
														@endcan

														@can('periodos.index')	
															<a href="{{ route('periodos.index') }}" id="lia_page_periodos" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-tasks"></span> Periodos</a>
														@endcan
													</div>
												</li>

												<li id="li_entrada" name="li_base" class="nav-item dropdown" >
													<a href='#' id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre ><span class="glyphicon glyphicon-ok"></span> Entrada</a>

													<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
														@can('users.index')
															<a href="{{ route('users.index') }}" title='Usuarios' id="lia_page_user"><span class="glyphicon glyphicon-user"></span> Usuarios</a>
														@endcan
														
														@can('roles.index')
															<a href="{{ route('roles.index') }}" title='Roles' id="lia_page_role"><span class="glyphicon glyphicon-wrench"></span> Roles</a>
														@endcan
														
														@can('audits.index')
															<a href="{{ route('audits.index') }}" title='Roles' id="lia_page_audit"><span class="glyphicon glyphicon-inbox"></span> Seguimiento auditoria</a>
														@endcan
													</div>
												</li>

												@canany(['helps.index', 'helps_create.index'])
													<li id="li_help" name="li_base" >
														<a href="{{ route('helps.index') }}" title='Requerimiento o soporte' id="lia_page_help"><span class="glyphicon glyphicon-question-sign"></span> Ayuda</a>
													</li>
												@endcanany

												<li id="li_profile" name="li_base" class="nav-item dropdown">
													<a href='#' id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre ><span class="glyphicon glyphicon-sunglasses"></span> {{ Auth::user()->getName() }}</a>
														
													<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
														<a href="{{ route('users.profile',  ['id' => Auth::user()->id]) }}" id="lia_page_profile" name="li_base" onclick="loader_function()"><span class="glyphicon glyphicon-user"></span>Perfil</a>
														        
                                                        <a class="dropdown-item" id="lia_page" href="{{ route('logout') }}" onclick="event.preventDefault();
																		document.getElementById('logout-form').submit();loader_function();"><span class="glyphicon glyphicon-remove-sign"></span>
															{{ __('Logout') }}
														</a>

														<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" >
															@csrf
														</form>
													</div>
												</li>
											</ul>
										</div>

										<script type="text/javascript">
											$(document).ready(function(){
												var estadoMenu=0;
												$(".dropdown").click(function(){
													if($(window).width() < 769 && estadoMenu==0){
														estadoMenu=1;
														$(".collapseMenu").each(function(){
														//$(this).addClass('fa fa-chevron-right');
															var listado=$(this).data('object');
															$("#"+listado).addClass('collapse');
															$(this).attr("href","#"+listado);
														});
														$(".megamenuPublicacionesEnlace").each(function(){
															var valorHref=$(this).data("href");
															$(this).prop("href",valorHref);
														});
														$('html, body').animate({
															scrollTop: $("#"+$(this).attr("id")).offset().top
														});
													}
													else if($(window).width() < 769){
														$('html, body').animate({
															scrollTop: $("#"+$(this).attr("id")).offset().top
														});
													}
													else if($(window).width() > 769 && estadoMenu==1){
														estadoMenu=0;
														$(".megamenuPublicacionesEnlace").each(function(){
															var valorHref=$(this).data("href");
															$(this).attr("href","#");
														});
														$(".collapseMenu").each(function(){
															$(this).removeClass('fa fa-chevron-right');
															var listado=$(this).data('object');
															$("#"+listado).removeClass('collapse');
															$(this).attr("href",$(this).data("url"));
														});

													}
												});

												$('.dropdown-accordion').on('show.bs.dropdown', function (event) {
													var accordion = $(this).find($(this).data('accordion'));
													accordion.find('.panel-collapse.in').collapse('hide');
												});

												$('.dropdown-accordion').on('click', 'a[data-toggle="collapse"]', function (event) {
													event.preventDefault();
													event.stopPropagation();
													$($(this).data('parent')).find('.panel-collapse.in').collapse('hide');
													$($(this).attr('href')).collapse('show');
												});
											}); // ready

											var enlaces_ajustes = document.querySelector('#li_ajustes').querySelectorAll('a').length;
											if(enlaces_ajustes === 1){
												document.getElementById("li_ajustes").style.display = "none";
											}
											var enlaces_seguimiento_temas = document.querySelector('#li_seguimiento_temas').querySelectorAll('a').length;
											if(enlaces_seguimiento_temas === 1){
												document.getElementById("li_seguimiento_temas").style.display = "none";
											}
											var enlaces_entrada = document.querySelector('#li_entrada').querySelectorAll('a').length;
											if(enlaces_entrada === 1){
												document.getElementById("li_entrada").style.display = "none";
											}
											var enlaces_seguimiento_proyectos = document.querySelector('#li_seguimiento_proyectos').querySelectorAll('a').length;
											if(enlaces_seguimiento_proyectos === 1){
												document.getElementById("li_seguimiento_proyectos").style.display = "none";
											}
											var enlaces_despachos = document.querySelector('#li_despachos').querySelectorAll('a').length;
											if(enlaces_despachos === 1){
												document.getElementById("li_despachos").style.display = "none";
											}
										</script>
									</nav>
								</div>
							</nav>
						</div>
					</div>            
				</div>
			</div>
		</header>

		<div align="center" ><span id="loading"></span></div>

		<div id="main-content">
			<div class="container">
                @yield('content')
			</div>
		</div>

		<!-- medium modal -->
        <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #082458;" align="center">
					<span style="color: white;text-align: center;font-size: 25px;" id="title_modal" ><b>Atención</b></span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="mediumBody">
                        <div>
                            <!-- the result to be displayed apply here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<div id="footer-box" style="margin-top: 25%;">
    
			<div class="tabla1 tablaBloque260  ">
                <div class="contenido1">
					<div id="copyright">
						<div class='bloqueZona3  tipoDysplay'>
							<div class="tabla1 tablaBloque253">
								
								<div class="contenido1">
									<div class="container">
										<div class="row">

											<div class="col-md-12 brand" align="center" >
												<span>Todos los Derechos Reservados © 2021</span>
											</div>

										</div>
									</div>            
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>    
		</div>

		<script type="text/javascript" src="https://www.cali.gov.co/media/plugins/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://www.cali.gov.co/media/plugins/default/js/global.min.js"></script>
		<script type="text/javascript" src="https://www.cali.gov.co/media/plugins/jqueryui/1.12.1/jquery-ui.min.js"></script>

		@yield('libraries_add2')
	</body>
</html>
