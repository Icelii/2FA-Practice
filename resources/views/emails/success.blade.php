<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éxito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .btnLogin{
        color: white;
        font-weight: bold;
        background-color: #87ACC1;
    }
</style>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="text-center">
        <h1 class="fw-bold">Cuenta activada con exito!!!</h1>
        <iframe src="https://giphy.com/embed/2GkgBZNzk5p4Otg2sv" width="220" height="280" style="" frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p></p>
        <p>{{ $message }}</p>
        <a href="{{ route('login.form') }}" class="btn btnLogin">Iniciar sesión</a>
    </div>
</body>
</html>
