<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Compromiso Prioridad alta</title>
</head>
<body>
    <p>Hola!</p>
    <p>Se ha generado un tema con prioridad alta.</p>
    <ul>
        <li>Tema: {{ $tema->descripcion }}</li>
        <li>Usuario(s) responsable(s):
            <ul>
                @foreach($tema->users as $resp)
                    <li>{{ $resp->name }} {{ $resp->last_name }}</li>
                @endforeach
            </ul>
        </li><br>
        <li>Usuario creador: {{$tema->creator[0]->name}} {{$tema->users[0]->last_name}}</li>
        <li>Fecha inicio: {{ $tema->fecha_inicio }}</li>
        <li>Fecha Maxima de cumplimiento: {{ $tema->fecha_cumplimiento }}</li>
        <li>Plazo días: {{ $tema->plazo }}</li>
        <li>Prioridad: {{ $tema->prioridades[0]->name }}</li>
        <li>Clasificación: {{ $tema->clasificaciones[0]->name}}</li>
    </ul>
    <p>Para verlo por favor ingrese al siguiente <a target="blank" href="http://seguimientocompromisos.calivirtual.net/">link</a> http://seguimientocompromisos.calivirtual.net/
    </p>
    <p>Gracias por la atención prestada</p>
    <p>Atte. Seguimiento compromiso Cali</p>
</body>
</html>