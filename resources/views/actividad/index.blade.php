    
@extends('layouts.app')

@section('libraries_add')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <a href="{{ route('actividades.index') }}" id="lia_page_actividad" onclick="loader_function()" >/Tareas</a>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Listado de tareas</b></h1>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <a class="btn btn-primary" href="{{ route('actividades.index') }}" id="lia_page_actividad" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
            @can('actividades.create')
                <a class="btn btn-primary" href="{{ route('actividades.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()"><span class="glyphicon glyphicon-plus"></span> Nueva tarea</a>
            @endcan
            <a class="btn btn-primary" href="{{ route('actividades.generate') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" id="lia_page_actividad" onclick="loader_function()" ><span class="glyphicon glyphicon-book"></span> Informe semanal</a>
        </div>
    </div><br>

    <div class="row">
        <form action="{{ route('actividades.index') }}" method="get" class="form-group col-sm-12" id="form_submit" name="form_submit">
            <div class="input-group">
                <span class="btn btn-primary input-group-addon" onclick="buscar()"><b>Buscar</b></span>
                <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                <div class="row">
                    <div class="col-sm-4" >
                        <select class="form-control" id="select_search" name="select_search" onchange="change_select()">
                            <option value="1">Id</option>
                            <option value="2">Fecha</option>
                            <option value="3">Actividad</option>
                            <option value="4">Rango fecha creación</option>
                        </select>
                    </div>
                    <div class="col-sm-4" id="input_search">
                        <input type="text" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" onkeydown="search_table(event)">
                    </div>
                    <div class="col-sm-4" id="input_search_2" style="display:none;">
                        <input type="date" class="form-control" id="data_search2" name="data_search2" value="{{$data_search2}}" >
                    </div>
                </div>
            </div>
        </form>

        <div class="form-group col-sm-12">
            <div class="input-group">
                <span class="input-group-addon"><b>Cantidad registros</b></span>
                <input type="text" class="form-control text-center" value="{{ $actividades->total()}}" id="total" readonly>
            </div>
        </div>
    </div>

    <div class="">
        <table class="table table-responsive table-bordered tablas" id="tabla">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tarea</th>
                    <th>Actividad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones adelantadas</th>
                    <th>Acciones pendientes</th>
                    <th>Dificultades presentadas</th>
                    <th>Alternativas de solución</th>
                    <th>Evidencia</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @if(count($actividades) <=0)
                    <tr>
                        <td align="center" colspan="10">No hay registros</td>
                    </tr>
                @else

                    @foreach($actividades as $actividad)
                        <tr>
                            <td>{{ $actividad->id }}</td>
                            <td>{{ $actividad->actividad }}</td>
                            <td>{{ $actividad->seguimientos[0]->seguimiento }}</td>
                            <td>{{ $actividad->fecha }}</td>
                            <td>{{ $actividad->estado_seguimientos[0]->name }}</td>
                            <td>{{ substr($actividad->acciones_adelantadas, 0, 20) }}...</td>
                            <td>{{ substr($actividad->acciones_pendientes, 0, 20) }}...</td>
                            <td>{{ substr($actividad->dificultades, 0, 20) }}...</td>
                            <td>{{ substr($actividad->alternativas, 0, 20) }}...</td>

                            <td>
                                @foreach($actividad->evidencias as $evidence)
                                    @php $formato = explode(".", $evidence->evidencia); @endphp

                                    @if($formato[1] == "pdf" || $formato[1] == "txt" || $formato[1] == "csv" || $formato[1] == "xls" || $formato[1] == "xlsx" || $formato[1] == "docx")
                                        <a target="_blank" href="{{asset('evidencia/'.$evidence->evidencia)}}" ><span class="glyphicon glyphicon-file">Documento</span></a><br>    
                                    @else
                                        @if($formato[1] == "mp3")
                                            <a target="_blank" href="{{asset('evidencia/'.$evidence->evidencia)}}" ><span class="glyphicon glyphicon-volume-up">Audio</span></a><br>     
                                        @else
                                            <a target="_blank" href="{{asset('evidencia/'.$evidence->evidencia)}}" ><span class="glyphicon glyphicon-film">Imagen</span></a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </td>

                            <td class="text-center" >
                                @canany(['actividades.edit', 'actividades_assign_them.edit'])
                                    <a class="btn" style="margin-bottom: 5px;" href="{{ route('actividades.edit',['actividade'=>$actividad->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" title="Actualizar"> <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> Actualizar tarea</a>
                                @endcanany

                                @can('actividades.show')
                                    <a class="btn" style="margin-bottom: 5px;" href="{{ route('actividades.show',['actividade'=>$actividad->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" title="Mostrar"> <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span> <span style="color:white;">......</span> Ver tarea<span style="color:white;">...............</span></a>
                                @endcan

                                @can('seguimientos.show')
                                    <a class="btn" style="margin-bottom: 5px;" href="{{ route('seguimientos.show',['seguimiento'=>$actividad->seguimiento_id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}&act={{ $actividad->id }}" onclick="loader_function()" title="Mostrar seguimiento" > <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span> <span style="color:white;">....</span>Ver actividad<span style="color:white;">.........</span></a>
                                @endcan

                                @canany(['actividades.destroy', 'actividades_assign_them.destroy'])
                                    <a class="btn" style="margin-bottom: 5px;" href="javascript:confirmar_eliminar('¿ Desea eliminar el registro con id {{ $actividad->id }}','{{ route('actividades.confirmDelete',['id'=>$actividad->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}');" onclick="loader_function()" title="Eliminar"> <span style="font-size: 2em;" class="glyphicon glyphicon-trash"></span> <span style="color:white;">...</span>Eliminar tarea<span style="color:white;">....</span></a>
                                @endcanany
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{ $actividades->links() }}

        @if(Session::get('status'))
            <script>
                $(window).on('load', function(){
                    show_message_wait('{{Session::get('status')}}');
                });
            </script>
        @endif
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

        function buscar(){
            document.getElementById('id_submit').click();
        }

        function search_table(event){
            if(event.key == "Enter"){
                document.getElementById('id_submit').click();
            }
        }

        $("#select_search").val("{{$select_search}}");

        function change_select(){
            option = $("#select_search").val();

            document.getElementById("input_search_2").style.display = "none";

            if(option == 2){
                $("#input_search").html('<input type="date" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" >');
            }else{
                if(option == 3){
                    $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                    obtain_list_seg('{{$data_search}}',"{{ route('seguimientos.search')}}");
                    
                    $(document).ready(function() {    
                        $('#data_search').select2({
                            placeholder: "Seleccione...",
                            allowClear: true,
                        });
                    });
                }else{
                    if(option == 4){
                        $("#input_search").html('<input type="date" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" >');
                        document.getElementById("input_search_2").style.display = "";
                    }else{
                        $("#input_search").html('<input type="text" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" onkeydown="search_table(event)">');
                    }
                }
            }
        }
        change_select();
    </script>
        
@endsection