@extends('layouts.app')

@section('libraries_add')
    <script type="text/javascript" src="{{asset('js/functions_ejecuciones.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('proyectos.index') }}?select_search={{$select_search2}}&data_search={{$data_search2}}&page={{$page2}}" id="lia_page_proyecto" onclick="loader_function()" >Proyectos</a>/<a href="{{ route('proyectos.registry') }}?select_search={{$select_search2}}&data_search={{$data_search2}}&page={{$page2}}&proj={{$proj}}" id="lia_page_proyecto" onclick="loader_function()" >Ver registros</a>/<a href="{{ route('ejecuciones.index') }}?select_search2={{$select_search2}}&data_search2={{$data_search2}}&page2={{$page2}}&place2={{$place}}&select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&proj={{$proj}}" id="lia_page_proyecto" onclick="loader_function()">Etapa ejecución</a>/Editar etapa ejecución {{ $ejec->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar Etapa ejecución {{ $ejec->id }}</b></h1>
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

            <form action="{{ route('ejecuciones.update',['ejecucione'=>$ejec->id]) }}" method="POST" id="form_submit" name="form_submit" enctype="multipart/form-data" >
                @csrf
                @method('put')

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}};{{$proj}};{{$bp}};{{$place}};{{$select_search2}};{{$data_search2}};{{$page2}}" style="display:none;">
                
                <input id="tiempo_etapa_contractual" type="number" class="form-control" name="tiempo_etapa_contractual" value="{{ $ejec->tiempo_etapa_contractual }}" required min="1" style="display:none;">

                <div class="row">
                    <input type="text" name="precontractual_id" id="precontractual_id" class="form-control" value="{{$ejec->id}}" required style="display:none;" >
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> BP </b></label>
                            <input type="text" id="bp" name="bp" class="form-control" value="{{$bp}}" readonly >
                        </div>
                    </div>
                </div><br>

                <div class="row">                
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha suscripción del contrato </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <input id="fecha_suscripcion_contrato" type="date" class="form-control @error('fecha_suscripcion_contrato') is-invalid @enderror" name="fecha_suscripcion_contrato" value="{{ $ejec->fecha_suscripcion_contrato }}" required onchange="calc_cierre()">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha socialización con contratista </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                     
                            <input id="fecha_socializacion_contratista" type="date" class="form-control @error('fecha_socializacion_contratista') is-invalid @enderror" name="fecha_socializacion_contratista" value="{{ $ejec->fecha_socializacion_contratista }}" required >
                        </div>
                    </div>
                </div><br>

                <div class="row">                
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Tiempo ejecución (meses) </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <input id="tiempo_ejecucion" type="number" class="form-control @error('tiempo_ejecucion') is-invalid @enderror" name="tiempo_ejecucion" value="{{ $ejec->tiempo_ejecucion }}" required min="1" onchange="calc_cierre()" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha cierre del proyecto </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                     
                            <input id="fecha_cierre_proyecto" type="date" class="form-control @error('fecha_cierre_proyecto') is-invalid @enderror" name="fecha_cierre_proyecto" value="{{ $ejec->fecha_cierre_proyecto }}" required >
                        </div>
                    </div>
                </div><br>

                <div class="row">                
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-question-sign"><b> ¿Requiere prorroga? </b></label>                       
                            <input id="prorroga" type="checkbox" class="form-control @error('prorroga') is-invalid @enderror" name="prorroga" value="1"    @if($ejec->prorroga == 1 ) checked @endif   onchange="active_prorroga('prorroga')" >
                        </div>
                    </div>
                </div><br>

                <div class="row" id="div_prorroga" style="display:none;">                
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Tiempo de prorroga (días) </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <input id="tiempo_prorroga" type="number" class="form-control @error('tiempo_prorroga') is-invalid @enderror" name="tiempo_prorroga" value="{{ $ejec->tiempo_prorroga }}" min="1" onchange="calc_cierre_input('tiempo_prorroga')" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha cierre del proyecto con prorroga </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                     
                            <input id="fecha_prorroga" type="date" class="form-control @error('fecha_prorroga') is-invalid @enderror" name="fecha_prorroga" value="{{ $ejec->fecha_prorroga }}" max="{{ date('Y').'-12-31' }}" >
                        </div>
                    </div>
                </div><br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('ejecuciones.index') }}?select_search2={{$select_search2}}&data_search2={{$data_search2}}&page2={{$page2}}&place2={{$place}}&select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&proj={{$proj}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
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

        function calc_cierre(){
            var fecha_suscripcion_contrato = new Date($("#fecha_suscripcion_contrato").val());
            var tiempo_ejecucion = ($("#tiempo_ejecucion").val()>0)?parseInt($("#tiempo_ejecucion").val()):0;
            fecha_suscripcion_contrato.setMonth(fecha_suscripcion_contrato.getMonth() + tiempo_ejecucion);
            mes_temp =((fecha_suscripcion_contrato.getMonth()+1)<10?"0"+(fecha_suscripcion_contrato.getMonth()+1):(fecha_suscripcion_contrato.getMonth()+1));
            dia_temp = ((fecha_suscripcion_contrato.getDate()+1)<10?"0"+(fecha_suscripcion_contrato.getDate()+1):(fecha_suscripcion_contrato.getDate()+1));
            
            fecha_temp = fecha_suscripcion_contrato.getFullYear()+"-"+mes_temp+"-"+dia_temp;
            $("#fecha_cierre_proyecto").val(fecha_temp);
            document.getElementById("fecha_cierre_proyecto").max = fecha_temp;

            document.getElementById("fecha_socializacion_contratista").min = $("#fecha_suscripcion_contrato").val();
        }
        calc_cierre();

        active_prorroga('prorroga');
        calc_cierre_input('tiempo_prorroga');
    </script>
    
@endsection 