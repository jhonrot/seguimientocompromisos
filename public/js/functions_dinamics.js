
var file = 1;

function generarClick_busqueda_imagen(){
	document.getElementById('foto').click();
	document.getElementById("div_registro_fotografico").style.display = "";
}

function mostrar_image(event,formatos){
	$('#message').html('');
	if(event.target.files.length == 1){
		var file = event.target.files[0];
		var filename = file.name;
		var size = ((file.size / 1024) / 1024);
		
		var t = filename.toString().length;
		var formato = (filename.split('.').pop()).toLowerCase();
		
		var cumple = false;
		var info = '';

		for(var i = 0;i < formatos.length;i++)
		{
			if(formatos[i] == formato)
			{
				cumple = true;
			}

			if(info != '')
			{
				if(i == (formatos.length - 1))
				{
					info += ' y ';
				}
				else
				{
					info += ', ';
				}
			}

			info += formatos[i];
		}

		if(cumple)
		{
			if(size <= 5)
			{
				var reader = new FileReader();

				reader.onload = function(event)
				{
					var foto = document.getElementById('img_foto');
					foto.src = event.target.result;
					$("#foto_inicial").val('');
				};

				reader.readAsDataURL(file);

			}else{
				del_input_foto();
				$('#message').html('<div class="col-sm-12">'+
										'<div class="alert alert-danger">'+
											'<button type="button" class="close" data-dismiss="alert" aria-label="close">'+
												'<span aria-hidden="true">&times;</span>'+
											'</button>'+
											'El archivo excede el tamaño maximo permitido, por favor solo documentos menores a 5 Mb.'+
										'</div>'+
								  '</div>').show();
			}
		}else{
			del_input_foto();
			$('#message').html('<div class="col-sm-12">'+
									'<div class="alert alert-danger">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="close">'+
											'<span aria-hidden="true">&times;</span>'+
										'</button>'+
										'Formato de imagen incorrecto, solo documentos '+info+' valor encontrado.'+
									'</div>'+
							  '</div>').show();
		}
	}
}

function del_input_foto(){
	$("#foto_inicial").val('');
	document.getElementById("div_registro_fotografico").style.display = "none";
	$("#span_iput_foto").html('<input type="file" id="foto" name="foto" class="form-control" onchange="mostrar_image(event,[\'png\',\'jpg\',\'jpeg\',\'bmp\'])" accept=".png, .jpg, .jpeg, .bmp" style="display:none" >');
}

function generarClick_busqueda(){
	evidencia_inicial = $("#evidencia_inicial").val();
	if(evidencia_inicial == ''){
		document.getElementById('evidencia').click();
		document.getElementById("div_registro_documento").style.display = "";
	}else{
		$('#mediumModal').modal("show");
		$('#mediumBody').html("<div class='row' >"+    
									"<div class='col-sm-2'>"+ 
										"<span style='font-size: 45px;color: red;' class='glyphicon glyphicon-question-sign'></span>"+ 
									"</div>"+ 
								
									"<div class='col-sm-10'><h3 id='mensaje'>Señor usuario, ya existe un documento registrado.<br>¿ Desea subir un documento nuevo que actualice el registro ?</h3></div><br><br><br>"+ 
									"<div class='col-sm-12'>"+ 
										"<center>"+ 
											"<a type='button' class='btn btn-success' style='color: white;border: green;margin-right: 20px;' href='javascript:confirmar_subir()' > <span class='glyphicon glyphicon-floppy-saved' ></span> <b>Aceptar</b></button>"+   
											"<a type='button' class='btn btn-danger' style='color: white;border: red;' href='javascript:cerrar_ventana_medium()'> <span class='glyphicon glyphicon-remove'></span> <b>Cancelar</b></a>"+ 
										"</center>"+ 
									"</div>"+ 
								"</div>").show();
	}
}

function confirmar_subir(){
	cerrar_ventana_medium();
	document.getElementById('evidencia').click();
	document.getElementById("div_registro_documento").style.display = "";
}

