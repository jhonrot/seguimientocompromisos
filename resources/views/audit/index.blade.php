    
    @extends('layouts.app')

    @section('libraries_add')
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
        <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-sm-12" >
                <a href="{{ route('audits.index') }}" id="lia_page_tema" onclick="loader_function()" >/Seguimiento auditoria</a>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-12" align="center" >
                <h1><b>Listado de seguimiento auditoria</b></h1>
            </div>
        </div><br>

        <div class="row">
			<div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary" href="{{ route('audits.index') }}" id="lia_page_tema" onclick="loader_function()" ><span class="glyphicon glyphicon-home"></span> Inicio</a>
            </div>
        </div><br>

        <div class="row">
            <form action="{{ route('audits.index') }}" method="get" class="form-group col-sm-12" id="form_submit" name="form_submit">
                <div class="input-group">
                    <span class="btn btn-primary input-group-addon" onclick="buscar()"><b><span class="glyphicon glyphicon-search"></span></b></span>
                    <button type="submit" id="id_submit" name="id_submit" style="display:none;">Submit</button>
                    <div class="row">
                        <div class="col-sm-4" id="div_select_search" >
                            <select class="form-control" id="select_search" name="select_search" onchange="change_select()">
                                <option value="1">Evento</option>

                                <option value="3">Modulo</option>
                                <option value="4">Id Módulo</option>

                                <option value="5">Valor</option>
                                <option value="6">Fecha</option>
                            </select>
                        </div>
                        <div class="col-sm-8" id="input_search">
                            <input type="text" class="form-control" id="data_search" name="data_search" value="{{$data_search}}" onkeydown="search_table(event)">
                        </div>
                    </div>
                </div>
            </form>

            <div class="form-group col-sm-12" id="div_count_rows" >
                <div class="input-group">
                    <span class="input-group-addon"><b>Cantidad registros</b></span>
                    <input type="text" class="form-control text-center" value="{{ $audits->total()}}" id="total" readonly>
                </div>
            </div>
        </div>

        <div class="table-striped">
            <table class="table table-responsive table-bordered tablas" id="tabla">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Usuario</th>
                        <th>Evento</th>
                        <th>Módulo</th>
                        <th>Id Módulo</th>
                        <th>Valores viejos</th>
                        <th>Valores nuevos</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($audits) <=0)
                        <tr>
                            <td align="center" colspan="8">No hay registros</td>
                        </tr>
                    @else

                        @foreach($audits as $audit)
                            <tr>
                                <td>{{ $audit->id }}</td>
                                <td>{{ $audit->user[0]->name." ".$audit->user[0]->last_name }}</td>
                                <td>{{ $audit->event }}</td>

                                <td>{{ $audit->auditable_type }}</td>

                                <td>{{ $audit->auditable_id }}</td>

                                <td>
                                    @foreach($audit->old_values as $clave => $old_value)
                                        @php print "<b>".$clave."</b>: ".$old_value."<br>";  @endphp
                                    @endforeach
                                </td>

                                <td>
                                    @foreach($audit->new_values as $clave => $new_value)
                                        @php print "<b>".$clave."</b>: ".$new_value."<br>";  @endphp
                                    @endforeach
                                </td>

                                <td>{{ $audit->created_at }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $audits->links() }}

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
            document.getElementById("li_entrada").className = "active";

            document.getElementById("lia_page_audit").className = "li_drown";
            document.getElementById('lia_page_audit').style.color = 'white';
            
            function buscar(){
                document.getElementById('id_submit').click();
            }

            function search_table(event){
                if(event.key == "Enter"){
                    document.getElementById('id_submit').click();
                }
            }
        </script>
            
    @endsection