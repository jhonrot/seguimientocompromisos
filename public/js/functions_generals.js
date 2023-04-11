	function loader_function(){
		$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");				
	}

	$(document).ready(function(){

		$('#lia_page_home').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_profile').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_user').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})
		
		$('#lia_page_role').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_tema').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})
		
		$('#lia_page_seguimiento').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_actividad').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_equipos').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_organismos').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_prioridades').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_clasificaciones').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_estado_seguimientos').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_inform').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_help').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_comunas').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_modalidades').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_proyecto').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_paa').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_const').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_ejecs').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_tema_despacho').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_tarea_despacho').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_indices').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_sub_clasificaciones').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})
		
		$('#lia_page_procesos').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_objetivos').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})
		
		$('#lia_page_obligaciones').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_periodos').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})

		$('#lia_page_planes').on('click',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})
		
		$('#form_submit').on('submit',function(){
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		})
	})
	
	function soloNumeros(e) {
		var key = window.Event ? e.which : e.keyCode;

		return ((key >= 48 && key <= 57) || key === 8  || key === 13 || key === 46); 
	}

	function copy_paste_number(atrib, valor, maximo){
		var returnString = "";
		var anArray = valor.split('');
		var cant = anArray.length;
		var cant_number = 0;
		for(var i=0; i<cant; i++) {
			if(anArray[i] > 0 && anArray[i] <= 9 && anArray[i] != " " && cant_number < maximo){
				cant_number++;
				returnString += anArray[i];
			}else{
				if(anArray[i] == 0 && i > 0 && anArray[i] != " " && cant_number < maximo){
					cant_number++;
					returnString += anArray[i];
				}
			}
		}
        document.getElementById(atrib).value = returnString;
	}

	function show_message_info(mensaje,icono,color){
		$('#mediumModal').modal("show");
		$('#mediumBody').html("<div class='row' >"+
									"<div class='col-sm-2'>"+
										"<span style='font-size: 45px;color: "+color+";' class='"+icono+"'></span>"+
									"</div>"+
		
									"<div class='col-sm-10'><h3>"+mensaje+"</h3></div><br><br><br>"+
									"<div class='col-sm-12'>"+
										"<center>"+
											"<a type='button' class='btn btn-success' style='color: white;border: green;' href='javascript:cerrar_ventana_medium()' ><b> <span class='glyphicon glyphicon-floppy-saved' ></span> Aceptar</b></a>"+ 
										"</center>"+
									"</div>"+
								"</div>").show();
	}

	function cerrar_ventana_medium(){
		$('#mediumModal').modal("hide");
	}
	
	function validar_cant_caracteres(cant, entrada, salida){
		var cant_entrada = ($("#"+entrada).val()).length;
		var cant_restantes = (cant-cant_entrada);
		document.getElementById(salida).innerHTML = cant_restantes+" carácteres restantes";
	}