function mostrar_doc(event,formatos){
	$('#message').html('');
	if(event.target.files.length == 1){
		var file = event.target.files[0];
		var filename = file.name;
		var size = ((file.size / 1024) / 1024);
		
		var t = filename.toString().length;
		var formato = (filename.split('.').pop()).toLowerCase();
		
		var cumple = false;
		var info = '';

		for(var i = 0;i < formatos.length;i++)
		{
			if(formatos[i] == formato)
			{
				cumple = true;
			}

			if(info != '')
			{
				if(i == (formatos.length - 1))
				{
					info += ' y ';
				}
				else
				{
					info += ', ';
				}
			}

			info += formatos[i];
		}

		if(cumple)
		{
			if(size <= 5)
			{
				var reader = new FileReader();

				reader.onload = function(event)
				{
					if(formato == "pdf"){
						$("#doc_evidencia").html('<a target="_blank" href="'+event.target.result+'" ><img style="width:37%;border: 1px solid gray;" title="Documento" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/391px-PDF_file_icon.svg.png" ></a>');
						$("#evidencia_inicial").val('');
					}else{
						if(formato == "txt" || formato == "csv" || formato == "xls" || formato == "xlsx" || formato == "docx"){
							$("#doc_evidencia").html('<a target="_blank" href="'+event.target.result+'" ><span class="glyphicon glyphicon-file fa-5x"></span></a>');
							$("#evidencia_inicial").val('');
						}else{
							if(formato == "mp3"){
								$("#doc_evidencia").html('<a target="_blank" href="'+event.target.result+'" ><span class="glyphicon glyphicon-volume-up fa-5x"></span></a>');
								$("#evidencia_inicial").val('');
							}else{
								$("#doc_evidencia").html('<a target="_blank" href="'+event.target.result+'" ><img style="width:37%;border: 1px solid gray;" title="Documento" src="'+event.target.result+'" ></a>');
								$("#evidencia_inicial").val('');
							}
						}
					}
				};
				reader.readAsDataURL(file);
			}else{
				del_input_doc();
				$('#message').html('<div class="col-sm-12">'+
										'<div class="alert alert-danger">'+
											'<button type="button" class="close" data-dismiss="alert" aria-label="close">'+
												'<span aria-hidden="true">&times;</span>'+
											'</button>'+
											'El documento excede el tamaño maximo permitido, por favor solo documentos menores a 5 Mb.'+
										'</div>'+
								  '</div>').show();
			}
		}else{
			del_input_doc();
			$('#message').html('<div class="col-sm-12">'+
									'<div class="alert alert-danger">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="close">'+
											'<span aria-hidden="true">&times;</span>'+
										'</button>'+
										'Formato de documento incorrecto, solo documentos '+info+' valor encontrado.'+
									'</div>'+
							  '</div>').show();
		}
	}
}

function del_input_doc(){
	$("#evidencia_inicial").val('');
	document.getElementById("div_registro_documento").style.display = "none";
	$("#span_iput_file").html('<input type="file" id="evidencia" name="evidencia" class="form-control" onchange="mostrar_doc(event,[\'pdf\',\'png\',\'jpg\',\'jpeg\',\'bmp\',\'txt\',\'csv\',\'xls\',\'xlsx\',\'docx\',\'mp3\'])" accept=".pdf, .png, .jpg, .jpeg, .bmp, .txt, .csv, .xls, .xlsx, .docx, .mp3" style="display:none" >');
	$("#doc_evidencia").html('<img style="width:100%;border: 1px solid gray;" title="Error" src="https://cdn2.iconfinder.com/data/icons/documents-and-files-v-2/100/doc-03-512.png">');
}

function del_input_doc_edit(){
	$("#evidencia_inicial").val('');
	document.getElementById("div_registro_documento").style.display = "none";
	$("#span_iput_file").html('<input type="file" id="evidencia" name="evidencia" class="form-control" onchange="mostrar_doc(event,[\'pdf\',\'png\',\'jpg\',\'jpeg\',\'bmp\',\'txt\',\'csv\',\'xls\',\'xlsx\',\'docx\',\'mp3\'])" accept=".pdf, .png, .jpg, .jpeg, .bmp, .txt, .csv, .xls, .xlsx, .docx, .mp3" style="display:none" >');
	$("#doc_evidencia").html('<img style="width:100%;border: 1px solid gray;" title="Error" src="https://cdn2.iconfinder.com/data/icons/documents-and-files-v-2/100/doc-03-512.png">');
}

