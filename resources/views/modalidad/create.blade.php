@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('modalidades.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_modalidades" onclick="loader_function()" >/Modalidades</a>/Nueva modalidad</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Nueva modalidad</b></h1>
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

            <form action="{{ route('modalidades.store') }}" method="POST" id="form_submit" name="form_submit">
                @csrf
                
                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" style="display:none;">

                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Tipo </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="tipo" class="form-control @error('tipo') is-invalid @enderror" name="tipo" autocomplete="tipo" required minlength="4" maxlength="100" rows="4" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >{{ old('tipo') }}</textarea>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-hourglass"><b> Tiempo </b></label>
                            <input type="number" id="tiempo" class="form-control @error('tiempo') is-invalid @enderror" name="tiempo" value="{{ old('tiempo') }}" required min="0" max="100" />
                        </div>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('modalidades.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_ajustes").className = "active";

        document.getElementById("lia_page_modalidades").className = "li_drown";
        document.getElementById('lia_page_modalidades').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });
    </script>
    
@endsection 