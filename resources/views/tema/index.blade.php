    
    @extends('layouts.app')

    @section('libraries_add')
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
        <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('temas.index') }}" id="lia_page_tema" onclick="loader_function()" >/Compromisos</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Listado de Compromisos</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('temas.index') }}" id="lia_page_tema" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
                
                <a class="btn btn-primary" href="javascript:load_inform_dos('{{ route('temas.index') }}')" id="lia_page_tema" onclick="loader_function()" ><span class="glyphicon glyphicon-book"></span> Reporte</a>
            </div>
        </div><br>

        <div class="row">
            <form action="{{ route('temas.index') }}" method="get" class="form-group col-sm-12" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b><span class="glyphicon glyphicon-search"></span></b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-4" id="div_select_search" >
                            <select class="form-control" id="select_search" name="select_search" onchange="change_select()">
                                <option value="1">Compromiso</option>
                                <option value="2">Estado</option>
                                <option value="8">Organismo</option>
                                <option value="9">Equipo</option>
                                <option value="4">Indice</option>
                                <option value="5">Clasificación</option>
                                <option value="6">Referencia transversal</option>
                                <option value="7">Rango fecha creación</option>
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

            <div class="form-group col-sm-12" id="div_count_rows" >
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $temas->total()}}" id="total" readonly>
                </div>
            </div>
        </div>

        <div class="table-striped">
            <table class="table table-responsive table-bordered tablas" id="tabla">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Compromiso</th>
                        <th>Reunión</th>
                        <th>Asignado por</th>
                        <th>Responsable</th>
                        <th>Fecha cumplimiento</th>
                        <th>Avance</th>
                        <th>Estado</th>
                        <th>Alerta</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($temas) <=0)
                        <tr>
                            <td align="center" colspan="8">No hay registros</td>
                        </tr>
                    @else
                        @php 
                            $date1 = new DateTime(date('Y-m-d'));
                        @endphp
                        
                        @foreach($temas as $tema)
                            <tr>
                                <td>{{ $tema->id }}</td>
                                <td>{{ $tema->tema }}</td>
                                <td>{{ count($tema->tareas_despachos)>0?$tema->tareas_despachos[0]->tareas[0]->descripcion:'' }}</td>
                                
                                <td>
                                    @if(count($tema->asignador)> 0)
                                        {{ $tema->asignador[0]->name }} {{ $tema->asignador[0]->last_name}} 
                                    @endif
                                </td>
                                
                                <td>
                                    @foreach($tema->users as $user)
                                        {{$user->name}} {{$user->last_name}}<br> 
                                    @endforeach
                                </td>
                                <td>{{ date("d/m/Y", strtotime($tema->fecha_cumplimiento))  }}</td>

                                <td>
                                    @php 
                                        $fecha_alerta_cumplimiento = ($tema->estado_id==3?"\n".$tema->fecha_alerta_cumplimiento:'');
                                        $cant = 0;
                                        foreach($tema->seguimientos as $seguimiento){
                                            $cant = ($cant+(($seguimiento->avance * $seguimiento->ponderacion)/100));
                                        }
                                    @endphp

                                    {{$cant}} %
                                </td>

                                <td>{{ $tema->estado_seguimientos[0]->name }}</td>
                                <td>
                                    @php        
                                        $date2 = new DateTime($tema->fecha_cumplimiento);
                                        $dias_cant = ($date1->diff($date2))->format("%r%a");
                                    @endphp

                                    @if($tema->estado_seguimientos[0]->id == 1 && $dias_cant > 15)
                                        <h6 style="color: blue;" ><b>A tiempo</b></h6>
                                    @endif

                                    @if($tema->estado_seguimientos[0]->id == 1 && $dias_cant >= 0 && $dias_cant < 15)
                                        <h6 style="color: orange;" ><b>Próximo a vencer</b></h6>
                                    @endif

                                    @if($tema->estado_seguimientos[0]->id == 1 && $dias_cant < 0)
                                        <h6 style="color: red;" ><b>Vencido</b></h6>
                                    @endif
                                    {{$fecha_alerta_cumplimiento}}
                                </td>

                                <td class="text-center" >
                                    @canany(['temas.edit', 'temas_assign.edit'])
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('temas.edit',['tema'=>$tema->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" title="Editar compromiso" > <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> <span style="color:white;">....</span>Actualizar compromiso<span style="color:white;">....</span></a><br>
                                    @endcanany
                                    
                                    @can('seguimientos.create')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('seguimientos.create') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}&tema={{ $tema->id }}" onclick="loader_function()" title="Añadir actividad" ><span style="font-size: 2em;" class="glyphicon glyphicon-record"></span> <span style="color:white;">....</span>Añadir actividad<span style="color:white;">........................</span></a><br>
                                    @endcan

                                    @can('temas.show')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('temas.show',['tema'=>$tema->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" title="Mostrar compromiso" > <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span> <span style="color:white;">.......</span>Ver compromiso<span style="color:white;">.......................</span></a><br>
                                    @endcan

                                    @canany(['seguimientos.index', 'seguimientos_assign_them.index'])
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('seguimientos.index') }}?select_search=3&data_search={{ $tema->id }}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" title="Mostrar actividad" > <span style="font-size: 2em;" class="glyphicon glyphicon-eye-open"></span> <span style="color:white;">......</span>Ver actividad<span style="color:white;">................................</span></a><br>
                                    @endcanany

                                    @canany(['temas.destroy','temas_assign.destroy'])
                                        <a class="btn" style="margin-bottom: 5px;" href="javascript:confirmar_eliminar('¿ Desea eliminar el registro con id {{ $tema->id }}','{{ route('temas.confirmDelete',['id'=>$tema->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}');" onclick="loader_function()" title="Eliminar compromiso" > <span style="font-size: 2em;" class="glyphicon glyphicon-trash"></span> <span style="color:white;">....</span>Eliminar compromiso<span style="color:white;">..........</span></a>
                                    @endcanany
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
            document.getElementById("li_seguimiento_temas").className = "active";

            document.getElementById("lia_page_tema").className = "li_drown";
            document.getElementById('lia_page_tema').style.color = 'white';

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
                    $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
            
                    obtain_list_class_all('{{$data_search}}','data_search',"{{ route('estado_seguimientos.search') }}");

                    $(document).ready(function() {    
                        $('#data_search').select2({
                            placeholder: "Seleccione...",
                            allowClear: true,
                        });
                    });
                }else{
                    if(option == 4){
                        $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                        
                        obtain_list_class_all('{{$data_search}}','data_search',"{{ route('indices.search') }}");

                        $(document).ready(function() {    
                            $('#data_search').select2({
                                placeholder: "Seleccione...",
                                allowClear: true,
                            });
                        });
                    }else{
                        if(option == 5){
                            $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                        
                            obtain_list_class_all('{{$data_search}}','data_search',"{{ route('clasificaciones.search') }}");

                            $(document).ready(function() {    
                                $('#data_search').select2({
                                    placeholder: "Seleccione...",
                                    allowClear: true,
                                });
                            });

                        }else{
                            if(option == 6){
                                $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                        
                                obtain_list_class_all('{{$data_search}}','data_search',"{{ route('sub_clasificaciones.search_all') }}");

                                $(document).ready(function() {    
                                    $('#data_search').select2({
                                        placeholder: "Seleccione...",
                                        allowClear: true,
                                    });
                                });
                            }else{
                                if(option == 7){
                                    $("#input_search").html('<input type="date" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" >');
                                    document.getElementById("input_search_2").style.display = "";
                                }else{
                                    if(option == 8){  //Organismo
                                        $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                        
                                        obtain_list_class_all('{{$data_search}}','data_search',"{{ route('organismos.search') }}");

                                        $(document).ready(function() {    
                                            $('#data_search').select2({
                                                placeholder: "Seleccione...",
                                                allowClear: true,
                                            });
                                        });
                                    }else{
                                        if(option == 9){   //equipo
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