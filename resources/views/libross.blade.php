<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Libro - Biblioteca Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- Meta etiqueta para el token CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Vite para los scripts -->
    @vite(['resources/js/app.js'])
</head>
<body>
<div id="app">
    <example-component></example-component>
</div>
</body>
</html>
