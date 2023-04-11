    
    @extends('layouts.app')

    @section('libraries_add')
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
        <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a>Compromisos</a><a href="{{ route('seguimientos.index') }}" id="lia_page_seguimiento" onclick="loader_function()" >/Actividades</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Listado de actividades</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('seguimientos.index') }}" id="lia_page_seguimiento" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
                @can('seguimientos.create')
                    <a class="btn btn-primary" href="{{ route('seguimientos.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()"><span class="glyphicon glyphicon-plus"></span> Nueva actividad</a>
                @endcan
            </div>
        </div><br>

        <div class="row">
            <form action="{{ route('seguimientos.index') }}" method="get" class="form-group col-sm-12" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b>Buscar</b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-4" >
                            <select class="form-control" id="select_search" name="select_search" onchange="change_select()">
                                <option value="1">Id</option>
                                <option value="2">Fecha</option>
                                <option value="3">Compromiso</option>
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
                    <input type="text" class="form-control text-center" value="{{ $seguimientos->total()}}" id="total" readonly>
                </div>
            </div>
        </div>

        <div class="">
            <table class="table table-responsive table-bordered tablas" id="tabla">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Actividad</th>
                        <th>Compromiso</th>
                        <th>Fecha cumplimiento</th>
                        <th>Estado</th>
                        <th>Ponderación</th>
                        <th>Avance</th>
                        <th>Alertas</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @if(count($seguimientos) <=0)
                        <tr>
                            <td align="center" colspan="12">No hay registros</td>
                        </tr>
                    @else
                        @php 
                            $date1 = new DateTime(date('Y-m-d'));
                        @endphp
                        
                        @foreach($seguimientos as $seguimiento)
                            <tr>
                                <td>{{ $seguimiento->id }}</td>
                                <td>{{ $seguimiento->seguimiento }}</td>
                                <td>{{ $seguimiento->temas[0]->tema }}</td>
                                <td>{{ $seguimiento->fecha_cumplimiento }}</td>
                                <td>{{ $seguimiento->estado_seguimientos[0]->name }}</td>

                                <td>{{ $seguimiento->ponderacion }}</td>
                                <td>{{ $seguimiento->avance }}</td>
                                <td>
                                    @php        
                                        $date2 = new DateTime($seguimiento->fecha_cumplimiento);
                                        $dias_cant = ($date1->diff($date2))->format("%r%a");
                                    @endphp

                                    @if($dias_cant > 15)
                                        <h6 style="color: blue;" ><b>A tiempo</b></h6>
                                    @endif

                                    @if($dias_cant > 0 && $dias_cant < 15)
                                        <h6 style="color: orange;" ><b>Próximo a vencer</b></h6>
                                    @endif

                                    @if($dias_cant == 0)
                                        <h6 style="color: red;" ><b>Vencido</b></h6>
                                    @endif
                                </td>

                                <td class="text-center" >
                                    @canany(['seguimientos.edit', 'seguimientos_assign_them.edit'])
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('seguimientos.edit',['seguimiento'=>$seguimiento->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" title="Actualizar"> <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> Actualizar actividad</a><br>
                                    @endcanany

                                    @can('seguimientos.show')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('seguimientos.show',['seguimiento'=>$seguimiento->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" title="Mostrar"> <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span> <span style="color:white;">......</span> Ver actividad<span style="color:white;">...............</span></a><br>
                                    @endcan

                                    @can('temas.show')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('temas.show',['tema'=>$seguimiento->tema_id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}&seg={{ $seguimiento->id }}" onclick="loader_function()" title="Mostrar compromiso" > <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span> <span style="color:white;">.....</span>Ver compromiso<span style="color:white;">.........</span></a><br>
                                    @endcan

                                    @can('actividades.create')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('actividades.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}&seguimiento={{ $seguimiento->id }}" onclick="loader_function()" title="Crear actividad" > <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span> <span style="color:white;">.......</span>Añadir tarea<span style="color:white;">..........</span></a><br>
                                    @endcan

                                    @canany(['actividades.index', 'actividades_assign_them.index'])
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('actividades.index') }}?select_search=3&data_search={{ $seguimiento->id }}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" title="Mostrar actividades" > <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span> <span style="color:white;">.......</span>Ver tarea<span style="color:white;">....................</span></a><br>
                                    @endcanany

                                    @canany(['seguimientos.destroy', 'seguimientos_assign_them.destroy'])
                                        <a class="btn" style="margin-bottom: 5px;" href="javascript:confirmar_eliminar('¿ Desea eliminar el registro con id {{ $seguimiento->id }}','{{ route('seguimientos.confirmDelete',['id'=>$seguimiento->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}');" onclick="loader_function()" title="Eliminar"> <span style="font-size: 2em;" class="glyphicon glyphicon-trash"></span> <span style="color:white;">...</span>Eliminar actividad<span style="color:white;">....</span></a>
                                    @endcanany
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $seguimientos->links() }}

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

            document.getElementById("lia_page_seguimiento").className = "li_drown";
            document.getElementById('lia_page_seguimiento').style.color = 'white';

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
                        obtain_list_them('{{$data_search}}',"{{ route('temas.search')}}");
                        
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