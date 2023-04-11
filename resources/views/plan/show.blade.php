@extends('layouts.app')

@section('libraries_add')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('planes.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_planes" onclick="loader_function()" >/Actividades</a>/Actividad {{ $plan->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Actividad {{ $plan->id }}</b></h1>
        </div>
    </div><br>

    <div class="row">

        <div class="col-sm-12">

            <div>
                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" required style="display:none;">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Obligación contractual </b></label>
                            <input type="text" class="form-control" value="{{ $plan->obligaciones[0]->obligacion }}" readonly >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Meta </b></label>
                            <input class="form-control" value="{{ $plan->meta }}" readonly >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Descripción de la meta de la actividad </b></label>
                            <textarea class="form-control" rows="4" readonly >{{ $plan->meta_descripcion }}</textarea>
                        </div>
                    </div>
                </div><br>


                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Actividad </b></label>
                            <input type="text" class="form-control" value="{{ $plan->actividad }}" readonly >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Descripción de la actividad </b></label>
                            <textarea class="form-control" rows="4" readonly >{{ $plan->actividad_descripcion }}</textarea>
                        </div>
                    </div>
                </div><br>

                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Indicador </b></label>
                            <input type="text" class="form-control" value="{{ $plan->indicador }}" readonly >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Unidad </b></label>
                            <select id="unidad" class="form-control js-example-basic-multiple" multiple="multiple" disabled >
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
                            <label class="glyphicon glyphicon-pencil"><b> Cantidad </b></label>
                            <input type="number" class="form-control" value="{{ $plan->cantidad }}" readonly >
                        </div>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <center>
                        <a type="button" class="btn btn-secondary" href="{{ route('planes.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </div>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_plan").className = "active";

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

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