<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Compromiso Alerta</title>
</head>
<body>
    <p>Hola!</p>
    <p>La fecha de cumplimiento del compromiso esta proxima:</p>
    <ul>
        <li>
            @php 
                $date1 = new DateTime(date('Y-m-d'));

                $date2 = new DateTime($tema->fecha_cumplimiento);
                $dias_cant = ($date1->diff($date2))->format("%r%a");
            @endphp
            Vence en: {{ $dias_cant }} día(s)
        </li>
        <li>Compromiso: {{ $tema->tema }}</li>
        <li>Fecha cumplimiento: {{ $tema->fecha_cumplimiento }}</li>
        <li>Usuario(s) responsable(s):
            <ul>
                @foreach($tema->users as $resp)
                    <li>{{ $resp->name }} {{ $resp->last_name }}</li>
                @endforeach
            </ul>
        </li><br>
        <li>Estado: {{ $tema->estado_seguimientos[0]->name}}</li>
    </ul>
    <p>Para verlo por favor ingrese al siguiente <a target="blank" href="http://seguimientocompromisos.calivirtual.net/">link</a> http://seguimientocompromisos.calivirtual.net/
    </p>
    <p>Gracias por la atención prestada</p>
    <p>Atte. Seguimiento compromiso Cali</p>
</body>
</html>