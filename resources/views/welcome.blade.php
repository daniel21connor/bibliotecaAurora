<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Aurora - Inicio</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .background-container {
            position: fixed; /* Asegura que el contenedor esté fijado en la pantalla */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            z-index: -1; /* Coloca el contenedor detrás del contenido principal */
        }
    </style>
</head>
<body class="bg-light">
<!-- Contenedor para el fondo dinámico -->
<div class="background-container"></div>

<div class="container mt-5">
    <header class="text-center mb-4">
        <h1>Biblioteca Aurora</h1>
        <nav>
            <a href="{{ route('mostrarLibros', ['categoriaId' => 1]) }}" class="btn btn-link">Literatura</a>
            <a href="{{ route('mostrarLibros', ['categoriaId' => 2]) }}" class="btn btn-link">Filosofía</a>
            <a href="{{ route('mostrarLibros', ['categoriaId' => 3]) }}" class="btn btn-link">Poesía</a>
        </nav>
        <a href="{{ route('crearLibro') }}" class="btn btn-success mt-3">Agregar Libro</a>
    </header>

    <main>
        <h2 class="mb-4">Libros Disponibles</h2>
        <div class="mb-4">
            <input type="text" id="filtro" class="form-control" placeholder="Buscar por título o autor">
        </div>

        <div class="row" id="libros-container">
            @if (isset($libros) && $libros->count() > 0)
                @foreach ($libros as $libro)
                    <div class="col-md-4 libro-item">
                        <div class="card mb-4">
                            <img src="{{ asset('images/' . $libro->imagen) }}" class="card-img-top" alt="Portada del Libro" style="width: 100%; height: auto;">
                            <div class="card-body">
                                <h5 class="card-title">Título: {{ $libro->titulo }}</h5>
                                <p class="card-text">Autor: {{ $libro->autor }}</p>
                                <form action="{{ route('agregarFavorito', ['libroId' => $libro->id]) }}" method="POST" class="agregar-favorito-form">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Agregar a Favoritos</button>
                                </form>
                                <form action="{{ route('eliminarLibro', ['id' => $libro->id]) }}" method="POST" class="eliminar-libro-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No hay libros disponibles en esta categoría.</p>
            @endif
        </div>
    </main>

    <footer class="text-center mt-5">
        <p>© 2024 Biblioteca Aurora</p>
        <a href="{{ route('verFavoritos') }}" class="btn btn-link">Ver Favoritos</a>
        <a href="{{ route('verContacto') }}" class="btn btn-link">Contacto</a>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backgroundContainer = document.querySelector('.background-container');
        const images = [
            'https://img.freepik.com/vector-gratis/interior-biblioteca-sala-vacia-leer-libros-estantes-madera_33099-1722.jpg?size=626&ext=jpg&ga=GA1.1.2008272138.1724198400&semt=ais_hybrid',
            'https://img.freepik.com/vector-premium/biblioteca-estantes-caricatura-vector-ilustracion-escaleras-hecho-libros-puerta-abierta-forma-libro-grande-pila-libros_273525-1540.jpg',
            'https://e1.pxfuel.com/desktop-wallpaper/154/108/desktop-wallpaper-aurora-singer.jpg'
        ];

        if (!backgroundContainer) {
            console.error('No se encontró el contenedor del fondo.');
            return;
        }

        let currentIndex = 0;

        function changeBackground() {
            currentIndex = (currentIndex + 1) % images.length;
            backgroundContainer.style.backgroundImage = `url('${images[currentIndex]}')`;
        }

        // Cambia el fondo cada 5 segundos
        setInterval(changeBackground, 5000);

        // Inicializa con la primera imagen
        changeBackground();
    });
</script>
</body>
</html>
