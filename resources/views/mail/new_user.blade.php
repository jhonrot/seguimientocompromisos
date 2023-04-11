<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Usuario nuevo</title>
</head>
<body>
    <p>Hola! Se ha creado un usuario con tu correo electrónico.</p>
    <p>Estos son los datos del usuario:</p>
    <ul>
        <li>Nombres y apellidos: {{ $user->name }} {{ $user->last_name }}</li>
        <li>Cédula: {{ $user->num_document }}</li>
        <li>Correo: {{ $user->email }}</li>
    </ul>
    <p>Dado que su contraseña es de uso personal e intransferible, le recomendamos "Recordar contraseña",
        para ello vaya a este <a target="blank" href="http://seguimientocompromisos.calivirtual.net/">link</a> http://seguimientocompromisos.calivirtual.net/
    </p>
    <p>Gracias por la atención prestada</p>
    <p>Atte. Seguimiento compromiso Cali</p>
</body>
</html>