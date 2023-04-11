<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Seguimiento Tema completado</title>
</head>
<body>
    <p>Hola! Se ha llenado el campo dificultades presentadas en Actividad de compromiso.</p>
    <p>Compromiso: </p>
    <ul>
        <li>Compromiso: {{ $seguimiento->temas[0]->descripcion }}</li>
        <li>Prioridad: {{ $seguimiento->temas[0]->prioridades[0]->name }}</li>
        <li>Fecha inicio: {{ $seguimiento->temas[0]->fecha_inicio }}</li>
        <li>Fecha Maxima de cumplimiento: {{ $seguimiento->temas[0]->fecha_cumplimiento }}</li>
        <li>Plazo días: {{ $seguimiento->temas[0]->plazo }}</li>
        <li>Clasificación: {{ $seguimiento->temas[0]->clasificaciones[0]->name}}</li>
        <li>Usuario creador: {{ $seguimiento->temas[0]->creator[0]->name}} {{ $seguimiento->temas[0]->creator[0]->last_name}}</li>
        <li>Usuario(s) responsable(s):</li>
        <ul>
            @foreach($seguimiento->temas[0]->users as $resp)
                <li>{{ $resp->name }} {{ $resp->last_name }}</li>
            @endforeach
        </ul><br>
    </ul>
    <ul>
        <li>Fecha actividad: {{ $seguimiento->fecha }}</li>
        <li>Avance: {{ $seguimiento->avance }} %</li>
    </ul>  
    <ul>
        <li>Dificultades presentadas: {{ $seguimiento->dificultades }}</li>
    </ul>
    <p>Para verlo por favor ingrese al siguiente <a target="blank" href="http://seguimientocompromisos.calivirtual.net/">link</a> http://seguimientocompromisos.calivirtual.net/
    </p>
    <p>Gracias por la atención prestada</p>
    <p>Atte. Seguimiento compromiso Cali</p>
</body>
</html>