<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compromisos</title>
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

            <div class="row" align="center" >
                <div class="col-sm-12">
                    <h3><b>INFORME GESTIÓN DE COMPROMISOS</b></h3>
                    <h3><b>RELACIÓN DE COMPROMISOS PENDIENTES VENCIDOS</b></h3>
                </div>
            </div><br>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered tablas" id="tabla">
                        <thead>
                            <tr>
                                <th>Usuario<br>responsable</th>
                                <th>Compromiso</th>
                                <th>Estado (No inicado,<br>En Curso)</th>
                                <th>Termino de respuesta<br>(vencido)</th>
                                <th>Usuario<br>asignador</th>
                                <th>Reunión</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($temas as $tema)
                                <tr>
                                    <td>
                                        @foreach($tema->users as $user)
                                            {{ $user->name }} {{ $user->last_name }}
                                        @endforeach
                                    </td>
                                    <td>{{ $tema->tema }}</td>
                                    <td>{{ $tema->estado_seguimientos[0]->name }}</td>

                                    <td>Vencido</td>

                                    <td>{{ count($tema->asignador)>0? $tema->asignador[0]->name." ".$tema->asignador[0]->last_name:'' }}</td>

                                    <td>{{ count($tema->tareas_despachos)>0?$tema->tareas_despachos[0]->descripcion:'' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>