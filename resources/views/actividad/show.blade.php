@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('actividades.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" id="lia_page_actividad" onclick="loader_function()" >/Tareas</a>/Tarea {{ $actividad->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Tarea {{ $actividad->id }}</b></h1>
        </div>
    </div><br>

    <div class="row">

        <div class="col-sm-12">
            <div>
                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$data_search2}};{{$page}}" style="display:none;">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-flag"><b> Descripción de la tarea </b></label>
                            <input type="text" class="form-control" value="{{ $actividad->actividad }}" readonly >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Actividad </b></label>                       
                            <input type="text" class="form-control" value="{{ $actividad->seguimientos[0]->seguimiento }}" readonly >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-bookmark"><b> Estado actividad </b></label>                       
                            <input type="text" class="form-control" value="{{ $actividad->estado_seguimientos[0]->name }}" readonly >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha </b></label>
                            <input type="date" class="form-control" value="{{ $actividad->fecha }}" readonly >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Acciones adelantadas </b></label>
                            <textarea class="form-control" rows="4" readonly >{{ $actividad->acciones_adelantadas }}</textarea>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-dashboard"><b> Acciones Pendientes </b></label>
                            <textarea class="form-control" rows="4" readonly >{{ $actividad->acciones_pendientes }}</textarea>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-menu-down"><b> Dificultades presentadas </b></label>
                            <textarea class="form-control" rows="4" readonly >{{ $actividad->dificultades }}</textarea>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-menu-up"><b> Alternativas de solución </b></label>
                            <textarea class="form-control" rows="4" readonly>{{ $actividad->alternativas }}</textarea>
                        </div>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-menu-up"><b> Resultados obtenidos </b></label>
                            <textarea class="form-control" rows="4" readonly >{{ $actividad->resultados }}</textarea>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12" >
                        <h4><b>Evidencia</b></h4>
                    </div>

                    <span id="message"></span> 

                    <div class="col-sm-12" style="margin-top: 25px;" id="div_registro_documento" >
                        <div class="row" id="file_div">
                            @php $cont=0; @endphp
                            @foreach($actividad->evidencias as $evidence)

                                @php 
                                    $cont++;
                                    $formato = explode(".", $evidence->evidencia);
                                @endphp
                                <div class="row" id="div_file{{$cont}}" style="margin-bottom:15px;" >
                                    <div class="col-sm-12">
                                        <span id="span_iput_file{{$cont}}" >
                                            <input type="text" id="evidencia_inicial{{$cont}}" name="evidencia_inicial[]" value="{{$evidence->evidencia}}" style="display:none;" >'+
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
                        </div>
                    </div>   
                </div><br><br>
                
                <div class="row">
                    <center>
                        <a type="button" class="btn btn-secondary" href="{{ route('actividades.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </div>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_seguimiento_temas").className = "active";

        document.getElementById("lia_page_actividad").className = "li_drown";
        document.getElementById('lia_page_actividad').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });
    </script>
    
@endsection 