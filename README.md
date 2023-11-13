# Requisitos e Instalación

Tras clonar el repositorio será necesario levantar el contenedor si estamos en local o configurar el servidor con ciertos servicios.

## Entorno local
- Necesitamos Docker instalado en el sistema

## Entorno servidor
- Si el servidor está dockerizado solo sería necesario docker
- PHP Mínimo 7.4
- Composer 2.0.7 (ultima versión de composer compatible con PHP 7.4)
- memcached 3.2.0 (ultima versión de composer compatible con PHP 7.4)

```
#levantamos contenedor
docker-compose up -d --build
#instalamos dependencias
docker-compose exec php-fpm exec composer install
```

Es necesario replicar .env.example para crear un .env con los datos de conexión correspondientes

## Registro de usuarios
Actualmente existe una url donde puedes crear una cuenta gratuita con tiempo limitado de uso de 15 días `/register`

## Documentación
[Documentación PostMan](https://documenter.getpostman.com/view/15077525/2s8ZDSb5Hi)

## Desarrollo

Cosas a tener en cuenta:

- apiclient_v2/app/Providers/AppServiceProvider.php
Este archivo es donde vamos a declarar las clases de que queramos usar en el proyecto, controladores, labels y helpers

- apiclient_v2/app/Labels/lang.php
Este archivo ayuda a manejar los idiomas de la API, en la misma ruta se encuentran los archivos de traducción

- apiclient_v2/app/Http/Helpers
Aqui se encuentra restrictiveHelper.php y commonHelper.php, el primero sirve para la validación de los servicios contratados por el cliente, el segundo se encarga de proporcionar funciones comunes a todo el proyecto.

## Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
