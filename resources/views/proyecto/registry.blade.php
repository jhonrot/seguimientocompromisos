    
    @extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            </p><a href="{{ route('proyectos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_proyecto" onclick="loader_function()" >/Proyectos</a>/Ver registros</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Registros</b></h1>
        </div>
    </div><br>

    <div class="row">
        @can('paas.index')
            <div class="col-sm-4" align="center" style="padding-bottom: 20px;" >
                <a class="btn btn-primary" href="{{ route('paas.index') }}?select_search2={{$select_search}}&data_search2={{$data_search}}&page2={{$page}}&place2=2&proj={{$proj}}" style="width: 100%;height: 80px;font-size: 65px !important;padding-top: 3px;" id="lia_page_proyecto" onclick="loader_function()" ><b>PAA</b></a>
            </div>
        @endcan

        @can('contractuals.index')
            <div class="col-sm-4" align="center" style="padding-bottom: 20px;" >
                <a class="btn btn-primary" href="{{ route('precontractuales.index') }}?select_search2={{$select_search}}&data_search2={{$data_search}}&page2={{$page}}&place2=2&proj={{$proj}}" style="width: 100%;height: 80px;font-size: 120% !important;padding-top: 5%" id="lia_page_proyecto" onclick="loader_function()" ><b>Precontractual</b></a>
            </div>
        @endcan

        @can('ejecucions.index')
            <div class="col-sm-4" align="center" style="padding-bottom: 20px;" >
                <a class="btn btn-primary" href="{{ route('ejecuciones.index') }}?select_search2={{$select_search}}&data_search2={{$data_search}}&page2={{$page}}&place2=2&proj={{$proj}}" style="width: 100%;height: 80px;font-size: 190% !important;padding-top: 3%;" id="lia_page_proyecto" onclick="loader_function()" ><b>Ejecución</b></a>
            </div>
        @endcan
    </div><br><br>

    <div class="row" align="center">
        <div class="col-sm-12" >
            <a class="btn btn-primary" href="{{ route('proyectos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_proyecto" onclick="loader_function()" ><b><span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar</b></a>
        </div>
    </div><br>


    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_seguimiento_proyectos").className = "active";

        document.getElementById("lia_page_proyecto").className = "li_drown";
        document.getElementById('lia_page_proyecto').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

    </script>
        
@endsection