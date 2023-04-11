@extends('layouts.app')

@section('libraries_add')
    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    <link rel='stylesheet' href='https://unpkg.com/@yaireo/tagify/dist/tagify.css'>
    <style>
        .tagify {
            height:100%;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('tema_despachos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_tema_despacho" onclick="loader_function()" >/Reuniones</a>/Nueva reunión</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Nueva Reunión</b></h1>
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

            <form action="{{ route('tema_despachos.store') }}" method="POST" id="form_submit" name="form_submit" enctype="multipart/form-data" >
                @csrf

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" style="display:none;">
                     
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tag"><b> Fecha de inicio </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input type="date" id="fecha_reunion" class="form-control @error('fecha_reunion') is-invalid @enderror" name="fecha_reunion"  required value="{{ old('fecha_reunion') }}" >
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tag"><b> Hora de la reunión </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input type="time" id="hora_reunion" class="form-control @error('hora_reunion') is-invalid @enderror" name="hora_reunion"  required value="{{ old('hora_reunion') }}" >
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tag"><b> Estado reunión </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror" required >
                                <option value="">Seleccione</option>
                                <option value="1">Programado</option>
                                <option value="2">Pendiente</option>
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Tema de la reunión </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" minlength="3" maxlength="200" rows="4" required onkeyup="validar_cant_caracteres(200,'descripcion','msg_descripcion')">{{ old('descripcion') }}</textarea>
                            <span id="msg_descripcion"></span>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-filter"><b> Objetivo de la reunión </b></label>
                            <textarea id="objetivo" class="form-control @error('objetivo') is-invalid @enderror" name="objetivo"  minlength="3" maxlength="200" rows="4" onkeyup="validar_cant_caracteres(200,'objetivo','msg_objetivo')" >{{ old('objetivo') }}</textarea>
                            <span id="msg_objetivo"></span>
                        </div>
                    </div>
  
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-king"><b> Asistentes </b></label>
                            <textarea id="asistentes" class="form-control @error('asistentes') is-invalid @enderror" name="asistentes"  minlength="3" maxlength="1000" rows="4" >{{ old('asistentes') }}</textarea>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tag"><b> Orden del día </b></label>
                            <textarea id="orden" class="form-control @error('orden') is-invalid @enderror" name="orden" minlength="3" maxlength="200" rows="4" onkeyup="validar_cant_caracteres(200,'orden','msg_orden')" >{{ old('orden') }}</textarea>
                            <span id="msg_orden"></span>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-info-sign"><b> Desarrollo de la reunión </b></label>
                            <textarea id="desarrollo" class="form-control @error('desarrollo') is-invalid @enderror" name="desarrollo" minlength="3" maxlength="11000" rows="4" onkeyup="validar_cant_caracteres(11000,'desarrollo','msg_desarrollo')" >{{ old('desarrollo') }}</textarea>
                            <span id="msg_desarrollo"></span>
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
                        <div class="row" align="center" id="file_div"></div>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('tema_despachos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>
	
	<script src='https://unpkg.com/@yaireo/tagify'></script>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_despachos").className = "active";

        document.getElementById("lia_page_tema_despacho").className = "li_drown";
        document.getElementById('lia_page_tema_despacho').style.color = 'white';
        
        $("#estado").val("{{ old('estado') }}");

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });
        
        const TagifyCustomListSuggestionEl = document.querySelector("#asistentes");

        full_users_asistentes("{{ route('users_asistentes.search') }}");
    </script>
    
@endsection 