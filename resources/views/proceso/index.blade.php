    
    @extends('layouts.app')

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('procesos.index') }}" id="lia_page_procesos" onclick="loader_function()" >/Procesos</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Listado de procesos</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('procesos.index') }}" id="lia_page_procesos" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
                @can('procesos.create')
                    <a class="btn btn-primary" href="{{ route('procesos.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"><span class="glyphicon glyphicon-plus"></span> Nuevo proceso</a>
                @endcan
            </div>
        </div><br>

        <div class="row">
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $procesos->total()}}" id="total" readonly>
                </div>
            </div>
 
            <form action="{{ route('procesos.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b>Buscar</b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-6" >
                            <select class="form-control" id="select_search" name="select_search" >
                                <option value="1">Id</option>
                                <option value="2">Proceso</option>
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
                        <th>Proceso</th>
                        <th>Descripción</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($procesos) <=0)
                        <tr>
                            <td align="center" colspan="4">No hay registros</td>
                        </tr>
                    @else
                        @foreach($procesos as $proceso)
                            <tr>
                                <td>{{ $proceso->id }}</td>
                                <td>{{ $proceso->proceso }} </td>
                                <td>{{ $proceso->descripcion }} </td>
                                <td class="text-center" >
                                    @can('procesos.edit')
                                        <a class="btn btn-primary" href="{{ route('procesos.edit',['proceso' => $proceso->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"> <span class="glyphicon glyphicon-edit"></span></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $procesos->links() }}

        </div>

        <script>
            $(".li_base").removeClass("active");
            document.getElementById("li_ajustes").className = "active";

            document.getElementById("lia_page_procesos").className = "li_drown";
            document.getElementById('lia_page_procesos').style.color = 'white';

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