@extends('layouts.app')

@section('libraries_add')
    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('seguimientos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" id="lia_page_seguimiento" onclick="loader_function()" >/Actividades</a>/Editar actividad {{ $seguimiento->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar actividad {{ $seguimiento->id }}</b></h1>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(Session::get('status'))
                <div class="alert alert-success">
                    {{Session::get('status')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div><br>

        <div class="col-sm-12">

            <form action="{{ route('seguimientos.update',['seguimiento'=>$seguimiento->id]) }}" method="POST" id="form_submit" name="form_submit" enctype="multipart/form-data" >
                @csrf
                @method('put')

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$data_search2}};{{$page}}" style="display:none;">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Compromiso </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <select name="tema_id" id="tema_id" class="form-control @error('tema_id') is-invalid @enderror" required >
                                <option value="" data-avance="0" data-ponde="0" data-ponderacion_propia="0" >Seleccione</option>
                                @foreach($temas->all() as $tema)
                                    @php 
                                        $cant_seg = count($tema->seguimientos);
                                        $suma_ponde = 0;
                                        $last_avance = 0;
                                        $iterator = 0;
                                        $ponderacion_propia = 0;
                                        foreach($tema->seguimientos as $ponde){
                                            $iterator++;
                                            $suma_ponde += $ponde->ponderacion;
                                            if($seguimiento->id == $ponde->id){
                                                $ponderacion_propia = $ponde->ponderacion;
                                            }
                                            if($cant_seg > $iterator){
                                                $last_avance = $ponde->avance;
                                            }
                                        }
                                    @endphp
                                    <option value="{{$tema->id}}" data-avance="{{ $last_avance }}" data-ponde="{{ $suma_ponde }}" data-ponderacion_propia="{{ $ponderacion_propia }}" >{{$tema->tema}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tag"><b> Descripción de la actividad </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="seguimiento" type="text" class="form-control @error('seguimiento') is-invalid @enderror" name="seguimiento" value="{{ $seguimiento->seguimiento }}" required >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-bookmark"><b> Estado seguimiento </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <select name="estado_id" id="estado_id" class="form-control @error('estado_id') is-invalid @enderror" required >
                                <option value="">Seleccione</option>
                                @foreach($estados->all() as $estado)
                                    <option value="{{$estado->id}}">{{$estado->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-bookmark"><b> Ponderación </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <input type="number" name="ponderacion" id="ponderacion" class="form-control" required value="{{ $seguimiento->ponderacion }}" onchange="recalcular_Ponderacion()" onkeyUp="recalcular_Ponderacion()" min="0" >
                            <span id="msg_ponderacion"></span>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha cumplimiento </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="fecha_cumplimiento" type="date" class="form-control @error('fecha_cumplimiento') is-invalid @enderror" name="fecha_cumplimiento" value="{{ $seguimiento->fecha_cumplimiento }}" required >
                        </div>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-dashboard	"><b> Avance </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="avance" type="number" class="form-control" name="avance" value="{{ $seguimiento->avance }}" required min="0" max="100" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-dashboard	"><b> Avance anterior</b></label>
                            <input type="number" class="form-control" id="last_avance" readonly="true" >
                        </div>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-12" >
                        <h4><b>Evidencia</b></h4>
                        <h5><b>Formatos aceptados: pdf, jpeg, png, jpg, bmp, docx, doc, xlsx, txt, csv, xls, mp3 </b></h5>
                    </div>

                    <div class="col-sm-6" >
                        <a class="btn btn-primary" onclick="click_search_several()" >
                            <span class="glyphicon glyphicon-search"></span><b> Buscar archivo </b>
                        </a>
                    </div>

                    <span id="message"></span> 

                    <div class="col-sm-12" style="margin-top: 25px;" id="div_registro_documento" >
                        <div class="row" align="center" id="file_div">
                            @php $cont=0; @endphp
                            @foreach($seguimiento->evidencias as $evidence)

                                @php 
                                    $cont++;
                                    $formato = explode(".", $evidence->evidencia);
                                @endphp
                                <div class="row" align="center" id="div_file{{$cont}}" style="margin-bottom:15px;" >
                                    <div class="col-sm-6">
                                        <span id="span_iput_file{{$cont}}" >
                                            <input type="text" id="evidencia_inicial{{$cont}}" name="evidencia_inicial[]" value="{{$evidence->evidencia}}" style="display:none;" >
                                            <input type="file" id="evidencia{{$cont}}" name="evidencia[]" class="form-control" onchange="mostrar_doc_several(event,['pdf','png','jpg','jpeg','bmp','txt','csv','xls','xlsx','docx','mp3'],{{$cont}})" accept=".pdf, .png, .jpg, .jpeg, .bmp, .txt, .csv, .xls, .xlsx, .docx, .mp3" style="display:none" >
                                        </span>
                                        <span id="doc_evidencia{{$cont}}">
                                            @if($formato[1] == "pdf" || $formato[1] == "txt" || $formato[1] == "csv" || $formato[1] == "xls" || $formato[1] == "xlsx" || $formato[1] == "docx")
                                                <a target="_blank" href="{{asset('evidencia/'.$evidence->evidencia)}}" ><span class="glyphicon glyphicon-file fa-5x">{{$cont}}</span></a>     
                                            @else
                                                @if($formato[1] == "mp3")
                                                    <a target="_blank" href="{{asset('evidencia/'.$evidence->evidencia)}}" ><span class="glyphicon glyphicon-volume-up fa-5x">{{$cont}}</span></a>      
                                                @else
                                                    <a target="_blank" href="{{asset('evidencia/'.$evidence->evidencia)}}" ><img style="width:17%;border: 1px solid gray;" title="Documento" src="{{asset('evidencia/'.$evidence->evidencia)}}" ><span style="font-size: 5em;">{{$cont}}</span></a>
                                                @endif
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-sm-6" style="margin-top: 12px;">
                                        <div class="form-group">
                                            <a class="btn btn-alert" style="border-radius: 22px" onclick="del_input_doc_several({{$cont}})" ><span class="glyphicon glyphicon-trash"></span> </a>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                            @php $cont++; @endphp
                        </div>
                    </div> 
                </div>
                <br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('seguimientos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_seguimiento_temas").className = "active";

        document.getElementById("lia_page_seguimiento").className = "li_drown";
        document.getElementById('lia_page_seguimiento').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        $("#tema_id").val("{{ $seguimiento->tema_id }}");
        $("#estado_id").val("{{ $seguimiento->estado_id }}");
        
        file = {{$cont}};
        
        $("#tema_id").change(function () {
            $("#last_avance").val($(this).find(':selected').data("avance"));
            
            recalcular_Ponderacion();
        });
        
        $("#last_avance").val($("#tema_id").find(':selected').data("avance"));
        
        function recalcular_Ponderacion(){
            ponderacion = $("#ponderacion").val()>0?$("#ponderacion").val():0;
            total_ponderacion = (parseInt(ponderacion)+ parseInt($("#tema_id").find(':selected').data("ponde")) - parseInt($("#tema_id").find(':selected').data("ponderacion_propia")));
            maximo_permitido = (100 - parseInt($("#tema_id").find(':selected').data("ponde")) + parseInt($("#tema_id").find(':selected').data("ponderacion_propia")));
            $("#msg_ponderacion").html("<b>Total Ponderación hasta el momento= "+total_ponderacion+"</b>");

            document.getElementById("ponderacion").setAttribute("max",maximo_permitido);
        }
        recalcular_Ponderacion();
    </script>
    
@endsection 