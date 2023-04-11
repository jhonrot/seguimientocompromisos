
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
									</div>
								</div>
							</nav>
						</div>
					</div>            
				</div>
			</div>
		</header>

        @yield('content')

		<div align="center" ><span id="loading"></span></div>

		<div id="footer-box" style="margin-top: 10%;" >
    
			<div class="tabla1 tablaBloque260  ">
                <div class="contenido1">
					<div id="copyright">
						<div class='bloqueZona3  tipoDysplay'>
							<div class="tabla1 tablaBloque253">
								
								<div class="contenido1">
									<div class="container">
										<div class="row">

											<div class="col-md-12 brand" align="center" >
												<span>Todos los Derechos Reservados © 2022</span>
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

		<script>
			$(document).ready(function(){

				$('#formLogin').on('submit',function(){
					$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
				})
			})
		</script>

		<script type="text/javascript" src="https://www.cali.gov.co/media/plugins/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://www.cali.gov.co/media/plugins/default/js/global.min.js"></script>
		<script type="text/javascript" src="https://www.cali.gov.co/media/plugins/jqueryui/1.12.1/jquery-ui.min.js"></script>
	</body>
</html>
