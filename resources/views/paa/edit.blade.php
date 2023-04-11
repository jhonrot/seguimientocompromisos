@extends('layouts.app')

@section('libraries_add')
    <script type="text/javascript" src="{{asset('js/functions_paas.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            @if($place == 2)
                <p><a href="{{ route('proyectos.index') }}?select_search={{$select_search2}}&data_search={{$data_search2}}&page={{$page2}}" id="lia_page_proyecto" onclick="loader_function()" >Proyectos</a>/<a href="{{ route('proyectos.registry') }}?select_search={{$select_search2}}&data_search={{$data_search2}}&page={{$page2}}&proj={{$proj}}" id="lia_page_proyecto" onclick="loader_function()" >Ver registros</a>/<a href="{{ route('paas.index') }}?select_search2={{$select_search2}}&data_search2={{$data_search2}}&page2={{$page2}}&place2={{$place}}&select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&proj={{$proj}}" id="lia_page_proyecto" onclick="loader_function()">PAA</a>/Editar PAA {{ $paa->id }}</p>
            @endif
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar Plan Anual de adquisiciones - PAA {{ $paa->id }}</b></h1>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(Session::get('status'))
                <div class="alert alert-success">
                    {{Session::get('status')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div><br>

        <div class="col-sm-12">

            <form action="{{ route('paas.update',['paa'=>$paa->id]) }}" method="POST" id="form_submit_paas" name="form_submit_paas" enctype="multipart/form-data" >
                @csrf
                @method('put')

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}};{{$pres}};{{$proj}};{{$bp}};{{$place}};{{$select_search2}};{{$data_search2}};{{$page2}};{{$proj_real}}" style="display:none;" >
                
                <input type="text" name="proyecto_id" id="proyecto_id" class="form-control" value="{{$proj_real}}" required style="display:none;" >

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> BP </b></label>
                            <input type="text" id="bp" name="bp" class="form-control" value="{{$bp}}" readonly >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    
                    <div class="col-sm-6">
                        <div class="form-group"><!--"^\$ \d{1,3}(\.\d{3})*(,\d+)?$"-->
                            <label class="glyphicon glyphicon-usd"><b> Presupuesto del proyecto </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="presupuesto_proyecto_val" type="text" class="form-control" name="presupuesto_proyecto_val" required pattern="^\$ \d{1,3}(\.\d{3})*?$" data-type="currency" placeholder="$ 1.000.000" value="{{ $paa->presupuestos[0]->getPresupuesto_grande_miles() }}" minlength="3" maxlength="21" >
                            <input id="presupuesto_proyecto" type="number" class="form-control @error('presupuesto_proyecto') is-invalid @enderror" name="presupuesto_proyecto" value="{{ $paa->presupuestos[0]->getPresupuesto_grande() }}" required min="1" style="display:none;" >
                            <span id="span_total"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-scale"><b> Número de modalidades de contratación </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <div class="input-group">
                                <input id="cantidad" type="number" class="form-control @error('cantidad') is-invalid @enderror" name="cantidad" value="{{ $paa->presupuestos[0]->cantidad }}" required  min="1" max="4" onkeydown="obtain_inputs_mod_pres_enter(event,'{{ route('modalidades.search') }}')"  >
                                <span class="btn btn-primary input-group-addon" onclick="obtain_inputs_mod_pres('{{ route('modalidades.search') }}')"><b><span class="glyphicon glyphicon-arrow-right"></span></b></span>
                            </div>
                        </div>
                    </div>
                </div><br>

                <span id="div_1" >
                    @php 
                        $cant_temp = count($paa->presupuestos[0]->modalidades);
                        $valor_total = 0;
                    @endphp

                    @for($y=0;$y<$cant_temp;$y++)
                        <div class="row" id="div_pres_mod_{{ ($y+1)}}">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="glyphicon glyphicon-tasks"><b> Modalidad # {{ ($y+1)}}</b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                                    <select name="modalidad_id[]" id="modalidad_id" class="form-control @error('modalidad_id') is-invalid @enderror" required >
                                        <option value="">Seleccione</option>
                                        @foreach($modalidades->all() as $mod)
                                            <option value="{{$mod->id}}" {{$paa->presupuestos[0]->modalidades[$y]->pivot->modalidad_id==$mod->id?'selected':''}} >{{$mod->tipo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="glyphicon glyphicon-usd"><b> Presupuesto modalidad # {{ ($y+1)}}</b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                                    <input id="presupuesto_modalidad{{($y+1)}}_val" type="text" class="form-control" name="presupuesto_modalidad_val[]" required pattern="^\$ \d{1,3}(\.\d{3})*?$" data-type="currency" placeholder="$ 1.000.000" value="{{ '$ '.number_format($paa->presupuestos[0]->modalidades[$y]->pivot->presupuesto_modalidad,0,',','.') }}" minlength="3" maxlength="21" onkeyup="formatCurrency(2,this);" blur="formatCurrency(2,this, 'blur');" >
                                    <input id="presupuesto_modalidad{{($y+1)}}" type="number" class="form-control @error('presupuesto_modalidad') is-invalid @enderror" name="presupuesto_modalidad[]" required value="{{ intval($paa->presupuestos[0]->modalidades[$y]->pivot->presupuesto_modalidad) }}" min="1" style="display:none;" onchange="pres_check()" >
                                </div>
                            </div><br><br>
                        </div>
                        @php 
                            $valor_total = ($valor_total + intval($paa->presupuestos[0]->modalidades[$y]->pivot->presupuesto_modalidad));
                        @endphp
                    @endfor

                </span><br>

                <div class="row" id="div_2">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha socialización </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="socializacion" type="date" class="form-control @error('socializacion') is-invalid @enderror" name="socializacion" value="{{ $paa->socializacion }}" required onchange="obtain_execution()" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-scale"><b> Plazo ejecución fisica del proyecto (meses) </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <input id="plazo" type="number" step=".1" class="form-control @error('plazo') is-invalid @enderror" name="plazo" value="{{ $paa->plazo }}" required  min="1" >
                        </div>
                    </div>
                </div><br>

                <div class="row" id="div_3">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Fecha de publicación en página PAA </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="publicacion" type="date" class="form-control @error('publicacion') is-invalid @enderror" name="publicacion" value="{{ $paa->publicacion }}" required >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> Consecutivo PAA (Id) </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <textarea id="id_paa" class="form-control @error('id_paa') is-invalid @enderror" name="id_paa"  rows="4" required >{{ $paa->id_paa }}</textarea>
                        </div>
                    </div>
                </div><br><br>

                <div class="row" id="div_4">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        
                        @if($place == 2)
                            <a type="button" class="btn btn-secondary" href="{{ route('paas.index') }}?select_search2={{$select_search2}}&data_search2={{$data_search2}}&page2={{$page2}}&place2={{$place}}&select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}&proj={{$proj}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                        @endif
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        if({{$place}} == 1 || {{$place}} == 2){
            document.getElementById("li_seguimiento_proyectos").className = "active";

            document.getElementById("lia_page_proyecto").className = "li_drown";
            document.getElementById('lia_page_proyecto').style.color = 'white';
        }

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        presupuesto_proyecto.onpaste = function(event) {
            var text = event.clipboardData.getData('text/plain');
            event.preventDefault();
            copy_paste_number('presupuesto_proyecto',text,20);
        };

        /*presupuesto_modalidad.onpaste = function(event) {
            var text = event.clipboardData.getData('text/plain');
            event.preventDefault();
            copy_paste_number('presupuesto_modalidad',text,20);
            pres_check();
        };*/

        cant_temp = $("#cantidad").val();

        /*document.getElementById("presupuesto_proyecto").min = {{$valor_total}};
        document.getElementById("presupuesto_proyecto").max = {{$valor_total}};*/

    </script>

    @section('libraries_add2')
        <script type="text/javascript" src="{{asset('js/utilities.js')}}"></script>
    @endsection
    
@endsection 