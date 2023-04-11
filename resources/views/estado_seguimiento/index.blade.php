    
    @extends('layouts.app')

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('estado_seguimientos.index') }}" id="lia_page_estado_seguimientos" onclick="loader_function()" >/Estado seguimientos</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Listado de estado seguimientos</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('estado_seguimientos.index') }}" id="lia_page_estado_seguimientos" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
                @can('estado_seguimientos.create')
                    <a class="btn btn-primary" href="{{ route('estado_seguimientos.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"><span class="glyphicon glyphicon-plus"></span> Nuevo estado seguimiento</a>
                @endcan
            </div>
        </div><br>

        <div class="row">
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $est_segs->total()}}" id="total" readonly>
                </div>
            </div>
 
            <form action="{{ route('estado_seguimientos.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b>Buscar</b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-6" >
                            <select class="form-control" id="select_search" name="select_search" >
                                <option value="1">Id</option>
                                <option value="2">Nombre</option>
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
                        <th>Nombres</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($est_segs) <=0)
                        <tr>
                            <td align="center" colspan="3">No hay registros</td>
                        </tr>
                    @else
                        @foreach($est_segs as $est)
                            <tr>
                                <td>{{ $est->id }}</td>
                                <td>{{ $est->name }} </td>
                                <td class="text-center" >
                                    @can('estado_seguimientos.edit')
                                        <a class="btn btn-primary" href="{{ route('estado_seguimientos.edit',['estado_seguimiento' => $est->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"> <span class="glyphicon glyphicon-edit"></span></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $est_segs->links() }}

        </div>

        <script>
            $(".li_base").removeClass("active");
            document.getElementById("li_ajustes").className = "active";

            document.getElementById("lia_page_estado_seguimientos").className = "li_drown";
            document.getElementById( 'lia_page_estado_seguimientos' ).style.color = 'white';

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