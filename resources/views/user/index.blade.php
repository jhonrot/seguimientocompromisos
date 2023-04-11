    
    @extends('layouts.app')

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('users.index') }}" id="lia_page_user" onclick="loader_function()" >/Usuarios</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Listado de Usuarios</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('users.index') }}" id="lia_page_user" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
                @can('users.create')
                    <a class="btn btn-primary" href="{{ route('users.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"><span class="glyphicon glyphicon-plus"></span> Nuevo usuario</a>
                @endcan
            </div>
        </div><br>

        <div class="row">
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $users->total()}}" id="total" readonly>
                </div>
            </div>
 
            <form action="{{ route('users.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b>Buscar</b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-6" >
                            <select class="form-control" id="select_search" name="select_search" >
                                <option value="1">Nombre</option>
                                <option value="2">Correo</option>
                                <option value="3">Cédula</option>
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
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Ingreso por logueo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($users) <=0)
                        <tr>
                            <td align="center" colspan="5">No hay registros</td>
                        </tr>
                    @else
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->num_document }}</td>
                                <td>{{ $user->name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                @if($user->state==1)
                                    <td>Activo</td>
                                @else
                                    <td>Inactivo</td>
                                @endif
                                <td class="text-center" >
                                    @can('users.edit')
                                        <a class="btn btn-primary" href="{{ route('users.edit',['user'=>$user->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"> <span class="glyphicon glyphicon-edit"></span></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $users->links() }}

        </div>

        <script>
            $(".li_base").removeClass("active");
            document.getElementById("li_entrada").className = "active";

            document.getElementById("lia_page_user").className = "li_drown";
            document.getElementById('lia_page_user').style.color = 'white';

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