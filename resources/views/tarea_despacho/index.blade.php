    
    @extends('layouts.app')

    @section('libraries_add')
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
        <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('tema_despachos.index') }}" id="lia_page_tema_despacho" onclick="loader_function()" >/Reuniones</a><a href="{{ route('tarea_despachos.index') }}" id="lia_page_tarea_despacho" onclick="loader_function()" >/Seguimiento compromisos</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Seguimiento compromisos</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('tarea_despachos.index') }}" id="lia_page_tarea_despacho" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
            </div>
        </div><br>

        <div class="row">
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $tareas->total()}}" id="total" readonly>
                </div>
            </div>

            <form action="{{ route('tarea_despachos.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b><span class="glyphicon glyphicon-search"></span></b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-6" >
                            <select class="form-control" id="select_search" name="select_search" onchange="change_select()">
                                <option value="1">Descripción detallada del compromiso</option>
                                <option value="2">Fecha cumplimiento</option>
                                <option value="3">Reunión/compromiso</option>
                                <option value="4">Organismo</option>
                                <option value="5">Equipo</option>
                                <option value="6">Indice</option>
                                <option value="7">Clasificación</option>
                                <option value="8">Referencia transversal</option>
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
                        <th>Fecha cumplimiento</th>
                        <th>Responsable</th>
                        <th>Fecha programada de cumplimiento</th>
                        <th>Descripción detallada del compromiso</th>
                        <th>Avance</th>
                        <th>Estado</th>
                        <th>Alerta</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($tareas) <=0)
                        <tr>
                            <td align="center" colspan="7">No hay registros</td>
                        </tr>

                    @else
                        @php 
                            $date1 = new DateTime(date('Y-m-d'));
                        @endphp
                        
                        @foreach($tareas as $tarea)
                            <tr>
                                <td>{{ $tarea->id }}</td>
                                <td>{{ $tarea->tareas[0]->descripcion }}</td>
                                <td>{{ date("d/m/Y", strtotime($tarea->fecha_inicio)) }}</td>
                                
                                <td>
                                    @foreach($tarea->temas[0]->users as $user)
                                        {{$user->name}} {{$user->last_name}}<br> 
                                    @endforeach
                                </td>
                                
                                <td>{{ date("d/m/Y", strtotime($tarea->fecha_final)) }}</td>
                                <td>{{ $tarea->descripcion }}</td>
                                
                                <td>
                                    @php 
                                        $fecha_alerta_cumplimiento = ($tarea->temas[0]->estado_id==3?"\n".$tarea->temas[0]->fecha_alerta_cumplimiento:'');
                                        $cant = 0;
                                        foreach($tarea->temas[0]->seguimientos as $seguimiento){
                                            $cant = ($cant+(($seguimiento->avance * $seguimiento->ponderacion)/100));
                                        }
                                    @endphp

                                    {{$cant}} %
                                </td>
                                <td>{{ $tarea->temas[0]->estado_seguimientos[0]->name }}</td>

                                <td>
                                    @php        
                                        $date2 = new DateTime($tarea->temas[0]->fecha_cumplimiento);
                                        $dias_cant = ($date1->diff($date2))->format("%r%a");
                                    @endphp

                                    @if($tarea->temas[0]->estado_seguimientos[0]->id == 1 && $dias_cant > 15)
                                        <h6 style="color: blue;" ><b>A tiempo</b></h6>
                                    @endif

                                    @if($tarea->temas[0]->estado_seguimientos[0]->id == 1 && $dias_cant >= 0 && $dias_cant < 15)
                                        <h6 style="color: orange;" ><b>Próximo a vencer</b></h6>
                                    @endif

                                    @if($tarea->temas[0]->estado_seguimientos[0]->id == 1 && $dias_cant < 0)
                                        <h6 style="color: red;" ><b>Vencido</b></h6>
                                    @endif
                                    {{ date("d/m/Y", strtotime($fecha_alerta_cumplimiento)) }}
                                </td>

                                <td class="text-center" >
                                    @can('tarea_despachos.edit')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('tarea_despachos.edit',['tarea_despacho'=>$tarea->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" title="Editar" > <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> Actualizar compromiso</a><br>
                                    @endcan

                                    <!--@can('tarea_despachos.show')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('tarea_despachos.show',['tarea_despacho'=>$tarea->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" title="Editar" > <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span><span style="color:white;">....</span> Ver seguimiento<span style="color:white;">...................</span></a><br>
                                    @endcan-->

                                    @can('tarea_despachos.destroy')
                                        <a class="btn" style="margin-bottom: 5px;" href="javascript:confirmar_eliminar('¿ Desea eliminar el registro con id {{ $tarea->id }}','{{ route('tarea_despachos.confirmDelete',['id'=>$tarea->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}');" onclick="loader_function()" title="Eliminar"> <span style="font-size: 2em;" class="glyphicon glyphicon-trash"></span> <span style="color:white;">....</span>Eliminar compromiso<span style="color:white;">...</span></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $tareas->links() }}

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

            document.getElementById("lia_page_tarea_despacho").className = "li_drown";
            document.getElementById('lia_page_tarea_despacho').style.color = 'white';

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
                if(option == 2){
                    $("#input_search").html('<input type="date" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" >');
                }else{
                    if(option == 3){
                        $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                        
                        obtain_list_them_desp('{{$data_search}}','data_search',"{{ route('tema_despachos.search')}}");
                        
                        $(document).ready(function() {    
                            $('#data_search').select2({
                                placeholder: "Seleccione...",
                                allowClear: true,
                            });
                        });
                    }else{
                        if(option == 6){  //indice
                            $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                            
                            obtain_list_class_all('{{$data_search}}','data_search',"{{ route('indices.search') }}");

                            $(document).ready(function() {    
                                $('#data_search').select2({
                                    placeholder: "Seleccione...",
                                    allowClear: true,
                                });
                            });
                        }else{
                            if(option == 7){ //Clasificación
                                $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                            
                                obtain_list_class_all('{{$data_search}}','data_search',"{{ route('clasificaciones.search') }}");

                                $(document).ready(function() {    
                                    $('#data_search').select2({
                                        placeholder: "Seleccione...",
                                        allowClear: true,
                                    });
                                });

                            }else{
                                if(option == 8){  //Referencia transversal(subclasificaciones)
                                    $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                            
                                    obtain_list_class_all('{{$data_search}}','data_search',"{{ route('sub_clasificaciones.search_all') }}");

                                    $(document).ready(function() {    
                                        $('#data_search').select2({
                                            placeholder: "Seleccione...",
                                            allowClear: true,
                                        });
                                    });
                                }else{
                                    if(option == 4){  //Organismo
                                        $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                        
                                        obtain_list_class_all('{{$data_search}}','data_search',"{{ route('organismos.search') }}");

                                        $(document).ready(function() {    
                                            $('#data_search').select2({
                                                placeholder: "Seleccione...",
                                                allowClear: true,
                                            });
                                        });
                                    }else{
                                        if(option == 5){   //equipo
                                            $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                        
                                            obtain_list_class_all_equipo('{{$data_search}}','data_search',"{{ route('equipos.search') }}");

                                            $(document).ready(function() {    
                                                $('#data_search').select2({
                                                    placeholder: "Seleccione...",
                                                    allowClear: true,
                                                });
                                            });
                                        }else{
                                            $("#input_search").html('<input type="text" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" onkeydown="search_table(event)">');
                                        }                    
                                    }
                                    
                                }
                            }
                        }
                    }
                }
            }
            change_select();
        </script>
            
    @endsection