    
    @extends('layouts.app')

    @section('libraries_add')
        <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('proyectos.index') }}" id="lia_page_proyecto" onclick="loader_function()" >/Proyectos</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Listado de Proyectos</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('proyectos.index') }}" id="lia_page_proyecto" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
                @can('proyectos.create')
                    <a class="btn btn-primary" href="{{ route('proyectos.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"><span class="glyphicon glyphicon-plus"></span> Nuevo proyecto</a>
                @endcan
            </div>
        </div><br>

        <div class="row">
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $projs->total()}}" id="total" readonly>
                </div>
            </div>

            <form action="{{ route('proyectos.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b>Buscar</b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-6" >
                            <select class="form-control" id="select_search" name="select_search" onchange="change_select()">
                                <option value="1">Nombre del proyecto</option>
                                <option value="2">BP</option>
                                <option value="3">Nombre del organismos</option>
                                <option value="4">Nombre del responsable</option>
                            </select>
                        </div>
                        <div class="col-sm-6" id="input_search">
                            <input type="text" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" onkeydown="search_table(event)">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive table-striped">
            <table class="table table-bordered tablas" id="tabla">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Código organismo</th>
                        <th>Nombre organismo</th>
                        <th>BP</th>
                        <th>Nombre proyecto</th>
                        <th>Responsable</th>
                        <th>Comuna</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($projs) <=0)
                        <tr>
                            <td align="center" colspan="7">No hay registros</td>
                        </tr>
                    @else
                        @foreach($projs as $proj)
                            <tr>
                                <td>{{ $proj->id }}</td>
                                <td>{{ $proj->organismo_id }}</td>
                                <td>{{ $proj->organismos[0]->name }}</td>
                                <td>{{ $proj->bp }}</td>
                                <td>{{ $proj->name }}</td>
                                <td>{{ $proj->responsables[0]->name }} {{ $proj->responsables[0]->last_name }}</td>
                                <td>{{ $proj->comunas[0]->name }}</td>
                                <td class="text-center" >
                                    @canany(['proyectos.edit', 'proyectos_assig.edit'])
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('proyectos.edit',['proyecto'=>$proj->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" title="Editar proyecto" > <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> <span style="color:white;">.....</span>Editar proyecto<span style="color:white;">.............</span></a><br>
                                    @endcanany

                                    @can('paas.create')
                                        @if(count($proj->presupuestos) == 0)
                                            <a class="btn" style="margin-bottom: 5px;" href="{{ route('paas.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&proj={{$proj->id}}&bp={{$proj->bp}}&place=1" onclick="loader_function()" title="PAA" > <span style="font-size: 2em;" class="glyphicon glyphicon-info-sign"></span> <span style="color:white;">.....</span>Información PAA<span style="color:white;">.............</span></a><br>
                                        @endif
                                    @endcan

                                    @can('contractuals.create')
                                        @php $cant_precon = isset($proj->cdps[0]->precontractuales)?count($proj->cdps[0]->precontractuales):0;@endphp
                                        @if($cant_precon == 0)
                                            <a class="btn" style="margin-bottom: 5px;" href="{{ route('precontractuales.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&proj={{$proj->id}}&bp={{$proj->bp}}&place=1" onclick="loader_function()" title="Etapa precontractual" > <span style="font-size: 2em;" class="glyphicon glyphicon-calendar"></span> Etapa precontractual</a><br>
                                        @endif
                                    @endcan

                                    @can('ejecucions.create')
                                        @php 
                                            $cant_precon = isset($proj->cdps[0]->precontractuales)?count($proj->cdps[0]->precontractuales):0;
                                            $cant_exec = isset($proj->cdps[0]->precontractuales[0]->ejecuciones)?count($proj->cdps[0]->precontractuales[0]->ejecuciones):0;
                                        @endphp
                                        
                                        @if($cant_precon > 0 && $cant_exec == 0)
                                            <a class="btn" style="margin-bottom: 5px;" href="{{ route('ejecuciones.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&proj={{$proj->id}}&bp={{$proj->bp}}&place=1&pre={{$proj->cdps[0]->precontractuales[0]->id}}" onclick="loader_function()" title="Etapa ejecución" > <span style="font-size: 2em;" class="glyphicon glyphicon-cog"></span> <span style="color:white;">.....</span>Etapa ejecución<span style="color:white;">.............</span></a><br>
                                        @endif
                                    @endcan

                                    @canany(['paas.index','contractuals.index','ejecucions.index'])
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('proyectos.registry') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&proj={{$proj->id}}" onclick="loader_function()" title="Ver registros" > <span style="font-size: 2em;" class="glyphicon glyphicon-search"></span> <span style="color:white;">.......</span>Ver registros<span style="color:white;">...................</span></a>
                                    @endcanany
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $projs->links() }}

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
            document.getElementById("li_seguimiento_proyectos").className = "active";

            document.getElementById("lia_page_proyecto").className = "li_drown";
            document.getElementById('lia_page_proyecto').style.color = 'white';

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
                if(option == 1 || option == 2){
                    $("#input_search").html('<input type="text" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" >');
                }else{
                    if(option == 3){//organismos
                        $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                        obtain_list_org_input('{{$data_search}}','data_search',"{{ route('organismos.search')}}");
                        
                        $(document).ready(function() {    
                            $('#data_search').select2({
                                placeholder: "Seleccione...",
                                allowClear: true,
                                width: 'resolve',
                            });
                        });
                    }else{
                        if(option == 4){//responsables
                            $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                            obtain_list_resp_input_dos('{{$data_search}}','data_search',"{{ route('users.search')}}");
                            
                            $(document).ready(function() {    
                                $('#data_search').select2({
                                    placeholder: "Seleccione...",
                                    allowClear: true,
                                    width: 'resolve',
                                });
                            });
                        }
                    }
                }
            }
            change_select();
        </script>
            
    @endsection