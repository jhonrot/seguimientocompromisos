    
    @extends('layouts.app')

    @section('libraries_add')
        <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('helps.index') }}" id="lia_page_help" onclick="loader_function()" >/Requerimientos</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Listado de Requerimientos</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('helps.index') }}" id="lia_page_help" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
                @can('helps.create')
                    <a class="btn btn-primary" href="{{ route('helps.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"><span class="glyphicon glyphicon-plus"></span> Nuevo requerimiento</a>
                @endcan
            </div>
        </div><br>

        <div class="row">
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $reqs->total()}}" id="total" readonly>
                </div>
            </div>

            <form action="{{ route('helps.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b>Buscar</b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-6" >
                            <select class="form-control" id="select_search" name="select_search" onchange="change_select()">
                                <option value="1">Tema</option>
                                <option value="2">Estado</option>
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
                        <th>Tema</th>
                        <th>Estado</th>
                        <th>Usuario creador</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($reqs) <=0)
                        <tr>
                            <td align="center" colspan="6">No hay registros</td>
                        </tr>
                    @else
                        @foreach($reqs as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ $req->tema }}</td>
                                <td>
                                    @if($req->state == 1)
                                        {{ 'Nuevo' }}
                                    @endif
                                    @if($req->state == 2)
                                        {{ 'Pendiente' }}
                                    @endif
                                    @if($req->state == 3)
                                        {{ 'Solucionado' }}
                                    @endif
                                </td>
                                <td>{{ $req->creator[0]->name }} {{ $req->creator[0]->last_name }}</td>
                                <td>{{ $req->created_at }}</td>

                                <td class="text-center" >
                                    @can('helps.edit')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('helps.edit',['help'=>$req->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" title="Editar" > <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> Actualizar</a>
                                    @endcan

                                    @can('helps.show')
                                        <!--<a class="btn" style="margin-bottom: 5px;" href="{{ route('helps.show',['help'=>$req->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" title="Mostrar" > <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span> Ver</a>-->
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $reqs->links() }}

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
            document.getElementById("li_help").className = "active";

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
                if(option == 1){
                    $("#input_search").html('<input type="text" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" >');
                }else{
                    $("#input_search").html('<select class="form-control" id="data_search" name="data_search" ><option value = "">Todos</option><option value = "1">Nuevo</option><option value = "2">Pendiente</option><option value = "3">Solucionado</option></select>');
                    $("#data_search").val("{{$data_search}}");
                }
            }
            change_select();
        </script>
            
    @endsection