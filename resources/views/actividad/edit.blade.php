@extends('layouts.app')

@section('libraries_add')
    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('actividades.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" id="lia_page_actividad" onclick="loader_function()" >/Tareas</a>/Editar tarea {{ $actividad->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar tarea {{ $actividad->id }}</b></h1>
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

            <form action="{{ route('actividades.update',['actividade'=>$actividad->id]) }}" method="POST" id="form_submit" name="form_submit" enctype="multipart/form-data" >
                @csrf
                @method('put')

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$data_search2}};{{$page}}" style="display:none;">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-flag"><b> Descripción de la tarea </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="actividad" type="text" class="form-control @error('actividad') is-invalid @enderror" name="actividad" value="{{ $actividad->actividad }}" required >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Actividad </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <select name="seguimiento_id" id="seguimiento_id" class="form-control @error('seguimiento_id') is-invalid @enderror" required >
                                <option value="">Seleccione</option>
                                @foreach($seguimientos->all() as $seguimiento)
                                    <option value="{{$seguimiento->id}}">{{$seguimiento->seguimiento}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-bookmark"><b> Estado actividad </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
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
                            <label class="glyphicon glyphicon-calendar"><b> Fecha </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ $actividad->fecha }}" required autocomplete="fecha">
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Acciones adelantadas </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="acciones_adelantadas" class="form-control mayus @error('acciones_adelantadas') is-invalid @enderror" name="acciones_adelantadas" autocomplete="acciones_adelantadas" required minlength="4" maxlength="1000" rows="4" >{{ $actividad->acciones_adelantadas }}</textarea>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-dashboard"><b> Acciones Pendientes </b></label>
                            <textarea id="acciones_pendientes" class="form-control mayus @error('acciones_pendientes') is-invalid @enderror" name="acciones_pendientes" autocomplete="acciones_pendientes" minlength="4" maxlength="1000" rows="4" >{{ $actividad->acciones_pendientes }}</textarea>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-menu-down"><b> Dificultades presentadas </b></label>
                            <textarea id="dificultades" class="form-control mayus @error('dificultades') is-invalid @enderror" name="dificultades" autocomplete="dificultades" minlength="4" maxlength="1000" rows="4" >{{ $actividad->dificultades }}</textarea>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-menu-up"><b> Alternativas de solución </b></label>
                            <textarea id="alternativas" class="form-control mayus @error('alternativas') is-invalid @enderror" name="alternativas" autocomplete="alternativas" minlength="4" maxlength="1000" rows="4" >{{ $actividad->alternativas }}</textarea>
                        </div>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-menu-up"><b> Resultados obtenidos </b></label>
                            <textarea id="resultados" class="form-control mayus @error('resultados') is-invalid @enderror" name="resultados" minlength="4" maxlength="1000" rows="4" >{{ $actividad->resultados }}</textarea>
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
                            @foreach($actividad->evidencias as $evidence)

                                @php 
                                    $cont++;
                                    $formato = explode(".", $evidence->evidencia);
                                @endphp
                                <div class="row" align="center" id="div_file{{$cont}}" style="margin-bottom:15px;" >
                                    <div class="col-sm-6">
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
                            @php $cont++; @endphp
                        </div>
                    </div>   
                </div><br><br>
                
                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('actividades.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
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

        $("#seguimiento_id").val("{{ $actividad->seguimiento_id }}");
        $("#estado_id").val("{{ $actividad->estado_id }}");

        file = {{$cont}};

        if("{{ $cont }}" != "0"){
            document.getElementById("div_registro_documento").style.display = "";
        }
    </script>
    
@endsection 