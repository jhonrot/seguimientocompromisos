    
    @extends('layouts.app')

    @section('libraries_add')
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
        <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                @if($place2 == 2)
                    <p><a href="{{ route('proyectos.index') }}?select_search={{$select_search2}}&data_search={{$data_search2}}&page={{$page2}}" id="lia_page_proyecto" onclick="loader_function()" >Proyectos</a>/<a href="{{ route('proyectos.registry') }}?select_search={{$select_search2}}&data_search={{$data_search2}}&page={{$page2}}&proj={{$proj}}" id="lia_page_proyecto" onclick="loader_function()" >Ver registros</a>/<a href="{{ route('paas.index') }}?select_search2={{$select_search2}}&data_search2={{$data_search2}}&page2={{$page2}}&place2={{$place2}}&proj={{$proj}}" id="lia_page_proyecto" onclick="loader_function()">PAA</a></p>
                @endif
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Listado de Plan Anual de adquisiciones - PAA</b></h1>
            </div>
        </div><br>

        <div class="row">
            <div class="form-group col-sm-5">
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $paas->total()}}" id="total" readonly>
                </div>
            </div>

            @if($place2 == 2)
                <form action="{{ route('paas.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
                    <div class="input-group">
                        <span class="btn btn-primary input-group-addon" onclick="buscar()"><b>Buscar</b></span>
                        <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                        <div class="row">

                            <input type="text" class="form-control" id="select_search2" name="select_search2" value="{{$select_search2}}" style="display:none;" />
                            <input type="text" class="form-control" id="data_search2" name="data_search2" value="{{$data_search2}}" style="display:none;" />
                            <input type="text" class="form-control" id="page2" name="page2" value="{{$page2}}" style="display:none;" />
                            <input type="text" class="form-control" id="place2" name="place2" value="{{$place2}}" style="display:none;" />
                            <input type="text" class="form-control" id="proj" name="proj" value="{{$proj}}" style="display:none;" />

                            <div class="col-sm-6" >
                                <select class="form-control" id="select_search" name="select_search" onchange="change_select()">
                                    <option value="1">Socialización</option>
                                    <option value="2">publicación</option>
                                    <option value="3">Proyecto</option>
                                </select>
                            </div>
                            <div class="col-sm-6" id="input_search">
                                <input type="date" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" onkeydown="search_table(event)">
                            </div>
                        </div>
                    </div>
                </form>
            @endif

            @if($place2 == 3)
                <form action="{{ route('paas.index') }}" method="get" class="form-group col-sm-7" id="form_submit" name="form_submit">
                    <div class="input-group">
                        <span class="btn btn-primary input-group-addon" onclick="buscar()"><b>Buscar</b></span>
                        <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                        <div class="row">
                            <div class="col-sm-6" >
                                <select class="form-control" id="select_search" name="select_search" onchange="change_select()">
                                    <option value="1">Socialización</option>
                                    <option value="2">publicación</option>
                                    <option value="3">Proyecto</option>
                                </select>
                            </div>
                            <div class="col-sm-6" id="input_search">
                                <input type="date" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" onkeydown="search_table(event)">
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>

        <div class="table-responsive table-striped">
            <table class="table table-bordered tablas" id="tabla">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>BP proyecto</th>
                        <th>Presupuesto del proyecto</th>
                        <th>Número de modalidades de contratación</th>
                        <th>Presupuesto modalidades</th>
                        <th>Fecha Socialización</th>
                        <th>Plazo Ejecución Física del Proyecto</th>
                        <th>Fecha Publicación</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($paas) <=0)
                        <tr>
                            <td align="center" colspan="9">No hay registros</td>
                        </tr>
                    @else
                        @foreach($paas as $paa)
                            <tr>
                                <td>{{ $paa->id }}</td>
                                <td>{{ $paa->presupuestos[0]->proyectos[0]->bp  }}</td>
                                <td>$ {{ number_format($paa->presupuestos[0]->presupuesto_proyecto,0,',','.') }}</td>
                                <td>{{ $paa->presupuestos[0]->cantidad }}</td>

                                <td>
                                    @for($k=0;$k<$paa->presupuestos[0]->cantidad;$k++)

                                        {{ $paa->presupuestos[0]->modalidades[$k]->tipo}}= $ {{ number_format($paa->presupuestos[0]->modalidades[$k]->pivot->presupuesto_modalidad,0,',','.') }}<br>
                                    @endfor
                                </td>

                                <td>{{ $paa->socializacion }}</td>
                                <td>{{ $paa->plazo }}</td>
                                <td>{{ $paa->publicacion }}</td>
                                
                                <td class="text-center" >
                                    @can('paas.edit')
                                        <a class="btn" style="margin-bottom: 5px;" href="{{ route('paas.edit',['paa'=>$paa->id]) }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&pres={{$paa->presupuesto_id}}&place={{$place2}}&proj={{$proj}}&bp={{ $paa->presupuestos[0]->proyectos[0]->bp  }}&select_search2={{$select_search2}}&data_search2={{$data_search2}}&page2={{$page2}}&proj_real={{$paa->presupuestos[0]->proyectos[0]->id }}" onclick="loader_function()" title="Editar PAA" > <span style="font-size: 2em;" class="glyphicon glyphicon-edit"></span> Editar PAA</a><br>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $paas->links() }}
        </div>

        <script>
            $(".li_base").removeClass("active");
            if({{$place2}} == 1 || {{$place2}} == 2){
                document.getElementById("li_seguimiento_proyectos").className = "active";

                document.getElementById("lia_page_proyecto").className = "li_drown";
                document.getElementById('lia_page_proyecto').style.color = 'white';
            }

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
                    $("#input_search").html('<input type="date" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" >');
                }else{
                    $("#input_search").html("<select class='form-control js-example-basic-single' id='data_search' name='data_search' ></select>");
                    obtain_list_proj('{{$data_search}}',"{{ route('proyectos.search')}}");
                    
                    $(document).ready(function() {    
                        $('#data_search').select2({
                            placeholder: "Seleccione...",
                            allowClear: true,
                            width: 'resolve',
                        });
                    });
                }
            }
            change_select();
        </script>      
    @endsection