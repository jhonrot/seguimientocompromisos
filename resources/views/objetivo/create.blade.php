@extends('layouts.app')

@section('libraries_add')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
@endsection>

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('objetivos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_objetivos" onclick="loader_function()" >/Objetivos</a>/Nuevo objetivo</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Nueva objetivo</b></h1>
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

            <form action="{{ route('objetivos.store') }}" method="POST" id="form_submit" name="form_submit">
                @csrf
                
                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" style="display:none;">

                <div class="row">
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Objetivo </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input type="text" id="objetivo" class="form-control @error('objetivo') is-invalid @enderror" name="objetivo" required minlength="4" maxlength="200" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" value="{{ old('objetivo') }}" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Proceso </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="proceso_id" id="proceso_id" class="form-control @error('proceso_id') is-invalid @enderror" required >
                                <option value="">Seleccione</option>
                                @foreach($procesos->all() as $proceso)
                                    <option value="{{$proceso->id}}">{{$proceso->proceso}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Usuarios </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="user_id[]" id="user_id" class="form-control js-example-basic-multiple @error('user_id') is-invalid @enderror" required multiple="multiple">
                                @foreach($responsables->all() as $responsable)
                                    <option value="{{$responsable->id}}"   {{ (collect(old('user_id'))->contains($responsable->id)) ? 'selected':'' }}       >{{$responsable->name}} {{$responsable->last_name}} - {{ (isset($responsable->organismos[0]->name)?$responsable->organismos[0]->name:'No dispone de organismo') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br><br>
                
                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('objetivos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_ajustes").className = "active";

        document.getElementById("lia_page_objetivos").className = "li_drown";
        document.getElementById('lia_page_objetivos').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        $("#proceso_id").val("{{ old('proceso_id') }}");

        $(document).ready(function() {    
            $('#user_id').select2({
                placeholder: "Seleccione...",
                allowClear: true,
            });  
        });
    </script>
    
@endsection 