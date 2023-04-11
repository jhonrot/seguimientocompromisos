<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reunion</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" media="screen" />
    <style>
        .page-break {
            page-break-after: always;
        }
        .justity{
            text-align:justify;
        }
        .row {
            margin-right: -15px;
            margin-left: -15px;
        }
        .col-sm-4, .col-sm-8{
            position: relative;
            min-height: 1px;
            padding-right: 1px;
            padding-left: 1px;
            float: left;
        }
        .col-sm-4 {
            width: 33.33333333%;
        }
        .col-sm-8 {
            width: 66.66666667%;
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

            <div class="row" align="center" >
                <h1>Informe de Gestión a compromisos</h1>
            </div><br>

            @php 
                $cant_reuniones = count($reunion); 
                $date1 = new DateTime(date('Y-m-d'));
            @endphp

            @for($j=0; $j < $cant_reuniones; $j++)
                @if($j>0)
                    <div style="page-break-after:always;"></div>
                @endif

                <div class="row">
                    <div class="col-sm-4">
                        <b>Id:  </b>
                    </div>
                    <div class="col-sm-8 justity">
                        <p>{{ $reunion[$j]->id }}</p>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-4">
                        <b>Reunión:  </b>
                    </div>
                    <div class="col-sm-8 justity">
                        <p>{{ $reunion[$j]->descripcion }}</p>
                    </div>
                </div><br>

                <!--<div class="row">
                    <div class="col-sm-4">
                        <b>Compromiso de la reunión:  </b>
                    </div>
                    <div class="col-sm-8 justity">
                        <p>{{ count($reunion[$j]->seguimientos)>0?$reunion[$j]->seguimientos[0]->temas[0]->tema:'No tiene' }}</p>
                    </div>
                </div><br>-->

                <div class="row">
                    <div class="col-sm-4">
                        <b>Fecha de inicio: </b>
                    </div>
                    <div class="col-sm-8 justity">
                        {{ $reunion[$j]->fecha_reunion }}
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-4">
                        <b>Hora de la reunión: </b>
                    </div>
                    <div class="col-sm-8 justity">
                        {{ $reunion[$j]->hora_reunion }}
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-4">
                        <b>Asignador: </b>
                    </div>
                    <div class="col-sm-8 justity">
                        <p>{{ $reunion[$j]->creador[0]->name." ".$reunion[$j]->creador[0]->last_name }}</p>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-4">
                        <b>Objetivo de la reunión: </b>
                    </div>
                    <div class="col-sm-8 justity">
                        <p>{{ $reunion[$j]->objetivo }}</p>
                    </div>
                </div><br>
                
                <div class="row">
                    <div class="col-sm-4">
                        <b>Asistentes: </b>
                    </div>
                    <div class="col-sm-8 justity">
                        <p>{{ $reunion[$j]->asistentes }}</p>
                    </div>
                </div><br>
                
                <div class="row">      
                    <div class="col-sm-4">
                        <b>Orden del día: </b>
                    </div>
                    <div class="col-sm-8 justity">
                        {{ $reunion[$j]->orden }}
                    </div>
                </div><br>
                
                <div class="row">      
                    <div class="col-sm-4">
                        <b>Desarrollo de la reunión: </b>
                    </div>
                    <div class="col-sm-8 justity">
                        {!! nl2br($reunion[$j]->desarrollo) !!}
                    </div>
                </div><br>

                <div class="row">      
                    <div class="col-sm-4">
                        <b>Responsable del registro de la reunión: </b>
                    </div>
                    <div class="col-sm-8 justity">
                        {{ count($reunion[$j]->creador)>0?$reunion[$j]->creador[0]->name." ".$reunion[$j]->creador[0]->last_name:'' }}
                    </div>
                </div><br><br>

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table table-bordered" id="tabla" >
                            <thead style="color:white;background-color:#078930;" >
                                <tr>
                                    <th scope="col" ><b>Compomiso</b></th>
                                    <th scope="col" ><b>Estado</b></th>
                                    <th scope="col" ><b>Termino de respuesta o alerta</b></th>
                                    <th scope="col" ><b>Avance</b></th>
                                    <th scope="col" ><b>Responsable(s)</b></th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $cant_seguimientos = count($reunion[$j]->seguimientos); @endphp
                                @if($cant_seguimientos == 0)
                                    <tr>
                                        <td>Ninguno</td>
                                        <td>Ninguno</td>
                                        <td>Ninguno</td>
                                        <td>Ninguno</td>
                                        <td>Ninguno</td>
                                    </tr>
                                @endif
                                @for($i=0; $i < $cant_seguimientos; $i++)
                                    <tr>
                                        <td>{!! nl2br($reunion[$j]->seguimientos[$i]->temas[0]->tema) !!}</td>
                                        <td>{{ $reunion[$j]->seguimientos[$i]->temas[0]->estado_seguimientos[0]->name }}</td>
                                        <td>
                                            @php        
                                                $date2 = new DateTime($reunion[$j]->seguimientos[$i]->temas[0]->fecha_cumplimiento);
                                                $dias_cant = ($date1->diff($date2))->format("%r%a");
                                            @endphp

                                            @if($reunion[$j]->seguimientos[$i]->temas[0]->estado_seguimientos[0]->id == 1 && $dias_cant > 15)
                                                <h6 style="color: blue;" ><b>A tiempo</b></h6>
                                            @endif

                                            @if($reunion[$j]->seguimientos[$i]->temas[0]->estado_seguimientos[0]->id == 1 && $dias_cant >= 0 && $dias_cant < 15)
                                                <h6 style="color: orange;" ><b>Próximo a vencer</b></h6>
                                            @endif

                                            @if($reunion[$j]->seguimientos[$i]->temas[0]->estado_seguimientos[0]->id == 1 && $dias_cant < 0)
                                                <h6 style="color: red;" ><b>Vencido</b></h6>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            @php 
                                                $cant = 0;
                                                foreach($reunion[$j]->seguimientos[$i]->temas[0]->seguimientos as $seguimiento){
                                                    $cant = ($cant+(($seguimiento->avance * $seguimiento->ponderacion)/100));
                                                }
                                            @endphp

                                            {{$cant}} %

                                        </td>
                                        <td>
                                            @foreach($reunion[$j]->seguimientos[$i]->temas[0]->users as $user)
                                                {{$user->name}} {{$user->last_name}}<br> 
                                            @endforeach
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</body>
</html>