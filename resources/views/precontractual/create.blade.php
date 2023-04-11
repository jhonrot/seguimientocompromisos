@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('proyectos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_proyecto" onclick="loader_function()" >Proyectos</a>/Etapa precontractual</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Programación etapa precontractual</b></h1>
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

            <form action="{{ route('precontractuales.store') }}" method="POST" id="form_submit" name="form_submit" >
                @csrf
                
                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}};{{$proj}};{{$bp}};{{$place}};{{$select_search2}};{{$data_search2}};{{$page2}}" style="display:none;">

                <input type="text" id="proyecto_id" name="proyecto_id" class="form-control" value="{{$proj}}" style="display:none;">

                <div class="row">    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> BP </b></label>
                            <input type="text" class="form-control" value="{{ $bp }}" readonly >
                        </div>
                    </div>
                </div><br>

                <div class="row">  
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tag"><b> Número CDP </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="cdp_numero" type="text" class="form-control @error('cdp_numero') is-invalid @enderror" name="cdp_numero" value="{{ old('cdp_numero') }}" required minlength="1" onkeypress="return soloNumeros(event)" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha expedición CDP </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <input id="fecha_expedicion" type="date" class="form-control @error('fecha_expedicion') is-invalid @enderror" name="fecha_expedicion" value="{{ old('fecha_expedicion') }}" required >
                        </div>
                    </div>
                </div><br>

                <div class="row">   
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-question-sign"><b> ¿Cuenta con PAC? </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="paac" id="paac" class="form-control @error('paac') is-invalid @enderror" required >
                                <option value="">Seleccione</option>
                                <option value="1">Si</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha aviso convocatoria </b></label>                       
                            <input id="fecha_convocatoria" type="date" class="form-control @error('fecha_convocatoria') is-invalid @enderror" name="fecha_convocatoria" value="{{ old('fecha_convocatoria') }}" >
                        </div>
                    </div>
                </div><br>

                <div class="row">                
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Aprobación análisis del sector </b></label>                       
                            <input id="fecha_aprobacion_asp" type="date" class="form-control @error('fecha_aprobacion_asp') is-invalid @enderror" name="fecha_aprobacion_asp" value="{{ old('fecha_aprobacion_asp') }}" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Aprobación estudios y documentos previos </b></label>                     
                            <input id="fecha_aprobacion_edp" type="date" class="form-control @error('fecha_aprobacion_edp') is-invalid @enderror" name="fecha_aprobacion_edp" value="{{ old('fecha_aprobacion_edp') }}" >
                        </div>
                    </div>
                </div><br>

                <div class="row">            
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Publicación proyecto pliego </b></label>                       
                            <input id="fecha_publicacion_contratacion" type="date" class="form-control @error('fecha_publicacion_contratacion') is-invalid @enderror" name="fecha_publicacion_contratacion" value="{{ old('fecha_publicacion_contratacion') }}" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> plazo estimado adjudicación </b></label>                       
                            <input id="plazo_adjudicacion" type="number" class="form-control @error('plazo_adjudicacion') is-invalid @enderror" name="plazo_adjudicacion" value="{{ old('plazo_adjudicacion') }}"  min="1" >
                        </div>
                    </div>
                </div><br>

                <div class="row">            
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha estimada adjudicación del proyecto </b></label>                       
                            <input id="fecha_adjudicacion" type="date" class="form-control @error('fecha_adjudicacion') is-invalid @enderror" name="fecha_adjudicacion" value="{{ old('fecha_adjudicacion') }}" >
                        </div>
                    </div>
                </div><br><br>
                
                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('proyectos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_seguimiento_proyectos").className = "active";

        document.getElementById("lia_page_proyecto").className = "li_drown";
        document.getElementById('lia_page_proyecto').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        cdp_numero.onpaste = function(event) {
            var text = event.clipboardData.getData('text/plain');
            event.preventDefault();
            copy_paste_number('cdp_numero',text,20);
        };
        $("#paac").val("{{ old('paac') }}");
        
    </script>
    
@endsection 