@extends('layouts.app')

@section('libraries_add')
    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('helps.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_help" onclick="loader_function()" >/Requerimientos</a>/Editar requerimiento {{ $req->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar requerimiento {{ $req->id }}</b></h1>
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

            <form action="{{ route('helps.update',['help'=>$req->id]) }}" method="POST" id="form_submit" name="form_submit" enctype="multipart/form-data" >
                @csrf
                @method('put')

                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" style="display:none;">
                


                @if($req->user_id == Auth::user()->id)
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
                                <label class="glyphicon glyphicon-list-alt"><b> Estado </b></label> 
                                @if($req->state  == 1)                     
                                    <input type="text" name="state" id="state" class="form-control" value="Nuevo" readonly >
                                @endif
                                @if($req->state == 2)
                                    <input type="text" name="state" id="state" class="form-control" value="Pendiente" readonly >
                                @endif
                                @if($req->state == 3)
                                    <input type="text" name="state" id="state" class="form-control" value="Solucionado" readonly >
                                @endif
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="glyphicon glyphicon-hand-up"><b> Observaciones usuario</b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                                <textarea id="obs_creator" class="form-control @error('obs_creator') is-invalid @enderror" name="obs_creator"  required minlength="10" maxlength="500" rows="4" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >{{ $req->obs_creator }}</textarea>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="glyphicon glyphicon-hand-up"><b> Observaciones soporte </b></label>
                                <textarea class="form-control"  required rows="4" readonly >{{ $req->obs_support }}</textarea>
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

                        <input type="text" id="evidencia_inicial" name="evidencia_inicial" value="{{$req->evidencia}}" style="display:none;" >
                        
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
                                        @if($req->evidencia == '')
                                            <img style="width:100%;border: 1px solid gray;" title="Error" src="https://cdn2.iconfinder.com/data/icons/documents-and-files-v-2/100/doc-03-512.png" id="img_file" >
                                        @endif
                                        @if($req->evidencia != '')
                                            @php 
                                                $formato = explode(".", $req->evidencia);
                                            @endphp

                                            @if($formato[1] == "pdf")
                                                <a target="_blank" href="{{asset('evidencia/'.$req->evidencia)}}" ><img style="width:37%;border: 1px solid gray;" title="Documento" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/391px-PDF_file_icon.svg.png" ></a>
                                            @else
                                                <a target="_blank" href="{{asset('evidencia/'.$req->evidencia)}}" ><img style="width:37%;border: 1px solid gray;" title="Documento" src="{{asset('evidencia/'.$req->evidencia)}}" ></a>        
                                            @endif
                                        @endif
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
                @else
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="glyphicon glyphicon-list-alt"><b> Tema </b></label>                       
                                <input type="text" id="tema" name="tema" value="{{$req->tema}}" class="form-control" readonly >
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="glyphicon glyphicon-list-alt"><b> Estado </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                                <select name="state" id="state" class="form-control @error('state') is-invalid @enderror" required >
                                    <option value="1">Nuevo</option>
                                    <option value="2">Pendiente</option>
                                    <option value="3">Solucionado</option>
                                </select>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="glyphicon glyphicon-hand-up"><b> Observaciones usuario</b></label>
                                <textarea class="form-control" rows="4" >{{ $req->obs_creator }}</textarea>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="glyphicon glyphicon-hand-up"><b> Observaciones soporte </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                                <textarea id="obs_support" class="form-control @error('obs_support') is-invalid @enderror" name="obs_support"  required minlength="10" maxlength="500" rows="4" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >{{ $req->obs_support }}</textarea>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-12" >
                            <h4><b>Evidencia adjunta</b></h4>
                        </div>
                    
                        <div class="col-sm-12" style="margin-top: 25px;display:none;" id="div_registro_documento" >
                            <div class="form-group">
                                <label class="glyphicon glyphicon-camera"><b> Registro Documento </b></label>       
                            </div>

                            <div class="row" align="center">
                                <div class="col-sm-6">
                                    <span id="doc_evidencia">
                                        @if($req->evidencia == '')
                                            <img style="width:100%;border: 1px solid gray;" title="Error" src="https://cdn2.iconfinder.com/data/icons/documents-and-files-v-2/100/doc-03-512.png" id="img_file" >
                                        @endif
                                        @if($req->evidencia != '')
                                            @php 
                                                $formato = explode(".", $req->evidencia);
                                            @endphp

                                            @if($formato[1] == "pdf")
                                                <a target="_blank" href="{{asset('evidencia/'.$req->evidencia)}}" ><img style="width:37%;border: 1px solid gray;" title="Documento" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/391px-PDF_file_icon.svg.png" ></a>
                                            @else
                                                <a target="_blank" href="{{asset('evidencia/'.$req->evidencia)}}" ><img style="width:37%;border: 1px solid gray;" title="Documento" src="{{asset('evidencia/'.$req->evidencia)}}" ></a>        
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif

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

        $(window).on('load', function(){
            $("#loading").html("");
        });

        $("#tema").val("{{ $req->tema }}");

        if("{{$req->evidencia }}" != ""){
            document.getElementById("div_registro_documento").style.display = "";
        }
    </script>
    
@endsection 