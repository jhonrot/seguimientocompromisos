var cant_temp = 0;

function obtain_inputs_mod_pres_enter(event,url){
    if(event.key == "Enter"){
        obtain_inputs_mod_pres(url)
    }
}

function obtain_inputs_mod_pres(url){
    var cantidad = $("#cantidad").val();
    if(cantidad > 0 && cantidad <=4){
        $.ajax({
            url: url,
            beforeSend: function() {
                $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
            },
            success: function(result) {
                dataJson = eval(result);
                cant = dataJson.length;

                select_info = '<select name="modalidad_id[]" id="modalidad_id" class="form-control @error(\'modalidad_id\') is-invalid @enderror" required ><option value="">Seleccione</option>';

                for(z=0;z<cant;z++){
                    select_info += "<option value='"+dataJson[z].id+"'>"+dataJson[z].tipo+"</option>"
                }
                select_info += "</select>";

                if(cantidad < cant_temp){
                    temp_cant = cant_temp;

                    while(temp_cant > cantidad){
                        $("#div_pres_mod_"+temp_cant).remove();
                        temp_cant--;
                    }
                    cant_temp = cantidad;
                }else{
                    if(cantidad > cant_temp){

                        var i=(cant_temp>0?parseInt(cant_temp):0);
                        
                        for(i;i<cantidad;i++){
                            $('#div_1').append('<div class="row" id="div_pres_mod_'+(i+1)+'">'+
                                                    '<div class="col-sm-6">'+
                                                        '<div class="form-group">'+
                                                            '<label class="glyphicon glyphicon-tasks"><b> Modalidad # '+(i+1)+'</b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>'+
                                                            select_info+
                                                        '</div>'+
                                                    '</div>'+
                
                                                    '<div class="col-sm-6">'+
                                                        '<div class="form-group">'+
                                                            '<label class="glyphicon glyphicon-usd"><b> Presupuesto modalidad # '+(i+1)+'</b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>'+

                                                              
                                                            '<input id="presupuesto_modalidad'+(i+1)+'_val" type="text" class="form-control" name="presupuesto_modalidad_val[]" required data-type="currency" placeholder="$ 1.000.000" minlength="3" maxlength="21" onkeyup="formatCurrency(2,this);" blur="formatCurrency(2,this, \'blur\');"        >'+
                                                            '<input id="presupuesto_modalidad'+(i+1)+'" type="number" class="form-control @error(\'presupuesto_modalidad\') is-invalid @enderror" name="presupuesto_modalidad[]" required min="1" style="display:none;" onchange="pres_check()" >'+

                                                            
                                                            
                                                        '</div>'+
                                                    '</div><br><br>'+
                                                '</div>');//'<input id="presupuesto_modalidad" type="number" class="form-control @error(\'presupuesto_modalidad\') is-invalid @enderror" name="presupuesto_modalidad[]" required min="1" onchange="pres_check()" >'+
                        }
                        cant_temp = cantidad;
                    }
                }
    
                document.getElementById("div_2").style.display = "";
                document.getElementById("div_3").style.display = "";
                document.getElementById("div_4").style.display = "";

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
    }else{
        alert("Atención.\n\nEl número de modalidades de contración debe ser minimo 1 y maximo 4");
    }
}

function pres_check(){
    var total = 0;
    var inputs_mp = document.querySelector('#div_1').querySelectorAll('.row').length;
    for(t=0;t<inputs_mp;t++){
        var inputs = (document.getElementsByName("presupuesto_modalidad[]")[t].value * 1);
        total = (total+parseInt(inputs));
    }
    var presupuesto_proyecto = parseInt(document.getElementById('presupuesto_proyecto').value);
    if(total == presupuesto_proyecto){
        $("#span_total").html("<b>Total presupuestos modalidades = $ </b><span style='color:green;'><b>"+(new Intl.NumberFormat('de-DE').format(total))+"</b></span>");
    }else{
        $("#span_total").html("<b>Total presupuestos modalidades = $ </b><span style='color:red;'><b>"+(new Intl.NumberFormat('de-DE').format(total))+"</b></span>");
    }
    /*document.getElementById("presupuesto_proyecto").min = total;
    document.getElementById("presupuesto_proyecto").max = total;*/
}


function obtain_execution(){
    socializacion = new Date($("#socializacion").val());
    año = socializacion.getFullYear();
    finalizacion = new Date(año, 11, 31);

    var months; 
    months = (finalizacion.getFullYear() - socializacion.getFullYear()) * 12; 
    months -= socializacion.getMonth();
    months += finalizacion.getMonth();
    months = months <= 0 ? 0 : months;

    document.getElementById("plazo").max = months;

    document.getElementById("publicacion").min = $("#socializacion").val();
}



document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("form_submit_paas").addEventListener('submit', validarFormulario_paas); 
  });
  
function validarFormulario_paas(evento) {
    evento.preventDefault();

    var proyecto_id = document.getElementById('proyecto_id').value;
    if(proyecto_id == "") {
        show_message_info('Proyecto inexistente, por favor refresque o vuelva al incio e intentelo de nuevo.','glyphicon glyphicon-remove','red');
        return;
    }

    var presupuesto_proyecto_val = document.getElementById('presupuesto_proyecto_val').value;
    if(presupuesto_proyecto_val.length < 3 || presupuesto_proyecto_val.length > 21) {
        show_message_info('El presupuesto del proyecto debe ser minimo $ 1 y maximo $ 999.999.999.999.999','glyphicon glyphicon-remove','red');
        return;
    }

    var presupuesto_proyecto = parseInt(document.getElementById('presupuesto_proyecto').value);
    if(presupuesto_proyecto < 1 || presupuesto_proyecto > 999999999999999) {
        show_message_info('El presupuesto del proyecto debe ser minimo $ 1 y maximo $ 999.999.999.999.999','glyphicon glyphicon-remove','red');
        return;
    }

    var cantidad = parseInt(document.getElementById('cantidad').value);
    if(cantidad < 1 || cantidad > 4) {
        show_message_info('El número de modalidades de contratación debe ser minimo 1 y maximo 4.','glyphicon glyphicon-remove','red');
        return;
    }

    var total = 0;
    var error_mod_pres = "";
    var error_mod_pres_val = "";
    var error_modalidad = "";
    var inputs_mp = document.querySelector('#div_1').querySelectorAll('.row').length;
    var stop_while = inputs_mp;
    for(t=0;t<inputs_mp;t++){
        var input_inicial_mod = document.getElementsByName("modalidad_id[]")[t].value;
        var condicion_while = (t+1);
        while(condicion_while < inputs_mp && stop_while > 0){
            if(input_inicial_mod == document.getElementsByName("modalidad_id[]")[condicion_while].value){
                error_modalidad = ""+(t+1);
                stop_while = 0;
            }
            condicion_while++;
        }

        var input_inicial = document.getElementsByName("presupuesto_modalidad[]")[t].value;
        var inputs = (input_inicial * 1);
        total = (total+parseInt(inputs));
        if(inputs < 1 || inputs > 999999999999999){
            error_mod_pres = ""+(t+1);
        }
        var input_inicial_text = document.getElementsByName("presupuesto_modalidad_val[]")[t].value;
        if(input_inicial_text.length < 3 || input_inicial_text.length > 21) {
            error_mod_pres_val = ""+(t+1);
        }
    }

    if(inputs_mp != cantidad){
        show_message_info('El Número de modalidades de contratación debe ser ingresado ('+cantidad+')','glyphicon glyphicon-remove','red');
        return;
    }

    if(error_mod_pres != ""){
        show_message_info('El presupuesto modalidad '+error_mod_pres+' debe ser minimo $ 1 y maximo $ 999.999.999.999.999','glyphicon glyphicon-remove','red');
        return;
    }

    if(error_mod_pres_val != ""){
        show_message_info('El presupuesto modalidad '+error_mod_pres_val+' debe ser minimo $ 1 y maximo $ 999.999.999.999.999','glyphicon glyphicon-remove','red');
        return;
    }

    if(error_modalidad != ""){
        show_message_info('La modalidad por presupuesto '+error_modalidad+' ya existe, debe ser única','glyphicon glyphicon-remove','red');
        return;
    }

    if(total != presupuesto_proyecto){
        pres_check();
        show_message_info('El presupuesto del proyecto debe ser igual a la suma del presupuesto de las modalidades.','glyphicon glyphicon-remove','red');
        return;
    }

    var socializacion = document.getElementById('socializacion').value;
    if(socializacion == "") {
        show_message_info('La  fecha de socialización es requerida.','glyphicon glyphicon-remove','red');
        return;
    }

    var plazo = parseInt(document.getElementById('plazo').value);
    if(plazo < 1) {
        show_message_info('El plazo ejecución fisica del proyecto (meses) debe ser mayor a 1.','glyphicon glyphicon-remove','red');
        return;
    }

    var publicacion = document.getElementById('publicacion').value;
    if(publicacion == "") {
        show_message_info('La fecha de publicación en página PAA es requerida.','glyphicon glyphicon-remove','red');
        return;
    }

    var id_paa = parseInt(document.getElementById('id_paa').value);
    if(id_paa < 1) {
        show_message_info('El Consecutivo PAA (Id) debe ser minimo 1.','glyphicon glyphicon-remove','red');
        return;
    }
    this.submit();
    $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");
}