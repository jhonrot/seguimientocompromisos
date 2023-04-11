<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compromiso {{ $temas[0]->id }}</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" media="screen" />
</head>
<body>
    <div id="main-content">
		<div class="container">
            <div class="row">
                <div class="col-sm-12" style="float:right;">
                    <img src="https://www.cali.gov.co/info/principal/media/bloque207241.png" width="70" />
                    <img src="https://www.cali.gov.co/info/principal/media/bloque210342.png" width="50" />
                </div><br>
            </div>

            <div class="row">
                <div class="col-sm-12" style="border:1px solid gray;background-color:#dbdbdb;">
                    <h3><b>{{ $temas[0]->descripcion }}</b></h3>
                </div>
            </div><br>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered tablas" id="tabla">
                        <tbody>
                            <tr>
                                <td style="width:35%;"><b>Prioridad: </b></td>
                                <td style="width:65%;">{{ $temas[0]->prioridades[0]->name }}</td>
                            </tr>
                            <tr>
                                <td><b>Clasificación: </b></td>
                                <td>{{ $temas[0]->clasificaciones[0]->name}}</td>
                            </tr>
                            <tr>
                                <td><b>Fecha inicio: </b></td>
                                <td>{{ $temas[0]->fecha_inicio }}</td>
                            </tr>
                            <tr>
                                <td><b>Fecha maxima cumplimiento: </b></td>
                                <td>{{ $temas[0]->fecha_cumplimiento }}</td>
                            </tr>
                            <tr>
                                <td><b>Plazo: </b></td>
                                <td>{{ $temas[0]->plazo }}  día(s)</td>
                            </tr>
                            <tr>
                                <td><b>Creador: </b></td>
                                <td>{{ $temas[0]->creator[0]->name }} {{ $temas[0]->creator[0]->last_name }}</td>
                            </tr>
                            <tr>
                                <td><b>Responsable: </b></td>
                                <td>
                                    @foreach($temas[0]->users as $responsable)   
                                        {{ $responsable->name}} {{ $responsable->last_name}},<br>
                                    @endforeach 
                                </td>
                            </tr>
                            <tr>
                                <td><b>Observación: </b></td>
                                <td>{{ $temas[0]->observacion }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><br>

            @if(count($temas[0]->seguimientos) > 0)
                <div class="row">
                    <div class="col-sm-12" style="border:1px solid gray;background-color:#63af62;">
                        <h4><b>Seguimiento(s)</b></h4>
                    </div>
                </div><br>
            @endif

            @for($i=0; $i < count($temas[0]->seguimientos); $i++)
                
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered tablas" id="tabla">
                            <tbody>
                                <tr>
                                    <td style="width:35%;"><b>Fecha seguimiento: </b></td>
                                    <td style="width:65%;">{{ $temas[0]->seguimientos[$i]->fecha }}</td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><b>Estado seguimiento: </b></td>
                                    <td style="width:65%;">{{ $temas[0]->seguimientos[$i]->estado_seguimientos[0]->name }}</td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><b>Avance: </b></td>
                                    <td style="width:65%;">{{ $temas[0]->seguimientos[$i]->avance }} %</td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><b>Usuario creador: </b></td>
                                    <td style="width:65%;">{{ $temas[0]->seguimientos[$i]->creator[0]->name }} {{ $temas[0]->seguimientos[$i]->creator[0]->last_name }}</td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><b>Acciones adelantadas: </b></td>
                                    <td style="width:65%;">{{ $temas[0]->seguimientos[$i]->acciones_adelantadas }}</td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><b>Acciones pendientes: </b></td>
                                    <td style="width:65%;">{{ $temas[0]->seguimientos[$i]->acciones_pendientes }}</td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><b>Dificultades: </b></td>
                                    <td style="width:65%;">{{ $temas[0]->seguimientos[$i]->dificultades }}</td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><b>Alternativas: </b></td>
                                    <td style="width:65%;">{{ $temas[0]->seguimientos[$i]->alternativas }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><br>
            @endfor
        </div>
    </div>
</body>
</html>