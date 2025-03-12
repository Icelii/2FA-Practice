<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Proyecto Laravel 9 - Autenticación con Doble Factor y reCAPTCHA

Este proyecto es una aplicación web desarrollada en Laravel 9 que implementa un sistema de autenticación con doble factor (2FA) y reCAPTCHA de Google, así como un sistema de registro de usuarios.

## Características

- **Registro de usuarios.**
- **Inicio de sesión con autenticación de doble factor (2FA).**
- **Implementación de Google reCAPTCHA en el login y registro.**

## Requisitos previos

Antes de comenzar, asegúrate de tener instalado:
- **PHP >= 8.0**
- **Composer**
- **MySQL**
- **Laravel 9**
- **Una cuenta en Google reCAPTCHA para obtener las claves de API.**

## Instalación

### 1. Clonar el repositorio

```bash
 git clone https://github.com/Icelii/2FA-Practice
 cd 2FA-Practice
```

### 2. Instalar dependencias

```bash
 composer install
```

### 3. Configurar variables de entorno

Copia el archivo de ejemplo y configúralo:

```bash
 cp .env.example .env
```

Edita el archivo `.env` y configura la conexión a la base de datos, así como las claves de reCAPTCHA:

```
 DB_CONNECTION=mysql
 DB_HOST=127.0.0.1
 DB_PORT=3306
 DB_DATABASE=bd
 DB_USERNAME=username
 DB_PASSWORD=password

 RECAPTCHA_SITE_KEY=your_public_key
 RECAPTCHA_SECRET_KEY=your_secret_key
```

### 4. Generar la clave de aplicación

```bash
 php artisan key:generate
```

### 5. Ejecutar migraciones y seeders

```bash
 php artisan migrate --seed
```

### 6. Iniciar el servidor

```bash
 php artisan serve
```

La aplicación estará disponible en `http://127.0.0.1:8000`.

## Uso

1. Regístrate en la aplicación con un correo válido.
2. Activa tu cuenta mediante el correo enviado.
3. Inicia sesión y verifica la autenticación de doble factor.
4. Introduce el código enviado para completar el acceso.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
