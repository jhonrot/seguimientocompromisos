@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('tarea_despachos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_tarea_despacho" onclick="loader_function()" >/Seguimiento tareas</a>/Seguimiento tarea {{ $tarea->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Seguimiento tarea {{ $tarea->id }}</b></h1>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="glyphicon glyphicon-list-alt"><b> Fecha de asignación </b></label>
                <input type="date" id="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio"  required value="{{ $tarea->fecha_inicio }}" readonly >
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="glyphicon glyphicon-tag"><b> Responsable </b></label>
                <input type="text" id="responsable" class="form-control @error('responsable') is-invalid @enderror" name="responsable"  required minlength="3" maxlength="500" value="{{ $tarea->responsable }}" readonly >
            </div>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="glyphicon glyphicon-list-alt"><b> Fecha programada de cumplimiento </b></label>
                <input type="date" id="fecha_final" class="form-control @error('fecha_final') is-invalid @enderror" name="fecha_final"  required value="{{ $tarea->fecha_final }}" readonly >
            </div>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="glyphicon glyphicon-tag"><b> Descripción detallada del compromiso </b></label>
                <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"  required minlength="3" maxlength="1000" rows="4" readonly >{{ $tarea->descripcion }}</textarea>
            </div>
        </div>
    </div><br><br>

    <div class="row">
        <center>
            <a type="button" class="btn btn-secondary" href="{{ route('tarea_despachos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
        </center>
    </div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_despachos").className = "active";

        document.getElementById("lia_page_tarea_despacho").className = "li_drown";
        document.getElementById('lia_page_tarea_despacho').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });
    </script>
    
@endsection 