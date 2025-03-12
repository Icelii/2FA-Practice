<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de verificación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
<div class="container-fluid full-height">
    <div class="row full-height">
        <div class="col-lg-7 col-md-6 col-12 d-flex flex-column">
            <a class="logo">Proyecto 1</a>
            <div class="contenedorForm">
                <span class="text1">Código de verificación</span>

                <form class="formDesign" action="{{ route('twofactor.verify') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" placeholder="Ingresa el código de verificación..." value="{{ old('code') }}">
                    </div>

                    <input type="hidden" name="signedUrl" value="{{ $signedUrl ?? old('signed_url') }}">

                    @if ($errors->has('message'))
                        <div class="invalid-feedback d-block mb-2">
                            {{ $errors->first('message') }}
                        </div>
                    @endif

                    @error('code')
                        <div class="invalid-feedback mb-2">{{ $message }}</div>
                    @enderror

                    <div class="mb-3 mt-3">
                        {!! NoCaptcha::renderJs('es') !!}
                        {!! NoCaptcha::display() !!}
                    </div>
                    @if ($errors->has('g-recaptcha-response'))
                        <div class="error-message">
                            {{ $errors->first('g-recaptcha-response') }}
                        </div>
                    @endif

                    <button type="submit" class="btn btnRegister">Verificar</button>
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
