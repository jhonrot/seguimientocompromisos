@extends('layouts.app')

@section('libraries_add')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('planes.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_planes" onclick="loader_function()" >/Actividades</a>/Editar actividad {{ $plan->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar actividad {{ $plan->id }}</b></h1>
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

            <form action="{{ route('planes.update',['plane' => $plan->id ]) }}" method="POST" id="form_submit" name="form_submit">
                @csrf
                @method('put')
                
                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" required style="display:none;">
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Obligación contractual </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select name="obligacion_id" id="obligacion_id" class="form-control @error('obligacion_id') is-invalid @enderror" required >
                                <option value="">Seleccione</option>
                                @foreach($obligaciones->all() as $obligacion)
                                    <option value="{{$obligacion->id}}">{{$obligacion->obligacion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Meta </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input type="text" id="meta" class="form-control mayus @error('meta') is-invalid @enderror" name="meta"  required minlength="4" maxlength="200" value="{{ $plan->meta }}" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Descripción de la meta de la actividad </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="meta_descripcion" class="form-control mayus @error('meta_descripcion') is-invalid @enderror" name="meta_descripcion"  required minlength="4" maxlength="500" rows="4" >{{ $plan->meta_descripcion }}</textarea>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Actividad </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input type="text" id="actividad" class="form-control mayus @error('actividad') is-invalid @enderror" name="actividad"  required minlength="4" maxlength="200" value="{{ $plan->actividad }}" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Descripción de la actividad </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="actividad_descripcion" class="form-control mayus @error('actividad_descripcion') is-invalid @enderror" name="actividad_descripcion"  required minlength="4" maxlength="500" rows="4" >{{ $plan->actividad_descripcion }}</textarea>
                        </div>
                    </div>
                </div><br>

                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Indicador </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input type="text" id="indicador" class="form-control mayus @error('indicador') is-invalid @enderror" name="indicador" required minlength="4" maxlength="200" value="{{ $plan->indicador }}" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Unidad </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select id="unidad" class="form-control @error('unidad') is-invalid @enderror js-example-basic-multiple" name="unidad[]" required multiple="multiple" >
                                <option value="1" {{ ($plan->unidades()->get('unidad as id')->contains(1)) ? 'selected':'' }} >1</option>
                                <option value="2" {{ ($plan->unidades()->get('unidad as id')->contains(2)) ? 'selected':'' }} >2</option>
                                <option value="3" {{ ($plan->unidades()->get('unidad as id')->contains(3)) ? 'selected':'' }} >3</option>
                                <option value="4" {{ ($plan->unidades()->get('unidad as id')->contains(4)) ? 'selected':'' }} >4</option>
                                <option value="5" {{ ($plan->unidades()->get('unidad as id')->contains(5)) ? 'selected':'' }} >5</option>
                                <option value="6" {{ ($plan->unidades()->get('unidad as id')->contains(6)) ? 'selected':'' }} >6</option>
                                <option value="7" {{ ($plan->unidades()->get('unidad as id')->contains(7)) ? 'selected':'' }} >7</option>
                                <option value="8" {{ ($plan->unidades()->get('unidad as id')->contains(8)) ? 'selected':'' }} >8</option>
                                <option value="9" {{ ($plan->unidades()->get('unidad as id')->contains(9)) ? 'selected':'' }} >9</option>-->
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Cantidad </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input type="number" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" name="cantidad" required min="1" value="{{ $plan->cantidad }}" >
                        </div>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('planes.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_plan").className = "active";

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $("#obligacion_id").val("{{ $plan->obligacion_id }}");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        $(document).ready(function() {    
            $('#unidad').select2({
                placeholder: "Seleccione...",
                allowClear: true,
            });
        });
    </script>
    
@endsection 