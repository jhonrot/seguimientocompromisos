@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <p><a href="{{ route('tema_despachos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" id="lia_page_help" onclick="loader_function()" >/Reuniones</a>/reunión {{ $thems->id }}</p>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>reunión {{ $thems->id }}</b></h1>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="glyphicon glyphicon-tag"><b> Fecha de inicio </b></label>
                <input type="date" id="fecha_reunion" class="form-control @error('fecha_reunion') is-invalid @enderror" name="fecha_reunion"  required value="{{ $thems->fecha_reunion }}" readonly >
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="glyphicon glyphicon-tag"><b> Hora de la reunión </b></label>
                <input type="time" id="hora_reunion" class="form-control @error('hora_reunion') is-invalid @enderror" name="hora_reunion"  required value="{{ $thems->hora_reunion }}" readonly >
            </div>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="glyphicon glyphicon-list-alt"><b> Tema de la reunión </b></label>
                <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"  required minlength="3" maxlength="500" rows="4" readonly >{{ $thems->descripcion }}</textarea>
            </div>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="glyphicon glyphicon-filter"><b> Objetivo de la reunión </b></label>
                <textarea id="objetivo" class="form-control @error('objetivo') is-invalid @enderror" name="objetivo"  required minlength="3" maxlength="500" rows="4" readonly >{{ $thems->objetivo }}</textarea>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="glyphicon glyphicon-king"><b> Asistentes </b></label>
                <textarea id="asistentes" class="form-control @error('asistentes') is-invalid @enderror" name="asistentes"  required minlength="3" maxlength="500" rows="4" readonly >{{ $thems->asistentes }}</textarea>
            </div>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="glyphicon glyphicon-tag"><b> Orden del día </b></label>
                <textarea id="orden" class="form-control @error('orden') is-invalid @enderror" name="orden"  required minlength="3" maxlength="1000" rows="4" readonly >{{ $thems->orden }}</textarea>
            </div>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="glyphicon glyphicon-info-sign"><b> Desarrollo de la reunión </b></label>
                <textarea id="desarrollo" class="form-control @error('desarrollo') is-invalid @enderror" name="desarrollo"  required minlength="3" maxlength="2000" rows="4" readonly >{{ $thems->desarrollo }}</textarea>
            </div>
        </div>
    </div><br>
    
    <div class="row">
        <div class="col-sm-12" >
            <h4><b>Evidencia</b></h4>
        </div>

        <div class="col-sm-12" style="margin-top: 25px;" id="div_registro_documento" >
            <div class="row" id="file_div">
                @php $cont=0; @endphp
                @foreach($thems->evidencias as $evidence)

                    @php 
                        $cont++;
                        $formato = explode(".", $evidence->evidencia);
                    @endphp
                    <div class="row" id="div_file{{$cont}}" style="margin-bottom:15px;" >
                        <div class="col-sm-12">
                            <span id="span_iput_file{{$cont}}" >
                                <input type="text" id="evidencia_inicial{{$cont}}" name="evidencia_inicial[]" value="{{$evidence->evidencia}}" style="display:none;" >'+
                                <input type="file" id="evidencia{{$cont}}" name="evidencia[]" class="form-control" onchange="mostrar_doc_several(event,['pdf','png','jpg','jpeg','bmp','txt','csv','xls','xlsx','docx','mp3'],{{$cont}})" accept=".pdf, .png, .jpg, .jpeg, .bmp, .txt, .csv, .xls, .xlsx, .docx, .mp3" style="display:none" >
                            </span>
                            <span id="doc_evidencia{{$cont}}">
                                @if($formato[1] == "pdf" || $formato[1] == "txt" || $formato[1] == "csv" || $formato[1] == "xls" || $formato[1] == "xlsx" || $formato[1] == "docx")
                                    <a target="_blank" href="{{asset('evidencia/'.$evidence->evidencia)}}" ><span class="glyphicon glyphicon-file fa-5x">{{$cont}}</span></a>     
                                @else
                                    @if($formato[1] == "mp3")
                                        <a target="_blank" href="{{asset('evidencia/'.$evidence->evidencia)}}" ><span class="glyphicon glyphicon-volume-up fa-5x">{{$cont}}</span></a>      
                                    @else
                                        <a target="_blank" href="{{asset('evidencia/'.$evidence->evidencia)}}" ><img style="width:17%;border: 1px solid gray;" title="Documento" src="{{asset('evidencia/'.$evidence->evidencia)}}" ><span style="font-size: 5em;">{{$cont}}</span></a>
                                    @endif
                                @endif
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>  
    </div><br><br>

    <div class="row">
        <center>
            <a type="button" class="btn btn-secondary" href="{{ route('tema_despachos.index') }}?select_search={{$select_search}}&data_search={{$data_search}}&page={{$page}}" onclick="loader_function()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Atras</b></a>
        </center>
    </div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_despachos").className = "active";

        document.getElementById("lia_page_tema_despacho").className = "li_drown";
        document.getElementById('lia_page_tema_despacho').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });
    </script>
    
@endsection 