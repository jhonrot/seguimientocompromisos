<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" media="screen" />
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
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

            @php 
                $cantidad_actividades = count($actividades);
                $seguimiento = 0;
                $i=0;
            @endphp

            @if($cantidad_actividades == 0)
                <h1>No hay registros</h1>
            @endif

            @for($i; $i < $cantidad_actividades; $i++)
                @if(($seguimiento != $actividades[$i]['seguimiento_id']) || $seguimiento == 0)
                    @if($seguimiento != 0 && $seguimiento == $actividades[$i-1]['seguimiento_id'])
                        @php 
                            $cantidad_responsables_dos = count($actividades[$i-1]->seguimientos[0]->temas[0]->users);
                        @endphp

                        <h5><b>Responsable(s): </b>
                        @for($j=0; $j < $cantidad_responsables_dos; $j++)
                            {{ $actividades[$i-1]->seguimientos[0]->temas[0]->users[$j]->name }} {{ $actividades[$i-1]->seguimientos[0]->temas[0]->users[$j]->last_name }} 
                            
                            @if($j != ($cantidad_responsables_dos-1))
                                ,
                            @endif
                        @endfor
                        </h5>
                    @endif

                    @if($seguimiento != 0)
                        <div class="page-break"></div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table" id="tabla">
                                <tbody>
                                    <tr>
                                        <td style="width:15%;"><b>Compromiso: </b></td>
                                        <td style="width:85%;">{{ $actividades[$i]->seguimientos[0]->temas[0]->tema }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Actividad: </b></td>
                                        <td>{{ count($actividades)==0?'':$actividades[$i]->seguimientos[0]->seguimiento}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Semana del: </b></td>
                                        <td>{{ $fecha1}} al {{ $fecha2 }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Responsable(s): </b></td>
                                        <td>
                                            @php 
                                                $cantidad_responsables = count($actividades[$i]->seguimientos[0]->temas[0]->users);
                                            @endphp

                                            @for($j=0; $j < $cantidad_responsables; $j++)
                                                {{ $actividades[$i]->seguimientos[0]->temas[0]->users[$j]->name }} {{ $actividades[$i]->seguimientos[0]->temas[0]->users[$j]->last_name }}
                                                
                                                @if($j != ($cantidad_responsables-1))
                                                    ,
                                                @endif
                                            @endfor
                                        
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12" style="border:1px solid gray;background-color:#215a9a;color:white;">
                            <h4><b>Tarea(es)</b></h4>
                        </div>
                    </div>
                @endif

                @php 
                    $seguimiento = $actividades[$i]['seguimiento_id'];
                @endphp

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered tablas" id="tabla">
                            <tbody>
                                <tr>
                                    <td style="width:35%;"><b>Tarea: </b></td>
                                    <td style="width:65%;">{{ $actividades[$i]->actividad }}</td>
                                </tr>

                                <tr>
                                    <td style="width:35%;"><b>Estado: </b></td>
                                    <td style="width:65%;">{{ $actividades[$i]->estado_seguimientos[0]->name }}</td>
                                </tr>

                                <tr>
                                    <td style="width:35%;"><b>Acciones realizadas: </b></td>
                                    <td style="width:65%;">{{ $actividades[$i]->acciones_adelantadas }}</td>
                                </tr>

                                <tr>
                                    <td style="width:35%;"><b>Acciones pendientes: </b></td>
                                    <td style="width:65%;">{{ $actividades[$i]->acciones_pendientes }}</td>
                                </tr>

                                <tr>
                                    <td style="width:35%;"><b>Dificultades: </b></td>
                                    <td style="width:65%;">{{ $actividades[$i]->dificultades }}</td>
                                </tr>

                                <tr>
                                    <td style="width:35%;"><b>Alternativas: </b></td>
                                    <td style="width:65%;">{{ $actividades[$i]->alternativas }}</td>
                                </tr>

                                <tr>
                                    <td style="width:35%;"><b>Resultados obtenidos: </b></td>
                                    <td style="width:65%;">{{ $actividades[$i]->resultados }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><br>
            @endfor
            @php 
                $cantidad_responsables_dos = count($actividades[$i-1]->seguimientos[0]->temas[0]->users);
            @endphp
            <h5><b>Responsable(s): </b>
                @for($j=0; $j < $cantidad_responsables_dos; $j++)
                    {{ $actividades[$i-1]->seguimientos[0]->temas[0]->users[$j]->name }} {{ $actividades[$i-1]->seguimientos[0]->temas[0]->users[$j]->last_name }}
                    @if($j != ($cantidad_responsables_dos-1))
                        ,
                    @endif
                @endfor
            </h5>
        </div>
    </div>
</body>
</html>