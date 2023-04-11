@extends('layouts.app')

@section('libraries_add')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>

    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('users.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_user" onclick="loader_function()" >/Usuarios</a>/Editar usuario {{ $user->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar usuario {{ $user->id }}</b></h1>
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

            <form action="{{ route('users.update',['user'=>$user->id]) }}" method="POST" id="form_submit" name="form_submit" enctype="multipart/form-data" >
                @csrf
                @method('put')
                
                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" required style="display:none;">
                <input id="email_origin" type="email" class="form-control" name="email_origin" value="{{ $user->email }}" required style="display:none;" >
                <input id="num_document_origin" type="text" class="form-control" name="num_document_origin" value="{{ $user->num_document }}" required style="display:none;" >

                <div class="row">
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-th-list"><b> Tipo documento </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select class="form-control @error('type_document') is-invalid @enderror" id="type_document" name="type_document" required >
                                <option value="1">Cédula de Ciudadanía</option>
                                <option value="2">Tarjeta de Identidad</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-credit-card"><b> Número documento </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="num_document" type="text" class="form-control @error('num_document') is-invalid @enderror" name="num_document" value="{{ $user->num_document }}" required autocomplete="num_document" autofocus minlength="3" maxlength="20" onkeypress="return soloNumeros(event)" >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-user"><b> Nombre(s) </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus minlength="3" maxlength="45" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-user"><b> Apellidos </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" required autocomplete="last_name" autofocus minlength="3" maxlength="90" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-earphone"><b> Teléfono </b></label>
                            <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ $user->telefono }}" minlength="7" maxlength="7" autocomplete="telefono" onkeypress="return soloNumeros(event)" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-phone"><b> Celular </b></label>
                            <input id="celular" type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ $user->celular }}" minlength="10" maxlength="10" autocomplete="celular" onkeypress="return soloNumeros(event)" >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-envelope"><b> Correo </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" minlength="11" maxlength="45" required autocomplete="email">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-wrench"><b> Rol </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <select name="roles[]" id="roles" class="form-control js-example-basic-multiple @error('roles') is-invalid @enderror" required multiple="multiple" >
                                @foreach($roles->all() as $rol)
                                    <option value="{{$rol->id}}"  {{ ($user->roles_show->contains($rol->id)) ? 'selected':'' }}   >{{$rol->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-check"><b> Ingreso por logueo  </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select class="form-control @error('state') is-invalid @enderror" id="state" name="state" required >
                                <option value="">Seleccione</option>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-briefcase"><b> Responsable </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <select class="form-control @error('state_logic') is-invalid @enderror" id="state_logic" name="state_logic" required >
                                <option value="">Seleccione</option>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-oil"><b> Equipo trabajo </b></label>
                            <select class="form-control @error('equipo_trabajo_id') is-invalid @enderror" id="equipo_trabajo_id" name="equipo_trabajo_id" >
                                <option value="">Seleccione</option>
                                @foreach($equipo->all() as $equip)
                                    <option value="{{$equip->id}}">{{$equip->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-tower"><b> Organismo </b></label>
                            <select class="form-control @error('organismo_id') is-invalid @enderror" id="organismo_id" name="organismo_id" >
                                <option value="">Seleccione</option>
                                @foreach($organismo->all() as $org)
                                    <option value="{{$org->id}}">{{$org->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-lock"><b> Contraseña</b><span class="text-primary hint--top hint--primary" data-hint="Campo Opcional" style="cursor: pointer;">(Campo Opcional)</span></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" minlength="7" maxlength="45" onkeyUp="pass_length()" >
                            <span id="msg_passw"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-lock"><b> Confirmar contraseña</b><span class="text-primary hint--top hint--primary" data-hint="Campo Opcional" style="cursor: pointer;">(Campo Opcional)</span></label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" minlength="7" maxlength="45" onkeyUp="conf_pass_length()" >
                            <span id="msg_conf_passw"></span>
                        </div>
                    </div>

                </div><br>


                <div class="row">
                    <div class="col-sm-12" >
                        <h4><b>Foto</b></h4>
                    </div>
                    <div class="col-sm-6" >
                        <a class="btn btn-primary" onclick="generarClick_busqueda_imagen()" >
                            <span class="glyphicon glyphicon-search"></span><b> Buscar foto </b>
                        </a>
                    </div>

                    <input type="text" id="foto_inicial" name="foto_inicial" value="{{ $user->foto }}" style="display:none;" >

                    <span id="message"></span>                     
                    
                    <div class="col-sm-12" style="margin-top: 25px;display:none;" id="div_registro_fotografico" >

                        <div class="row" align="center">
                            <div class="col-sm-6">
                                <span id="span_iput_foto" >
                                    <input type="file" id="foto" name="foto" class="form-control" onchange="mostrar_image(event,['png','jpg','jpeg','bmp'])" accept=".png, .jpg, .jpeg, .bmp" style="display:none" >
                                </span>

                                @if($user->foto == '')
                                    <img style="width:100%;border: 1px solid gray;" title="Error" src="https://cdn2.iconfinder.com/data/icons/documents-and-files-v-2/100/doc-03-512.png" id="img_foto">
                                @endif
                                @if($user->foto != '')
                                    <img style="width:100%;border: 1px solid gray;" src="{{asset('fotos/'.$user->foto)}} " id="img_foto">
                                @endif

                            </div>

                            <div class="col-sm-6" style="margin-top: 12px;">
                                <div class="form-group">
                                    <a class="btn btn-alert" style="border-radius: 22px" onclick="del_input_foto()" ><span class="glyphicon glyphicon-trash"></span> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                
                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('users.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_entrada").className = "active";

        document.getElementById("lia_page_user").className = "li_drown";
        document.getElementById('lia_page_user').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        document.getElementById("password-confirm").disabled=true;

        function pass_length(){
            if(($("#password").val()).length >= 7){
                document.getElementById("password-confirm").disabled=false;
                if(($("#password-confirm").val()).length == 0){
                    $("#msg_passw").html("<p style='color:green'><b>Ok, por favor confirme contraseña.</b></p>");
                }else{
                    if($("#password").val() == $("#password-confirm").val()){
                        $("#msg_conf_passw").html("<p style='color:green'><b>Ok</b></p>");
                        $("#msg_passw").html("<p style='color:green'><b>Ok</b></p>");
                    }else{
                        $("#msg_passw").html("<p style='color:green'><b>Ok, por favor confirme contraseña.</b></p>");
                    }
                }
            }else{
                document.getElementById("password-confirm").disabled=true;
                if(($("#password").val()).length == 0){
                    $("#msg_passw").html("");
                    $("#msg_conf_passw").html("");
                }else{
                    $("#msg_passw").html("<p style='color:red'><b>Ingrese minimo 8 caracteres</b></p>");
                }  
            }
        }

        function conf_pass_length(){
            if(($("#password-confirm").val()).length >= 7){
                if($("#password").val() == $("#password-confirm").val()){
                    $("#msg_conf_passw").html("<p style='color:green'><b>Ok</b></p>");
                    $("#msg_passw").html("<p style='color:green'><b>Ok</b></p>");
                }else{
                    $("#msg_conf_passw").html("<p style='color:red'><b>Las contraseñas deben de coincidir</b></p>");
                }
            }else{
                $("#msg_conf_passw").html("<p style='color:red'><b>Ingrese minimo 8 caracteres</b></p>");
            }
        }

        $("#type_document").val("{{ $user->type_document }}");
        $("#state").val("{{ $user->state }}");
        $("#state_logic").val("{{ $user->state_logic }}");
        
        $("#equipo_trabajo_id").val("{{ $user->equipo_trabajo_id }}");
        $("#organismo_id").val("{{ $user->organismo_id }}");

        if("{{$user->foto }}" != ""){
            document.getElementById("div_registro_fotografico").style.display = "";
        }

        $(document).ready(function() {    
            $('#roles').select2({
                placeholder: "Seleccione...",
                allowClear: true,
            });
        });

        telefono.onpaste = function(event) {
            var text = event.clipboardData.getData('text/plain');
            event.preventDefault();
            copy_paste_number('telefono',text,7);
        };

        celular.onpaste = function(event) {
            var text = event.clipboardData.getData('text/plain');
            event.preventDefault();
            copy_paste_number('celular',text,10);
        };

        num_document.onpaste = function(event) {
            var text = event.clipboardData.getData('text/plain');
            event.preventDefault();
            copy_paste_number('num_document',text,20);
        };
    </script>
    
@endsection 