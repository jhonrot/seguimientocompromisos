    
    @extends('layouts.app')

    @section('libraries_add')
        <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('tema_despachos.index') }}" id="lia_page_tema_despacho" onclick="loader_function()" >/Reuniones</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Reuniones</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('tema_despachos.index') }}" id="lia_page_tema_despacho" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
                @can('tema_despachos.create')
                    <a class="btn btn-primary" href="{{ route('tema_despachos.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()"><span class="glyphicon glyphicon-plus"></span> Nueva reunión</a>
                @endcan
                
                <a class="btn btn-primary" href="javascript:load_inform('{{ route('tema_despachos.index') }}')" id="lia_page_tema" ><span class="glyphicon glyphicon-book"></span> Informe</a>
            </div>
        </div><br>

        <div class="row">
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $temas->total()}}" id="total" readonly>
                </div>
            </div>

            <form action="{{ route('tema_despachos.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b><span class="glyphicon glyphicon-search"></span></b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-6" >
                            <select class="form-control" id="select_search" name="select_search">
                                <option value="1">Tema de la reunión</option>
                                <option value="2">Objetivo de la reunión</option>
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
                        <th>Reunión</th>
                        <th>Fecha inicio</th>
                        <th>Objetivo reunión</th>
                        <th>Asistentes</th>
                        <th>Estado reunión</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($temas) <=0)
                        <tr>
                            <td align="center" colspan="8">No hay registros</td>
                        </tr>

                    @else
                        @foreach($temas as $tema)
                            <tr>
                                <td>{{ $tema->id }}</td>
                                <td>{{ $tema->descripcion }}</td>
                                <td>{{ date("d/m/Y", strtotime($tema->fecha_reunion)) }}</td>
                                <td>{{ $tema->objetivo }}</td>
                                <td>{{ $tema->asistentes }}</td>
                                <td>{{ ($tema->estado==1?'Programado':($tema->estado==2?'Pendiente':'')) }}</td>

                                <td class="text-center" >
                                    @canany(['tema_despachos.edit', 'tema_despachos_create.edit'])
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('tema_despachos.edit',['tema_despacho'=>$tema->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" title="Editar" > <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> Actualizar reunión<span style="color:white;">.......</span></a><br>
                                    @endcanany

                                    @can('tema_despachos.show')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('tema_despachos.show',['tema_despacho'=>$tema->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" title="Editar" > <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span><span style="color:white;">....</span> Ver reunión<span style="color:white;">........................</span></a><br>
                                    @endcan

                                    @can('tarea_despachos.create')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('tarea_despachos.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&tema={{$tema->id}}" onclick="loader_function()" title="Añadir"> <span style="font-size: 2em;" class="glyphicon glyphicon-plus"></span><span style="color:white;">..</span> Añadir compromiso<span style="color:white;">....</span></a><br>
                                    @endcan

                                    @can('tarea_despachos.index')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('tarea_despachos.index') }}?select_search=3&data_search={{$tema->id}}&page={{$page}}" onclick="loader_function()" > <span style="font-size: 2em;" class="glyphicon glyphicon-log-out"></span><span style="color:white;">...</span> Ver compromiso<span style="color:white;">...........</span></a><br>
                                    @endcan

                                    @canany(['tema_despachos.destroy', 'tema_despachos_create.destroy'])
                                        <a class="btn" style="margin-bottom: 5px;" href="javascript:confirmar_eliminar('¿ Desea eliminar el registro con id {{ $tema->id }}','{{ route('tema_despachos.confirmDelete',['id'=>$tema->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}');" onclick="loader_function()" title="Eliminar"> <span style="font-size: 2em;" class="glyphicon glyphicon-trash"></span> <span style="color:white;">....</span>Eliminar reunión<span style="color:white;">.......</span></a><br>
                                    @endcanany
                                    
                                    <a class="btn" style="margin-bottom: 5px;" target="_blank" href="{{ route('tema_despachos.print_data',['item1'=>3, 'item2'=>$tema->id, 'item3'=>0 ]) }}" id="lia_page_tema" ><span style="font-size: 2em;" class="glyphicon glyphicon-book"></span> <span style="color:white;">...</span> Informe <span style="color:white;">...............................</span></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $temas->links() }}

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
            document.getElementById("li_despachos").className = "active";

            document.getElementById("lia_page_tema_despacho").className = "li_drown";
            document.getElementById('lia_page_tema_despacho').style.color = 'white';

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