<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos - Biblioteca Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .card-img-top {
            width: 100%;
            height: 250px; /* Ajusta la altura de la imagen */
            object-fit: cover; /* Mantiene la proporción de la imagen */
        }
        .card {
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.03);
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <header class="text-center mb-4">
        <!-- Botón para volver al inicio, movido arriba -->
        <a href="{{ route('home') }}" class="btn btn-link">Volver al Inicio</a>
        <h1>Favoritos</h1>
        <!-- Campo de búsqueda -->
        <input type="text" id="search" class="form-control mt-3" placeholder="Buscar en favoritos...">
    </header>

    <main>
        <h2 class="mb-4">Libros Favoritos</h2>
        <div class="row" id="favorites-list">
            @if($favoritos->isEmpty())
                <p>No tienes libros favoritos.</p>
            @else
                @foreach($favoritos as $favorito)
                    <div class="col-md-4 card-item" data-titulo="{{ strtolower($favorito->libro->titulo) }}" data-autor="{{ strtolower($favorito->libro->autor) }}">
                        <div class="card mb-4">
                            <img src="{{ asset('images/' . $favorito->libro->imagen) }}" class="card-img-top" alt="Portada del Libro">
                            <div class="card-body">
                                <h5 class="card-title">Título: {{ $favorito->libro->titulo }}</h5>
                                <p class="card-text">Autor: {{ $favorito->libro->autor }}</p>
                                <form action="{{ route('eliminarFavorito', ['id' => $favorito->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar de Favoritos</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>

    <footer class="text-center mt-5">
        <!-- Botón para volver al inicio, movido arriba -->
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Funcionalidad de búsqueda dinámica
        const searchInput = document.getElementById('search');
        const cardItems = document.querySelectorAll('.card-item');

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();

            cardItems.forEach(item => {
                const titulo = item.getAttribute('data-titulo');
                const autor = item.getAttribute('data-autor');

                if (titulo.includes(searchTerm) || autor.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
</body>
</html>
