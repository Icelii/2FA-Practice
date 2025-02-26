<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
<div class="container-fluid full-height">
    <div class="row full-height">
        <div class="col-lg-7 col-md-6 col-12 d-flex flex-column">
            <a class="logo">Proyecto 1</a>
            <div class="contenedorForm">
                <span class="text1">Registrarse</span>
                <form class="formDesign" action="{{ route('register.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Escribe un nombre de usuario (máx. 150 caracteres)..." value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Ingrese su email..." value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Ingrese una contraseña (min. 8 caracteres)..." required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Ingrese una contraseña (min. 8 caracteres)..." required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 mt-3">
                        {!! NoCaptcha::renderJs('es') !!}
                        {!! NoCaptcha::display() !!}
                    </div>
                    @if ($errors->has('g-recaptcha-response'))
                        <div class="error-message">
                            {{ $errors->first('g-recaptcha-response') }}
                        </div>
                    @endif
                    <button type="submit" class="btn btnRegister">Registrarse</button>
                    <div class="aviso justify-content-center mb-3">
                        <span>¿Ya tienes cuenta? <a href="{{ route('login.form') }}">Inicia sesión aquí</a></span>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 col-md-6 d-none d-md-flex bg-color"></div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
