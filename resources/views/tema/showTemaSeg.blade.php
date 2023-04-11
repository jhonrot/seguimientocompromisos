@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('seguimientos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" id="lia_page_seguimiento" onclick="loader_function()" >/Actividades</a>/Compromiso {{ $tema->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Compromiso {{ $tema->id }}</b></h1>
        </div>
    </div><br>

        <div class="col-sm-12">

            <form>

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$data_search2}};{{$page}};{{$seg}}" style="display:none;">
                
                <div class="row">
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Compromiso </b></label>
                            <input type="text" class="form-control" value="{{ $tema->tema }}"  readonly >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tags"><b> Estado </b></label>                       
                            <input type="text" class="form-control" value="{{ $tema->estado_seguimientos[0]->name }}" readonly >
                        </div>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> Indice </b></label>
                            <input type="text" class="form-control" value="{{ $tema->clasificaciones[0]->indices[0]->name }}" readonly >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-filter"><b> Clasificación </b></label>
                            <input type="text" class="form-control" value="{{ $tema->clasificaciones[0]->name }}" readonly >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tasks"><b> Referencia transversal </b></label>
                            @php
                                $ref = $tema->subclasificacion_id>0?$tema->sub_clasificaciones[0]->name:'';
                            @endphp
                            <input type="text" class="form-control" value="{{ $ref  }}" readonly >
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha cumplimiento </b></label>
                            <input type="date" class="form-control" value="{{ $tema->fecha_cumplimiento }}" readonly >
                        </div>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Hora </b></label>
                            <input type="time" class="form-control" value="{{ $tema->tareas_despachos[0]->hora }}" readonly >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tags"><b> Responsable </b></label>
                            @foreach($tema->users as $responsable)   
                                <input type="text" class="form-control" value="{{ $responsable->name}} {{ $responsable->last_name}} - {{ (isset($responsable->organismos[0]->name)?$responsable->organismos[0]->name:'No dispone de organismo') }}" readonly >
                            @endforeach             
                        </div>
                    </div>
                </div><br>
                
                <div class="row">  
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Descripción detallada del compromiso </b></label>
                            <textarea class="form-control" rows="4" readonly >{{ $tema->description }}</textarea>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12" >
                        <h4><b>Evidencia</b></h4>
                    </div>

                    <div class="col-sm-12" style="margin-top: 25px;" id="div_registro_documento" >
                        <div class="row" id="file_div">
                            @php $cont=0; @endphp
                            @foreach($tema->evidencias as $evidence)

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
                                </div>
                            @endforeach
                        </div>
                    </div>  
                </div><br><br>
                
                <div class="row">
                    <center>
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
    </script>
    
@endsection 