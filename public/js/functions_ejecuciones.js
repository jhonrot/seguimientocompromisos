
function active_prorroga(id){
	option = document.getElementById(id).checked;
	if(option){
		document.getElementById("tiempo_prorroga").required = true;
		document.getElementById("fecha_prorroga").required = true;
		document.getElementById("div_prorroga").style.display = "";
	}else{
		$("#tiempo_prorroga").val('');
		$("#fecha_prorroga").val('');
		document.getElementById("tiempo_prorroga").required = false;
		document.getElementById("fecha_prorroga").required = false;
		document.getElementById("div_prorroga").style.display = "none";
	}
}

function calc_cierre_input(id){
	var fecha_cierre_proyecto = new Date($("#fecha_cierre_proyecto").val());
	var tiempo_prorroga = ($("#"+id).val()>0)?parseInt($("#"+id).val()):0;
	fecha_cierre_proyecto.setDate(fecha_cierre_proyecto.getDate() + tiempo_prorroga);

	mes_temp =((fecha_cierre_proyecto.getMonth()+1)<10?"0"+(fecha_cierre_proyecto.getMonth()+1):(fecha_cierre_proyecto.getMonth()+1));
	
	dia_temp = ((fecha_cierre_proyecto.getDate()+1)<10?"0"+(fecha_cierre_proyecto.getDate()+1):(fecha_cierre_proyecto.getDate()+1));

	fecha_temp = fecha_cierre_proyecto.getFullYear()+"-"+mes_temp+"-"+dia_temp;

	if(fecha_temp != "NaN-NaN-NaN"){
		$("#fecha_prorroga").val(fecha_temp);
		document.getElementById("fecha_prorroga").max = fecha_temp;
	}
}