<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <h2>Quieres recuperar tu contraseña?</h2>
        <p>Usuario: {{$user->name}}</p>
        <p>Por favor siga el siguiente enlace:</p>

        <a href="http://mundolibro.test:8020/password-recovery?reset_token={{ $user->reset_token }}">
            Recuperar contraseña
        </a>
    </div>
</body>
</html>