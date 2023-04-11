@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('sub_clasificaciones.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_sub_clasificaciones" onclick="loader_function()" >/Referencia transversal</a>/Editar Referencia transversal {{ $sub_clasificacione->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar Referencia transversal {{ $sub_clasificacione->id }}</b></h1>
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

            <form action="{{ route('sub_clasificaciones.update', ['sub_clasificacione' => $sub_clasificacione->id]) }}" method="POST" id="form_submit" name="form_submit">
                @csrf
                @method('put')
                
                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" required style="display:none;">
                
                <textarea id="name_origin" class="form-control" name="name_origin" style="display:none;" >{{ $sub_clasificacione->name }}</textarea>

                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Nombre </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="name" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" required minlength="4" maxlength="100" rows="4" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >{{ $sub_clasificacione->name }}</textarea>
                        </div>
                    </div>
                </div>
                <br>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Descripción </b></label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" minlength="4" maxlength="45" rows="4" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >{{ $sub_clasificacione->description }}</textarea>
                        </div>
                    </div>
                </div><br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('sub_clasificaciones.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_ajustes").className = "active";

        document.getElementById("lia_page_sub_clasificaciones").className = "li_drown";
        document.getElementById('lia_page_sub_clasificaciones').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });
    </script>
    
@endsection 