function confirmar_eliminar(mensaje,urls){
	$.ajax({
		url: urls,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			$('#mediumModal').modal("show");
			$('#mediumBody').html(result).show();
		},
		complete: function() {
			$("#loading").html("");
			$("#mensaje").html(mensaje);
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function cerrar_ventana_medium(){
	$('#mediumModal').modal("hide");
	$("#loading").html("");
}

function show_message_wait(mensaje){
	$('#mediumModal').modal("show");
	$('#mediumBody').html("<div class='row' >"+
								"<div class='col-sm-2'>"+
									"<span style='font-size: 45px;color: green;' class='glyphicon glyphicon-ok'></span>"+
								"</div>"+
	
								"<div class='col-sm-10'><h3>"+mensaje+"</h3></div><br><br><br>"+
								"<div class='col-sm-12'>"+
									"<center>"+
										"<a type='button' class='btn btn-success' style='color: white;border: green;' href='javascript:cerrar_ventana_medium()' ><b> <span class='glyphicon glyphicon-floppy-saved' ></span> Aceptar</b></a>"+ 
									"</center>"+
								"</div>"+
							"</div>").show();
}

function obtain_list_them(select_item, url_2){
	$.ajax({
		url: url_2,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value='todos'>Todos</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].tema+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].tema+"</option>"
				}
			}
			$("#data_search").html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_them_input(select_item, input,url_completa){
	url_data = url_completa.split("formSearch");
	$.ajax({
		url: url_data[0]+'them',
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione...</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].tema+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].tema+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function load_modal(url){
	$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
	$('#mediumModal').modal("show");
	$('#mediumBody').load(url, function(){
		obtain_list_them_input('','data_search_item_1',url);
	}).show();
}

function change_select_item(url2){
	option = $("#select_search_item").val();
	if(option == 2 || option == 3){
		$("#input_search_item").html('<div class="col-sm-6" >'+
										'<div class="form-group">'+
											'<label class="glyphicon glyphicon-calendar"><b> Fecha 1</b></label>'+
											'<input type="date" class="form-control" id="data_search_item_1" name="data_search_item_1" required />'+
										'</div>'+
									'</div>'+
									'<div class="col-sm-6" >'+
										'<div class="form-group">'+
											'<label class="glyphicon glyphicon-calendar"><b> Fecha 2</b></label>'+
											'<input type="date" class="form-control" id="data_search_item_2" name="data_search_item_2" required />'+
										'</div>'+
									'</div>');
	}else{
		if(option == 1){
			$("#input_search_item").html('<div class="col-sm-12" >'+
											'<div class="form-group">'+
												'<label class="glyphicon glyphicon-list-alt"><b> Tema </b></label>'+
												'<select class="form-control js-example-basic-single" id="data_search_item_1" name="data_search_item_1" >'+
												'</select>'+
											'</div>'+
										'</div>');
			obtain_list_them_input('','data_search_item_1',url2);
			$(document).ready(function() {    
				$('#data_search_item_1').select2({
					placeholder: "Seleccione...",
					allowClear: true,
				});
			});
		}else{
			if(option == 5){
				$("#input_search_item").html('<div class="col-sm-12" >'+
											'<div class="form-group">'+
												'<label class="glyphicon glyphicon-tags"><b> Responsable </b></label>'+
												'<select class="form-control js-example-basic-single" id="data_search_item_1" name="data_search_item_1" >'+
												'</select>'+
											'</div>'+
										'</div>');
				obtain_list_resp_input('','data_search_item_1',url2);
				$(document).ready(function() {    
					$('#data_search_item_1').select2({
						placeholder: "Seleccione...",
						allowClear: true,
					});
				});
			}else{
				if(option == 6){
					$("#input_search_item").html('<div class="col-sm-12" >'+
											'<div class="form-group">'+
												'<label class="glyphicon glyphicon-filter"><b> Clasificación </b></label>'+
												'<select class="form-control js-example-basic-single" id="data_search_item_1" name="data_search_item_1" >'+
												'</select>'+
											'</div>'+
										'</div>');
					obtain_list_clas_input('','data_search_item_1',url2);
					$(document).ready(function() {    
						$('#data_search_item_1').select2({
							placeholder: "Seleccione...",
							allowClear: true,
						});
					});
				}else{
					$("#input_search_item").html('');
				}
			}
		}
	}
}

function url_new_tab(url_completa){
	url_data1 = url_completa.split("0/0/0");
	url_data2 = url_completa.split("search/0/0/0/printForm");
	select_search_item = $("#select_search_item").val();
	data_search_item_1 = $("#data_search_item_1").val();
	if((select_search_item == 1 && data_search_item_1 != "") || ((select_search_item == 2 || select_search_item == 3) && data_search_item_1 != "" && $("#data_search_item_2").val() != "")){
		item_incogn = (typeof $("#data_search_item_2").val()!== 'undefined'?$("#data_search_item_2").val():'0');
		$.ajax({
			url: url_data1[0]+select_search_item+'/'+data_search_item_1+'/'+item_incogn+'/printForm',
			beforeSend: function() {
				$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
			},
			success: function(result) {
				$("#loading").html("");
				dataJson = eval(result);
				cant = dataJson.length;
				for(i=0;i<cant;i++){
					window.open(url_data2[0]+dataJson[i].id+'/prinTema', '_blank');
				}
			},
			complete: function() {
				$("#loading").html("");
			},
			error: function(jqXHR, testStatus, error) {
				console.log(error);
				$("#loading").html("");
			}
		})
	}else{
		alert("Atención\n\nPor favor ingrese todos los campos");
	}
}

function search_inform_graphic(url_completa){
	url_data = url_completa.split("0/0/0");
	select_search_item = $("#select_search_item").val();
	if(select_search_item == 4){
		window.location.href = url_data[0]+$("#select_search_item").val()+'/0/0/printInform';
	}else{
		if(select_search_item == 2 || select_search_item == 3){
			window.location.href = url_data[0]+$("#select_search_item").val()+'/'+$("#data_search_item_1").val()+'/'+$("#data_search_item_2").val()+'/printInform';
		}else{
			window.location.href = url_data[0]+$("#select_search_item").val()+'/'+$("#data_search_item_1").val()+'/0/printInform';
		}
	}
}

function order_select_item(option,item1,item2,url2){
	$("#select_search_item").val(option);
	if(option == 2 || option == 3){
		$("#input_search_item").html('<div class="col-sm-6" >'+
										'<div class="form-group">'+
											'<label class="glyphicon glyphicon-calendar"><b> Fecha 1</b></label>'+
											'<input type="date" class="form-control" id="data_search_item_1" name="data_search_item_1" required value="'+item1+'" />'+
										'</div>'+
									'</div>'+
									'<div class="col-sm-6" >'+
										'<div class="form-group">'+
											'<label class="glyphicon glyphicon-calendar"><b> Fecha 2</b></label>'+
											'<input type="date" class="form-control" id="data_search_item_2" name="data_search_item_2" required value="'+item2+'" />'+
										'</div>'+
									'</div>');
	}else{
		if(option == 1){
			$("#input_search_item").html('<div class="col-sm-12" >'+
											'<div class="form-group">'+
												'<label class="glyphicon glyphicon-list-alt"><b> Tema </b></label>'+
												'<select class="form-control js-example-basic-single" id="data_search_item_1" name="data_search_item_1" >'+
												'</select>'+
											'</div>'+
										'</div>');
			obtain_list_them_input(item1,'data_search_item_1',url2);
			$(document).ready(function() {    
				$('#data_search_item_1').select2({
					placeholder: "Seleccione...",
					allowClear: true,
				});
			});
		}else{
			if(option == 5){
				$("#input_search_item").html('<div class="col-sm-12" >'+
											'<div class="form-group">'+
												'<label class="glyphicon glyphicon-tags"><b> Responsable </b></label>'+
												'<select class="form-control js-example-basic-single" id="data_search_item_1" name="data_search_item_1" >'+
												'</select>'+
											'</div>'+
										'</div>');
				obtain_list_resp_input(item1,'data_search_item_1',url2);
				$(document).ready(function() {    
					$('#data_search_item_1').select2({
						placeholder: "Seleccione...",
						allowClear: true,
					});
				});
			}else{
				if(option == 6){
					$("#input_search_item").html('<div class="col-sm-12" >'+
											'<div class="form-group">'+
												'<label class="glyphicon glyphicon-filter"><b> Clasificación </b></label>'+
												'<select class="form-control js-example-basic-single" id="data_search_item_1" name="data_search_item_1" >'+
												'</select>'+
											'</div>'+
										'</div>');
					obtain_list_clas_input(item1,'data_search_item_1',url2);
					$(document).ready(function() {    
						$('#data_search_item_1').select2({
							placeholder: "Seleccione...",
							allowClear: true,
						});
					});
				}else{
					$("#input_search_item").html('');
				}
			}
		}
	}
}

function show_table(i,r){
	document.getElementById('content_table_data0').style.display = "none";
	document.getElementById('content_table_data1').style.display = "none";
	document.getElementById('content_table_data2').style.display = "none";
	document.getElementById('content_table_data3').style.display = "none";
	if(r == 1){
		document.getElementById('content_table_data').style.display = "none";
		document.getElementById('content_table_data'+i).style.display = "";
	}else{
		document.getElementById('content_table_data').style.display = "";
	}
}

function del_input_doc_all_formats(){
	$("#evidencia_inicial").val('');
	document.getElementById("div_registro_documento").style.display = "none";
	$("#span_iput_file").html('<input type="file" id="evidencia" name="evidencia" class="form-control" onchange="mostrar_doc_all_formats(event,[\'pdf\',\'png\',\'jpg\',\'jpeg\',\'bmp\'])" accept=".pdf, .png, .jpg, .jpeg, .bmp" style="display:none" >');
	$("#doc_evidencia").html('<img style="width:100%;border: 1px solid gray;" title="Error" src="https://cdn2.iconfinder.com/data/icons/documents-and-files-v-2/100/doc-03-512.png">');
}

function mostrar_doc_all_formats(event,formatos){
	$('#message').html('');
	if(event.target.files.length == 1){
		var file = event.target.files[0];
		var filename = file.name;
		var size = ((file.size / 1024) / 1024);
		
		var t = filename.toString().length;
		var formato = (filename.split('.').pop()).toLowerCase();
		
		var cumple = false;
		var info = '';

		for(var i = 0;i < formatos.length;i++)
		{
			if(formatos[i] == formato)
			{
				cumple = true;
			}

			if(info != '')
			{
				if(i == (formatos.length - 1))
				{
					info += ' y ';
				}
				else
				{
					info += ', ';
				}
			}

			info += formatos[i];
		}

		if(cumple)
		{
			if(size <= 5)
			{
				var reader = new FileReader();

				reader.onload = function(event)
				{
					if(formato == "pdf"){
						$("#doc_evidencia").html('<a target="_blank" href="'+event.target.result+'" ><img style="width:37%;border: 1px solid gray;" title="Documento" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/391px-PDF_file_icon.svg.png" ></a>');
						$("#evidencia_inicial").val('');
					}else{
						if(formato == "pdf" || formato == "txt" || formato == "csv" || formato == "xls" || formato == "xlsx" || formato == "docx"){
							$("#doc_evidencia").html('<a target="_blank" href="'+event.target.result+'" ><span class="glyphicon glyphicon-file fa-5x"></span></a>');
							$("#evidencia_inicial").val('');
						}else{
							if(formato == "mp3"){
								$("#doc_evidencia").html('<a target="_blank" href="'+event.target.result+'" ><span class="glyphicon glyphicon-volume-up fa-5x"></span></a>');
								$("#evidencia_inicial").val('');
							}else{
								$("#doc_evidencia").html('<a target="_blank" href="'+event.target.result+'" ><img style="width:37%;border: 1px solid gray;" title="Documento" src="'+event.target.result+'" ></a>');
								$("#foto_inicial").val('');
							}
						}
					}
				};
				reader.readAsDataURL(file);
			}else{
				del_input_doc_all_formats();
				$('#message').html('<div class="col-sm-12">'+
										'<div class="alert alert-danger">'+
											'<button type="button" class="close" data-dismiss="alert" aria-label="close">'+
												'<span aria-hidden="true">&times;</span>'+
											'</button>'+
											'El documento excede el tamaño maximo permitido, por favor solo documentos menores a 5 Mb.'+
										'</div>'+
								  '</div>').show();
			}
		}else{
			del_input_doc_all_formats();
			$('#message').html('<div class="col-sm-12">'+
									'<div class="alert alert-danger">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="close">'+
											'<span aria-hidden="true">&times;</span>'+
										'</button>'+
										'Formato de documento incorrecto, solo documentos '+info+' valor encontrado.'+
									'</div>'+
							  '</div>').show();
		}
	}
}

function click_search_several(){
	$('#file_div').append('<div class="row" align="center" id="div_file'+file+'" style="margin-bottom:15px;BORDER: 1px solid;border-radius: 15px;padding-top: 15px;padding-bottom: 15px;" >'+
							  	'<div class="col-sm-6">'+
									'<span id="span_iput_file'+file+'" >'+
										'<input type="text" id="evidencia_inicial'+file+'" name="evidencia_inicial'+file+'" value="" style="display:none;" >'+
										'<input type="file" id="evidencia'+file+'" name="evidencia[]" class="form-control" onchange="mostrar_doc_several(event,[\'pdf\',\'png\',\'jpg\',\'jpeg\',\'bmp\',\'txt\',\'csv\',\'xls\',\'xlsx\',\'docx\',\'mp3\'],'+file+')" accept=".pdf, .png, .jpg, .jpeg, .bmp, .txt, .csv, .xls, .xlsx, .docx, .mp3" style="display:none" >'+
									'</span>'+

									'<span id="doc_evidencia'+file+'">'+
										'<img style="width:100%;border: 1px solid gray;" title="Error" src="https://cdn2.iconfinder.com/data/icons/documents-and-files-v-2/100/doc-03-512.png">'+
									'</span>'+
								'</div>'+
								'<div class="col-sm-6" style="margin-top: 12px;">'+
									'<div class="form-group">'+
										'<a class="btn btn-alert" style="border-radius: 22px" onclick="del_input_doc_several('+file+')" ><span class="glyphicon glyphicon-trash"></span> </a>'+
									'</div>'+
								'</div>'+
							'</div>');
	document.getElementById('evidencia'+file).click();
	file++;
}

function mostrar_doc_several(event,formatos,n){
	$('#message').html('');
	if(event.target.files.length == 1){
		var file = event.target.files[0];
		var filename = file.name;
		var size = ((file.size / 1024) / 1024);
		
		var t = filename.toString().length;
		var formato = (filename.split('.').pop()).toLowerCase();
		
		var cumple = false;
		var info = '';

		for(var i = 0;i < formatos.length;i++)
		{
			if(formatos[i] == formato)
			{
				cumple = true;
			}

			if(info != '')
			{
				if(i == (formatos.length - 1))
				{
					info += ' y ';
				}
				else
				{
					info += ', ';
				}
			}

			info += formatos[i];
		}

		if(cumple)
		{
			if(size <= 5)
			{
				var reader = new FileReader();

				reader.onload = function(event)
				{					
					if(formato == "pdf" || formato == "txt" || formato == "csv" || formato == "xls" || formato == "xlsx" || formato == "docx"){
						$("#doc_evidencia"+n).html('<a target="_blank" href="'+event.target.result+'" ><span class="glyphicon glyphicon-file fa-5x">'+n+'</span></a>');
						$("#evidencia_inicial"+n).val('');
					}else{
						if(formato == "mp3"){
							$("#doc_evidencia"+n).html('<a target="_blank" href="'+event.target.result+'" ><span class="glyphicon glyphicon-volume-up fa-5x">'+n+'</span></a>');
							$("#evidencia_inicial"+n).val('');
						}else{
							$("#doc_evidencia"+n).html('<a target="_blank" href="'+event.target.result+'" ><img style="width:17%;border: 1px solid gray;" title="Documento" src="'+event.target.result+'" ><span style="font-size: 5em;">'+n+'</span></a>');
							$("#evidencia_inicial"+n).val('');
						}
					}	
				};
				reader.readAsDataURL(file);
			}else{
				del_input_doc_several(n);
				$('#message').html('<div class="col-sm-12">'+
										'<div class="alert alert-danger">'+
											'<button type="button" class="close" data-dismiss="alert" aria-label="close">'+
												'<span aria-hidden="true">&times;</span>'+
											'</button>'+
											'El documento excede el tamaño maximo permitido, por favor solo documentos menores a 5 Mb.'+
										'</div>'+
								  '</div>').show();
			}
		}else{
			del_input_doc_several(n);
			$('#message').html('<div class="col-sm-12">'+
									'<div class="alert alert-danger">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="close">'+
											'<span aria-hidden="true">&times;</span>'+
										'</button>'+
										'Formato de documento incorrecto, solo documentos '+info+' valor encontrado.'+
									'</div>'+
							  '</div>').show();
		}
	}
}

function del_input_doc_several(n){
	$("#div_file"+n).remove();
}

function obtain_list_resp_input(select_item, input,url_completa){
	url_data = url_completa.split("temas/search/formSearch");
	$.ajax({
		url: url_data[0]+'users/search/resp',
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value='todos'>Todos</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].name+" "+dataJson[i].last_name+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].name+" "+dataJson[i].last_name+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_clas_input(select_item, input,url_completa){
	url_data = url_completa.split("temas/search/formSearch");
	$.ajax({
		url: url_data[0]+'clasificaciones/search/clas',
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value='todos'>Todos</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].name+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].name+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_proj(select_item, url_2){
	$.ajax({
		url: url_2,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].name+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].name+"</option>"
				}
			}
			$("#data_search").html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_resp_input_dos(select_item, input,url){
	$.ajax({
		url: url,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].name+" "+dataJson[i].last_name+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].name+" "+dataJson[i].last_name+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_org_input(select_item, input, url){
	$.ajax({
		url: url,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].name+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].name+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_them_desp(select_item, input, url){
	$.ajax({
		url: url,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].descripcion+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].descripcion+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_class(select_item, input, url,input_origen){
    console.log(input_origen);
	var val = ($("#"+input_origen).val()).trim();
	val = val==""?0:val;
	$.ajax({
		url: url+'/search/'+val+'/datos',
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].name+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].name+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_sub_class(select_item, input, url,input_origen){
	var val = input_origen==""?0:input_origen;
	$.ajax({
		url: url+'/search/'+val+'/datos',
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].name+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].name+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_class_all(select_item, input, url){
	$.ajax({
		url: url,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].name+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].name+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_class_all_equipo(select_item, input, url){
	$.ajax({
		url: url,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].descripcion+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].descripcion+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_indice_all(select_item, input, url){
	$.ajax({
		url: url,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].name+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].name+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_seg(select_item, url_2){
	$.ajax({
		url: url_2,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Todos</option>";
			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i].seguimiento+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i].seguimiento+"</option>"
				}
			}
			$("#data_search").html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function obtain_list_data(select_item, input, url, field_select, field_cond){
	value_select = $("#"+field_cond).val();
	new_url = value_select==''?url:url.toString().replace("uno", value_select);
	$.ajax({
		url: new_url,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			select_info = "<option value=''>Seleccione</option>";

			for(i=0;i<cant;i++){
				if(select_item == dataJson[i].id){
					select_info += "<option value='"+dataJson[i].id+"' selected >"+dataJson[i][field_select]+"</option>"
				}else{
					select_info += "<option value='"+dataJson[i].id+"'>"+dataJson[i][field_select]+"</option>"
				}
			}
			$("#"+input).html(select_info);
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}

function print_data_infor(url, input){
	parametro = $("#"+input).val()==''?1:$("#"+input).val();
	fecha1 = $("#date_1").val();
	fecha2 = $("#date_2").val();
	select_search = $("#select_search").val();
	window.open(url+'/search/'+parametro+'/'+fecha1+'/'+fecha2+'/'+select_search+'/print', '_blank');
}

function create_referencia(url, datos){
	$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
	$("#title_modal").html("<b>Nueva Referencia Transversal</b>");
	$('#mediumModal').modal("show");
	$('#mediumBody').load(url, function(){
		$("#loading").html("");
		$("#input_datos").html('<input type="text" id="url" name="url" class="form-control" value="'+datos+'" style="display:none;">');
	}).show();
}

function load_inform(url){
	$("#loading").html("");
	$("#title_modal").html("<b>Informe</b>");
	$('#mediumModal').modal("show");
	$('#mediumBody').html(
		'<form action="javascript:generate_inform(\''+url+'\')" method="POST" >'+
			'<div class="row">'+
				'<div class="col-sm-12">'+
					'<div class="form-group">'+
						'<label><b> Filtro </b></label>'+
						'<select id="fecha_reunion" class="form-control" name="fecha_reunion"  required onchange="obtain_data_inform()">'+
							'<option value="1">Todo</option>'+
							'<option value="2">Rango Fecha inicio</option>'+
						'</select>'+
					'</div>'+
				'</div>'+

				'<div class="col-sm-6" id="div_fecha1" style="display:none;" >'+
					'<div class="form-group">'+
						'<label><b> Fecha 1 </b></label>'+
						'<input type="date" id="fecha1" class="form-control" name="fecha1" >'+
					'</div>'+
				'</div>'+
				'<div class="col-sm-6" id="div_fecha2" style="display:none;" >'+
					'<div class="form-group">'+
						'<label><b> Fecha 2 </b></label>'+
						'<input type="date" id="fecha2" class="form-control" name="fecha2" >'+
					'</div>'+
				'</div>'+
			'</div>'+
			'<div class="row">'+
				'<center>'+
					'<button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Generar</b></button>'+
					'<a type="button" class="btn btn-secondary" href="javascript:cerrar_ventana_medium()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Cerrar</b></a>'+
				'</center>'+
			'</div>'+
		'</form>'
	).show();
}

function obtain_data_inform(){
	var fecha_reunion = $("#fecha_reunion").val();
	if(fecha_reunion == 1){
		document.getElementById("fecha1").required = false;
		document.getElementById("fecha2").required = false;
		document.getElementById("div_fecha1").style.display = "none";
		document.getElementById("div_fecha2").style.display = "none";
	}else{
		document.getElementById("fecha1").required = true;
		document.getElementById("fecha2").required = true;
		document.getElementById("div_fecha1").style.display = "";
		document.getElementById("div_fecha2").style.display = "";
	}
}

function generate_inform(url){
    dato1 = ($("#fecha1").val() ==""?0:$("#fecha1").val());
	dato2 = ($("#fecha2").val() ==""?0:$("#fecha2").val());
	window.open(url+"/search/"+$("#fecha_reunion").val()+"/"+dato1+"/"+dato2+"/print", '_blank');
}

function load_inform_dos(url){
	$("#loading").html("");
	$("#title_modal").html("<b>Informe</b>");
	$('#mediumModal').modal("show");
	$('#mediumBody').html(
		'<form action="javascript:generate_inform_dos(\''+url+'\')" method="POST" >'+
			'<div class="row">'+
				'<div class="col-sm-12">'+
					'<div class="form-group">'+
						'<label><b> Filtro </b></label>'+
						'<select id="dato" class="form-control" name="dato"  required>'+
							'<option value="1">Todo</option>'+
							'<option value="2">Pendientes vencidas</option>'+
						'</select>'+
					'</div>'+
				'</div>'+
			'</div>'+
			'<div class="row">'+
				'<center>'+
					'<button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Generar</b></button>'+
					'<a type="button" class="btn btn-secondary" href="javascript:cerrar_ventana_medium()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Cerrar</b></a>'+
				'</center>'+
			'</div>'+
		'</form>'
	).show();
}

function generate_inform_dos(url){
	dato = $("#dato").val();
	window.open(url+"/search/"+dato+"/reporte", '_blank');
}

function full_users_asistentes(url){
	const whitelist = [];
	$.ajax({
		url: url,
		beforeSend: function() {
			$("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
		},
		success: function(result) {
			dataJson = eval(result);
			cant = dataJson.length;
			for(i=0;i<cant;i++){
				whitelist.push(dataJson[i].name);
			}

			// List
			let TagifyCustomListSuggestion = new Tagify(TagifyCustomListSuggestionEl, {
				whitelist: whitelist,
				maxTags: 1000, // allows to select max items
				dropdown: {
					maxItems: 20, // display max items
					classname: "", // Custom inline class
					enabled: 0,
					closeOnSelect: false
				}
			});
			$("#loading").html("");
		},
		complete: function() {
			$("#loading").html("");
		},
		error: function(jqXHR, testStatus, error) {
			console.log(error);
			$("#loading").html("");
		}
	})
}