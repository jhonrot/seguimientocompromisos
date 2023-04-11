@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('roles.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_role" onclick="loader_function()" >/Roles</a>/Editar rol {{ $rol->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar rol {{ $rol->id }}</b></h1>
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

            <form action="{{ route('roles.update',['role'=>$rol->id]) }}" method="POST" id="form_submit" name="form_submit">
                @csrf
                @method('put')
                
                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" style="display:none;">
                <input id="name_origin" type="text" class="form-control" name="name_origin" value="{{ $rol->name }}" required style="display:none;" >

                <div class="row">
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-user"><b> Nombre </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $rol->name }}" required autocomplete="name" autofocus minlength="4" maxlength="255" >
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-wrench"><b> Permisos </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>                       
                            <br><br>
                            <div class="row" style="margin-left: 12px;">
                                @foreach($permissions->all() as $permission)
                                    <div class="col-sm-12">                                  
                                        <div class="checkbox-inline">
                                            @if($permission->role_id > 0)
                                                <input id="permissions" type="checkbox" name="permissions[]" value="{{$permission->id}}" checked ><p style="font-size:1.3em;line-height: 1.2em;" >{{$permission->description}}</p>
                                            @else
                                                <input id="permissions" type="checkbox" name="permissions[]" value="{{$permission->id}}" ><p style="font-size:1.3em;line-height: 1.2em;">{{$permission->description}}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('roles.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_entrada").className = "active";

        document.getElementById("lia_page_role").className = "li_drown";
        document.getElementById('lia_page_role').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });
    </script>
    
@endsection 