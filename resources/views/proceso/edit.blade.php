@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('procesos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_comunas" onclick="loader_function()" >/Procesos</a>/Editar proceso {{ $proceso->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Editar proceso {{ $proceso->id }}</b></h1>
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

            <form action="{{ route('procesos.update',['proceso' => $proceso->id ]) }}" method="POST" id="form_submit" name="form_submit">
                @csrf
                @method('put')
                
                <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" required style="display:none;">
                
                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Proceso </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <input type="text" id="proceso" class="form-control @error('proceso') is-invalid @enderror" name="proceso" required minlength="3" maxlength="200" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" value="{{ $proceso->proceso }}" >
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Descripción </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" minlength="3" maxlength="1000" rows="4" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >{{ $proceso->descripcion }}</textarea>
                        </div>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="{{ route('procesos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_ajustes").className = "active";

        document.getElementById("lia_page_procesos").className = "li_drown";
        document.getElementById('lia_page_procesos').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });
    </script>
    
@endsection 