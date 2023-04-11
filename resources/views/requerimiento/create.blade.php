@extends('layouts.app')

@section('libraries_add')
    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('helps.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_help" onclick="loader_function()" >/Requerimientos</a>/Nuevo requerimiento</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Nuevo Requerimiento</b></h1>
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

            <form action="{{ route('helps.store') }}" method="POST" id="form_submit" name="form_submit" enctype="multipart/form-data" >
                @csrf

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" style="display:none;">
                      
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-list-alt"><b> Tema </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <select name="tema" id="tema" class="form-control @error('tema') is-invalid @enderror" required >
                                <option value="">Seleccione</option>
                                <option value="Soporte técnico">Soporte técnico</option>
                                <option value="Recomendación">Recomendación</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hand-up"><b> Observaciones </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="obs_creator" class="form-control @error('obs_creator') is-invalid @enderror" name="obs_creator"  required minlength="10" maxlength="500" rows="4" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >{{ old('obs_creator') }}</textarea>
                        </div>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-12" >
                        <h4><b>Evidencia adjunta</b></h4>
                    </div>
                    <div class="col-sm-6" >
                        <a class="btn btn-primary" onclick="generarClick_busqueda()" >
                            <span class="glyphicon glyphicon-search"></span><b> Buscar documento </b>
                        </a>
                    </div>

                    <input type="text" id="evidencia_inicial" name="evidencia_inicial" style="display:none;" >
                    
                    <span id="message"></span>                     
                    
                    <div class="col-sm-12" style="margin-top: 25px;display:none;" id="div_registro_documento" >
                        <div class="form-group">
                            <label class="glyphicon glyphicon-camera"><b> Registro Documento </b></label>       
                        </div>

                        <div class="row" align="center">
                            <div class="col-sm-6">
                                <span id="span_iput_file" >
                                    <input type="file" id="evidencia" name="evidencia" class="form-control" onchange="mostrar_doc_all_formats(event,['pdf','png','jpg','jpeg','bmp'])" accept=".pdf, .png, .jpg, .jpeg, .bmp" style="display:none" >
                                </span>
                                <span id="doc_evidencia">
                                    <img style="width:100%;border: 1px solid gray;" title="Error" src="https://cdn2.iconfinder.com/data/icons/documents-and-files-v-2/100/doc-03-512.png" id="img_file" >
                                </span>
                            </div>
                            <div class="col-sm-6" style="margin-top: 12px;">
                                <div class="form-group">
                                    <a class="btn btn-alert" style="border-radius: 22px" onclick="del_input_doc_all_formats()" ><span class="glyphicon glyphicon-trash"></span> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('helps.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_help").className = "active";

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $("#tema").val("{{ old('tema') }}");
        $(window).on('load', function(){
            $("#loading").html("");
        });
    </script>
    
@endsection 