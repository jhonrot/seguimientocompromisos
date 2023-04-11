    
    @extends('layouts.app')

    @section('libraries_add')
        <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('planes.index') }}" id="lia_page_planes" onclick="loader_function()" >/Actividades</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Plan de trabajo</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('planes.index') }}" id="lia_page_planes" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
                @can('planes.create')
                    <a class="btn btn-primary" href="{{ route('planes.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"><span class="glyphicon glyphicon-plus"></span> Nuevo actividad</a>
                @endcan
            </div>
        </div><br>

        <div class="row">
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $planes->total()}}" id="total" readonly>
                </div>
            </div>
 
            <form action="{{ route('planes.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b>Buscar</b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-6" >
                            <select class="form-control" id="select_search" name="select_search" >
                                <option value="1">Id</option>
                                <option value="2">Actividad</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" onkeydown="search_table(event)">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table  table-bordered tablas" id="tabla">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Obligación<br>contractual</th>
                        <th>Actividad</th>
                        <th>Meta de la<br>actividad</th>
                        <th>Indicador</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($planes) <=0)
                        <tr>
                            <td align="center" colspan="8">No hay registros</td>
                        </tr>
                    @else
                        @foreach($planes as $plan)
                            <tr>
                                <td>{{ $plan->id }}</td>
                                <td>{{ $plan->obligaciones[0]->obligacion }} </td>
                                <td>{{ $plan->actividad }} </td>
                                <td>{{ $plan->meta }} </td>
                                <td>{{ $plan->indicador }} </td>
                                <td>{{ $plan->unidad }} </td>
                                <td>{{ $plan->cantidad }} </td>
                                <td class="text-center" >
                                    @can('planes.edit')
                                        <a class="btn" href="{{ route('planes.edit',['plane' => $plan->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"> <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> Actualizar actividad</a><br>
                                    @endcan

                                    @can('planes.show')
                                        <a class="btn" href="{{ route('planes.show',['plane' => $plan->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"> <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> <span style="color:white;">....</span>Ver actividad<span style="color:white;">...................</span></a><br>
                                    @endcan

                                    @can('tareas.create')
                                        <a class="btn" href="{{ route('tareas.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&actividad={{$plan->id}}" onclick="loader_function()"> <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> <span style="color:white;">....</span>Añadir tarea<span style="color:white;">...................</span></a><br>
                                    @endcan

                                    @can('planes.destroy')
                                        <a class="btn" style="margin-bottom: 5px;" href="javascript:confirmar_eliminar('¿ Desea eliminar el registro con id {{ $plan->id }}','{{ route('planes.confirmDelete',['id'=>$plan->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}');" onclick="loader_function()" title="Eliminar Actividad" > <span style="font-size: 2em;" class="glyphicon glyphicon-trash"></span> <span style="color:white;">..</span>Eliminar Actividad<span style="color:white;">......</span></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $planes->links() }}

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
            document.getElementById("li_plan").className = "active";

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
        </script>
            
    @endsection