@extends('layouts.app')

@section('libraries_add')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('temas.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" id="lia_page_tema" onclick="loader_function()" >/Compromisos</a>/Editar compromiso {{ $tema->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar compromiso {{ $tema->id }}</b></h1>
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

            <form action="{{ route('temas.update',['tema'=>$tema->id]) }}" method="POST" id="form_submit" name="form_submit" enctype="multipart/form-data" >
                @csrf
                @method('put')

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$data_search2}};{{$page}}" style="display:none;">
                <input type="text" id="estado_id_initial" name="estado_id_initial" value="{{ $tema->estado_id }}" style="display:none;" >
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Compromiso </b></label>
                            <input id="tema" type="text" class="form-control @error('tema') is-invalid @enderror" name="tema" value="{{ $tema->tema }}" required autocomplete="descripcion" autofocus minlength="3" maxlength="200" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" readonly >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tags"><b> Estado </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <select name="estado_id" id="estado_id" class="form-control @error('estado_id') is-invalid @enderror" required >
                                <option value="">Seleccione</option>
                                @foreach($estados->all() as $estado)
                                    <option value="{{$estado->id}}">{{$estado->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> Organismo </b></label>
                            <input type="text" class="form-control" value="{{ $tema->equipo_id != null? $tema->equipos[0]->organismos[0]->name   :Auth::user()->organismos[0]->name }}" readonly >
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> Equipo </b></label>
                            <select name="equipo_id" id="equipo_id" class="form-control @error('equipo_id') is-invalid @enderror" required onchange="obtain_list_class('{{ old('indice_id') }}','indice_id','{{ route('indices.index') }}','equipo_id')" disabled >
                                <option value="">Seleccione</option>
                                @foreach($equipos->all() as $equipo)
                                    <option value="{{$equipo->id}}">{{$equipo->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> Indice </b></label>
                            <select name="indice_id" id="indice_id" class="form-control @error('indice_id') is-invalid @enderror" required onchange="obtain_list_class('{{ old('clasificacion_id') }}','clasificacion_id','{{ route('clasificaciones.index') }}','indice_id')" disabled >
                                <option value="{{$tema->clasificaciones[0]->indices[0]->id}}">{{$tema->clasificaciones[0]->indices[0]->name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-filter"><b> Clasificación </b></label>
                            <select name="clasificacion_id" id="clasificacion_id" class="form-control @error('clasificacion_id') is-invalid @enderror" required disabled >
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tasks"><b> Referencia transversal </b></label>
                            <select name="subclasificacion_id" id="subclasificacion_id" class="form-control @error('subclasificacion_id') is-invalid @enderror" disabled >
                                <option value="">Seleccione</option>
                                @foreach($sub_clasificaciones->all() as $sub_clasificacion)
                                    <option value="{{$sub_clasificacion->id}}">{{$sub_clasificacion->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha cumplimiento </b></label>
                            <input type="date" name="fecha_cumplimiento" id="fecha_cumplimiento" class="form-control" value="{{ $tema->fecha_cumplimiento }}" required disabled >
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
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tags"><b> Responsable </b></label>                       
                            <select name="user_id[]" id="user_id" class="form-control js-example-basic-multiple @error('user_id') is-invalid @enderror" required multiple="multiple" disabled >
                                @foreach($responsables->all() as $responsable)
                                    @php $cant_temas_asign = 0; $temas_asignados = ""; @endphp
                                    @foreach($responsable->temas as $temas_asign)
                                        @php $cant_temas_asign++; $temas_asignados .= "\n".$cant_temas_asign.". ".$temas_asign->descripcion; @endphp
                                    @endforeach
                                    <option value="{{$responsable->id}}" title="Cantidad de temas asignados: {{$cant_temas_asign}} {{$temas_asignados}}" {{ ($tema->users->contains($responsable->id)) ? 'selected':'' }}  >{{$responsable->name}} {{$responsable->last_name}} - {{ (isset($responsable->organismos[0]->name)?$responsable->organismos[0]->name:'No dispone de organismo') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>
                
                <div class="row">  
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Descripción detallada del compromiso </b></label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" minlength="4" maxlength="2000" rows="4" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" readonly >{{ $tema->description }}</textarea>
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
                            @foreach($tema->evidencias as $evidence)

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
                    
                </div>
                <br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('temas.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>
    
    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_seguimiento_temas").className = "active";

        document.getElementById("lia_page_tema").className = "li_drown";
        document.getElementById('lia_page_tema').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        $("#estado_id").val("{{ $tema->estado_id }}");

        if("{{ $tema->equipo_id }}" != null){
            $("#equipo_id").val("{{ $tema->equipo_id }}");
            obtain_list_class('{{$tema->clasificaciones[0]->indices[0]->id}}','indice_id','{{ route('indices.index') }}','equipo_id');
        }

        obtain_list_class('{{$tema->clasificacion_id}}','clasificacion_id','{{ route('clasificaciones.index') }}','indice_id');

        $("#subclasificacion_id").val("{{ $tema->subclasificacion_id }}");

        file = {{$cont}};

        $(document).ready(function() {    
            $('#user_id').select2({
                placeholder: "Seleccione...",
                allowClear: true,
            });
        });
    </script>
    
@endsection 