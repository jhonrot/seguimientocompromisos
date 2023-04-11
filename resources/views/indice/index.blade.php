    
    @extends('layouts.app')

    @section('libraries_add')
        <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('indices.index') }}" id="lia_page_indices" onclick="loader_function()" >/Indices</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Listado de indices</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('indices.index') }}" id="lia_page_indices" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
                @can('indices.create')
                    <a class="btn btn-primary" href="{{ route('indices.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"><span class="glyphicon glyphicon-plus"></span> Nuevo indice</a>
                @endcan
            </div>
        </div><br>

        <div class="row">
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $indices->total()}}" id="total" readonly>
                </div>
            </div>
 
            <form action="{{ route('indices.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
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
                        <th>Equipo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($indices) <=0)
                        <tr>
                            <td align="center" colspan="3">No hay registros</td>
                        </tr>
                    @else
                        @foreach($indices as $indice)
                            <tr>
                                <td>{{ $indice->id }}</td>
                                <td>{{ $indice->name }} </td>
                                <td>{{ count($indice->equipos)>0?$indice->equipos[0]->descripcion:'' }} </td>
                                <td class="text-center" >
                                    @can('indices.edit')
                                        <a class="btn btn-primary" href="{{ route('indices.edit',['index' => $indice->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"> <span class="glyphicon glyphicon-edit"></span></a>
                                    @endcan

                                    @can('indices.destroy')
                                        <a class="btn btn-primary" href="javascript:confirmar_eliminar('¿ Desea eliminar el registro con id {{ $indice->id }}','{{ route('indices.confirmDelete',['id'=>$indice->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}');" onclick="loader_function()" title="Eliminar" > <span class="glyphicon glyphicon-trash"></span></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $indices->links() }}

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
            document.getElementById("li_ajustes").className = "active";

            document.getElementById("lia_page_indices").className = "li_drown";
            document.getElementById('lia_page_indices' ).style.color = 'white';

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