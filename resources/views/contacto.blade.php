
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Biblioteca Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <header class="text-center mb-4">
        <h1>Contacto</h1>
        <nav>
            <a href="/" class="btn btn-link">Inicio</a>
            <a href="/favoritos" class="btn btn-link">Favoritos</a>
            <a href="/libros/crear" class="btn btn-link">Agregar Libro</a>
        </nav>
    </header>

    <main>
        <h2>Envíanos un Mensaje</h2>
        <form action="/contacto/enviar" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </main>

    <footer class="text-center mt-5">
        <p>© 2024 Biblioteca Aurora</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


