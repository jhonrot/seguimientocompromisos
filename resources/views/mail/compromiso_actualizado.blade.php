<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Compromiso Actualizado</title>
</head>
<body>
    <p>Hola!</p>
    <p>
    @if($tema->estado_id == 3)
        El siguiente compromiso ha sido cumplido:
    @else
        @if($estado == $tema->estado_id)
            El siguiente compromiso ha sido actualizado:
        @else
            El siguiente compromiso ha presentado una novedad en su estado de cumplimiento:
        @endif
    @endif  
    </p>
    <ul>
        <li>Compromiso: {{ $tema->tema }}</li>
        <li>Usuario asignador: {{ $tema->asignador[0]->name }} {{ $tema->asignador[0]->last_name}}</li>
        <li>Fecha de cumplimiento: {{ $tema->fecha_cumplimiento }}</li>
        <li>Usuario(s) responsable(s):
            <ul>
                @foreach($tema->users as $resp)
                    <li>{{ $resp->name }} {{ $resp->last_name }}</li>
                @endforeach
            </ul>
        </li><br>
        <li>Estado: {{ $tema->estado_seguimientos[0]->name}}</li>
    </ul>
    <p>Por favor tener en cuenta que sólo a través de la aplicación se evaluará el avance de su compromiso, ingrese al siguiente <a target="blank" href="http://seguimientocompromisos.calivirtual.net/">link</a> http://seguimientocompromisos.calivirtual.net/</p>
    <p>Use las mismas credenciales que utiliza en la aplicación de gestión de contratación de PS.</p>
    <p>Si tiene observaciones sobre el compromiso comuniquese con la persona que le asignó el compromiso.</p>
    <p>En el siguiente link encontrará el instructivo para estructurar el plan de trabajo en tareas con fechas de cumplimiento:</p>
    <br>
    <p>Gracias por la atención prestada</p>
    <p>Atte. Seguimiento compromiso Cali</p>
</body>
</html>