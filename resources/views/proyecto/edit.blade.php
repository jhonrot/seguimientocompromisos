@extends('layouts.app')

@section('libraries_add')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('proyectos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_proyecto" onclick="loader_function()" >/Proyectos</a>/Editar proyecto {{ $proj->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar proyecto {{ $proj->id }}</b></h1>
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

            <form action="{{ route('proyectos.update',['proyecto'=>$proj->id]) }}" method="POST" id="form_submit" name="form_submit" >
                @csrf
                @method('put')

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" style="display:none;">
                
                <textarea id="name_origin" class="form-control" name="name_origin" rows="4" required style="display:none;" >{{ $proj->name }}</textarea>
                <input id="bp_origin" type="text" class="form-control" name="bp_origin" value="{{ $proj->bp }}" required style="display:none;">
                
                <input id="comuna_id_origin" type="text" class="form-control" name="comuna_id_origin" value="{{ $proj->comuna_id }}" required style="display:none;">
                <input id="organismo_id_origin" type="text" class="form-control" name="organismo_id_origin" value="{{ $proj->organismo_id }}" required style="display:none;">
                <input id="user_id_origin" type="text" class="form-control" name="user_id_origin" value="{{ $proj->user_id }}" required style="display:none;">

                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-file"><b> Nombre </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="name" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" minlength="4" maxlength="500" rows="4" required onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >{{ $proj->name }}</textarea>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-barcode"><b> BP </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <input id="bp" type="text" class="form-control @error('bp') is-invalid @enderror" name="bp" value="{{ $proj->bp }}" required autocomplete="bp" autofocus minlength="5" maxlength="10" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-map-marker"><b> Comuna</b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="comuna_id" id="comuna_id" class="form-control @error('comuna_id') is-invalid @enderror js-example-basic-single" required >
                                <option value="">Seleccione</option>
                                @foreach($comunas->all() as $com)
                                    <option value="{{$com->id}}">{{$com->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-king"><b> Organismos</b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="organismo_id" id="organismo_id" class="form-control @error('organismo_id') is-invalid @enderror js-example-basic-single" required >
                                <option value="">Seleccione</option>
                                @foreach($organismos->all() as $org)
                                    <option value="{{$org->id}}">{{$org->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-user"><b> responsables</b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror js-example-basic-single" required >
                                <option value="">Seleccione</option>
                                @foreach($responsables->all() as $resp)
                                    @php $cant_proj_asign = 0; $projs_asignados = ""; @endphp
                                    @foreach($resp->proyectos as $proj_asign)
                                        @php $cant_proj_asign++; $projs_asignados .= "\n".$cant_proj_asign.". ".$proj_asign->name; @endphp
                                    @endforeach
                                    <option value="{{$resp->id}}" title="Cantidad de proyectos asignados: {{$cant_proj_asign}} {{$projs_asignados}}" >{{$resp->name}} {{$resp->last_name}} - {{ (isset($responsable->organismos[0]->name)?$responsable->organismos[0]->name:'No dispone de organismo') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('proyectos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_seguimiento_proyectos").className = "active";

        document.getElementById("lia_page_proyecto").className = "li_drown";
        document.getElementById('lia_page_proyecto').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        $("#comuna_id").val("{{ $proj->comuna_id }}");
        $("#organismo_id").val("{{ $proj->organismo_id }}");
        $("#user_id").val("{{ $proj->user_id }}");

        $(document).ready(function() {    
            $('#comuna_id').select2({
                placeholder: "Seleccione...",
                allowClear: true,
            });
            $('#organismo_id').select2({
                placeholder: "Seleccione...",
                allowClear: true,
            });
            $('#user_id').select2({
                placeholder: "Seleccione...",
                allowClear: true,
            });
        });
    </script>
    
@endsection 