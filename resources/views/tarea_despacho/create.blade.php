@extends('layouts.app')

@section('libraries_add')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('tema_despachos.index') }}??select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_tarea_despacho" onclick="loader_function()" >/Reuniones</a>/Nuevo compromiso</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Nuevo compromiso</b></h1>
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

            <form action="{{ route('tarea_despachos.store') }}" method="POST" id="form_submit" name="form_submit" enctype="multipart/form-data" >
                @csrf

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" style="display:none;">
                    
                <input type="text" id="tema_despacho_id" name="tema_despacho_id" class="form-control" value="{{$tema}}" style="display:none;">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Reunión </b></label>
                            <textarea class="form-control" rows="4" readonly >{{ $them[0]->descripcion }}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tag"><b> Fecha de la reunión </b></label>
                            <input type="date" class="form-control" value="{{ $them[0]->fecha_reunion }}" style="height: 97px;" readonly >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> Organismo </b></label>
                            <input type="text" class="form-control" value="{{ Auth::user()->organismos[0]->name }}" readonly >
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b style="font-size: 14px;" > Fecha cumplimiento </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input type="date" id="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio"  required value="{{ old('fecha_inicio') }}" >
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Hora </b></label>
                            <input type="time" id="hora" class="form-control @error('hora') is-invalid @enderror" name="hora" value="{{ old('hora') }}" >
                        </div>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> Equipos </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="equipo_id" id="equipo_id" class="form-control @error('equipo_id') is-invalid @enderror" required onchange="obtain_list_class('{{ old('indice_id') }}','indice_id','{{ route('indices.index') }}','equipo_id')" >
                                <option value="">Seleccione</option>
                                @foreach($equipos->all() as $equipo)
                                    <option value="{{$equipo->id}}">{{$equipo->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> Indice </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="indice_id" id="indice_id" class="form-control @error('indice_id') is-invalid @enderror" required onchange="obtain_list_class('{{ old('clasificacion_id') }}','clasificacion_id','{{ route('clasificaciones.index') }}','indice_id')" >
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-filter"><b> Clasificación </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="clasificacion_id" id="clasificacion_id" class="form-control @error('clasificacion_id') is-invalid @enderror" required >
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tasks"><b> Referencia transversal </b></label>
                            <select name="subclasificacion_id" id="subclasificacion_id" class="form-control @error('subclasificacion_id') is-invalid @enderror" >
                                <option value="">Seleccione</option>
                                @foreach($sub_clasificaciones->all() as $sub_clasificacion)
                                    <option value="{{$sub_clasificacion->id}}">{{$sub_clasificacion->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Fecha programada de cumplimiento </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input type="date" id="fecha_final" class="form-control @error('fecha_final') is-invalid @enderror" name="fecha_final"  required value="{{ old('fecha_final') }}" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tag"><b> Responsable </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="user_id[]" id="user_id" class="form-control js-example-basic-multiple @error('user_id') is-invalid @enderror" required multiple="multiple">
                                @foreach($responsables->all() as $responsable)
                                    <option value="{{$responsable->id}}"   {{ (collect(old('user_id'))->contains($responsable->id)) ? 'selected':'' }}       >{{$responsable->name}} {{$responsable->last_name}} - {{ (isset($responsable->organismos[0]->name)?$responsable->organismos[0]->name:'No dispone de organismo') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tag"><b> Compromiso </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="tema" class="form-control @error('tema') is-invalid @enderror" name="tema"  required minlength="3" maxlength="200" rows="4" onkeyup="validar_cant_caracteres(200,'tema','msg_tema')" >{{ old('tema') }}</textarea>
                            <span id="msg_tema"></span>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tag"><b> Descripción detallada del compromiso </b></label>
                            <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" minlength="3" maxlength="400" rows="4" onkeyup="validar_cant_caracteres(400,'descripcion','msg_descripcion')" >{{ old('descripcion') }}</textarea>
                            <span id="msg_descripcion"></span>
                        </div>
                    </div>
                </div><br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('tema_despachos.index') }}??select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>
	
	@if(Session::get('status'))
        <script>
            $(window).on('load', function(){
                show_message_wait('{{Session::get('status')}}');
            });
        </script>
    @endif

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_despachos").className = "active";

        document.getElementById("lia_page_tema_despacho").className = "li_drown";
        document.getElementById('lia_page_tema_despacho').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        $("#equipo_id").val("{{ old('equipo_id') }}");

        $("#subclasificacion_id").val("{{ old('subclasificacion_id') }}");

        obtain_list_class('{{ old('indice_id') }}','indice_id','{{ route('indices.index') }}','equipo_id');

        obtain_list_sub_class('{{ old('clasificacion_id') }}','clasificacion_id',
            '{{ route('clasificaciones.index') }}','{{ old('indice_id') }}');

        $(document).ready(function() {    
            $('#user_id').select2({
                placeholder: "Seleccione...",
                allowClear: true,
            });  
        });
    </script>
    
@endsection 