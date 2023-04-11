@extends('layouts.app')

@section('libraries_add')
    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('actividades.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" id="lia_page_actividad" onclick="loader_function()" >/Tareas</a>/Informe</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Informe semanal</b></h1>
        </div>
    </div><br>

    <div class="row">

        <div class="col-sm-12">

            <form action="javascript:print_data_infor('{{ route('actividades.index') }}','actividad_id')" method="GET" >

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$data_search2}};{{$page}}" style="display:none;">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="btn btn-primary input-group-addon"><b>Generar informe</b></span>
                            <div class="row">
                                <div class="col-sm-12" >
                                    <select class="form-control" id="select_search" name="select_search" onchange="change_select()" required >
                                        <option value="">Seleccione..</option>
                                        <option value="1">Compromiso</option>
                                        <option value="2">Fecha</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><br><br>

                <div class="row" id="div_tema" style="display:none;" >
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Compromiso </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <select name="tema_id" id="tema_id" class="form-control @error('tema_id') is-invalid @enderror js-example-basic-single" onchange="obtain_list_data('','seguimiento_id','{{ route('seguimientos.search_item',['item'=>'uno'])  }}','seguimiento','tema_id')" >
                                <option value="">Seleccione</option>
                                @foreach($temas->all() as $tema)
                                    <option value="{{$tema->id}}">{{$tema->tema}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row" id="div_seguimiento" style="display:none;" >
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-search"><b> Actividad </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <select name="seguimiento_id" id="seguimiento_id" class="form-control @error('seguimiento_id') is-invalid @enderror js-example-basic-single" onchange="obtain_list_data('','actividad_id','{{ route('actividades.search_item',['item'=>'uno'])  }}','actividad','seguimiento_id')" >
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row" id="div_actividad" style="display:none;" >
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Tarea </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <select name="actividad_id" id="actividad_id" class="form-control @error('actividad_id') is-invalid @enderror js-example-basic-single" >
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row" id="div_semanas" style="display:none;" >
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-calendar"><b> Semanas</b></label>                       
                            <input type="date" name="date_1" id="date_1" class="form-control @error('date_1') is-invalid @enderror" >   
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label></label>                       
                            <input type="date" name="date_2" id="date_2" class="form-control @error('date_2') is-invalid @enderror" >   
                        </div>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary" id="button_submit" style="display:none;" ><b> <span class="glyphicon glyphicon-floppy-saved"></span> Imprimir informe</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('actividades.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&data_search2={{$data_search2}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    @if(Session::get('status_print'))
        <script>
            $(window).on('load', function(){
                show_message_wait('{{Session::get('status_print')}}');
            });
        </script>
    @endif

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_seguimiento_temas").className = "active";

        document.getElementById("lia_page_actividad").className = "li_drown";
        document.getElementById('lia_page_actividad').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        $('#tema_id').select2({
            placeholder: "Seleccione...",
            allowClear: true,
        });

        $('#seguimiento_id').select2({
            placeholder: "Seleccione...",
            allowClear: true,
        });

        $('#actividad_id').select2({
            placeholder: "Seleccione...",
            allowClear: true,
        });

        function change_select(){
            input = $("#select_search").val();
            if(input == 1){
                document.getElementById("div_tema").style.display="";
                document.getElementById("div_seguimiento").style.display="";
                document.getElementById("div_actividad").style.display="";
                document.getElementById("div_semanas").style.display="";
                document.getElementById("button_submit").style.display="";

                document.querySelector('#tema_id').required = true;
                document.querySelector('#seguimiento_id').required = true;
                document.querySelector('#actividad_id').required = true;
                document.querySelector('#date_1').required = true;
                document.querySelector('#date_2').required = true;
            }else{
                if(input == 2){
                    document.getElementById("div_tema").style.display="none";
                    document.getElementById("div_seguimiento").style.display="none";
                    document.getElementById("div_actividad").style.display="none";
                    document.getElementById("div_semanas").style.display="";
                    document.getElementById("button_submit").style.display="";

                    document.querySelector('#tema_id').required = false;
                    document.querySelector('#seguimiento_id').required = false;
                    document.querySelector('#actividad_id').required = false;
                    document.querySelector('#date_1').required = true;
                    document.querySelector('#date_2').required = true;
                }else{
                    document.getElementById("div_tema").style.display="none";
                    document.getElementById("div_seguimiento").style.display="none";
                    document.getElementById("div_actividad").style.display="none";
                    document.getElementById("div_semanas").style.display="none";
                    document.getElementById("button_submit").style.display="none";

                    document.querySelector('#tema_id').required = false;
                    document.querySelector('#seguimiento_id').required = false;
                    document.querySelector('#actividad_id').required = false;
                    document.querySelector('#date_1').required = false;
                    document.querySelector('#date_2').required = false;
                }
            }
        }
    </script>
    
@endsection 