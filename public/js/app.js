document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.eliminar-libro-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const url = this.action;
            const data = new FormData(this);

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: data
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.card').remove(); // Elimina el libro de la vista
                    } else {
                        alert('Error al eliminar el libro.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Obtén el campo de filtro y el contenedor de libros
    const filtroInput = document.getElementById('filtro');
    const librosContainer = document.getElementById('libros-container');

    // Función para filtrar los libros
    function filtrarLibros() {
        const filtroTexto = filtroInput.value.toLowerCase();
        const libros = librosContainer.querySelectorAll('.libro-item');

        libros.forEach(libro => {
            const titulo = libro.querySelector('.card-title').textContent.toLowerCase();
            const autor = libro.querySelector('.card-text').textContent.toLowerCase();

            // Muestra u oculta el libro basado en el texto del filtro
            if (titulo.includes(filtroTexto) || autor.includes(filtroTexto)) {
                libro.style.display = '';
            } else {
                libro.style.display = 'none';
            }
        });
    }

    // Añade un evento de entrada al campo de filtro
    filtroInput.addEventListener('input', filtrarLibros);
});

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate__fadeIn');
        }
    });
});

document.querySelectorAll('.card').forEach(card => {
    observer.observe(card);
});
document.addEventListener('DOMContentLoaded', () => {
    const lazyImages = document.querySelectorAll('.lazy-img');

    const lazyLoad = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const lazyImage = entry.target;
                lazyImage.src = lazyImage.dataset.src;
                lazyImage.classList.remove('lazy-img');
                observer.unobserve(lazyImage);
            }
        });
    };

    const observer = new IntersectionObserver(lazyLoad, {
        rootMargin: '0px',
        threshold: 0.1
    });

    lazyImages.forEach(image => {
        observer.observe(image);
    });
});


const categoriaBotones = document.querySelectorAll('.categoria-btn');

categoriaBotones.forEach(function(boton) {
    boton.addEventListener('click', function() {
        const categoriaId = boton.getAttribute('data-categoria-id');

        // Realizar la solicitud AJAX para obtener los libros de la categoría seleccionada
        fetch(`/libros/categoria/${categoriaId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Limpiar el contenedor de libros actual
                    librosContainer.innerHTML = '';

                    // Agregar los nuevos libros al contenedor
                    data.libros.forEach(libro => {
                        const libroHtml = `
                                    <div class="col-md-4 libro-item" data-libro-id="${libro.id}">
                                        <div class="card mb-4">
                                            <img src="${libro.imagen}" class="card-img-top" alt="Portada del Libro" style="width: 100%; height: auto;">
                                            <div class="card-body">
                                                <h5 class="card-title">Título: ${libro.titulo}</h5>
                                                <p class="card-text">Autor: ${libro.autor}</p>
                                                <form action="/favoritos/${libro.id}" method="POST" class="agregar-favorito-form">
                                                    <button type="submit" class="btn btn-primary">Agregar a Favoritos</button>
                                                </form>
                                                <button type="button" class="btn btn-danger eliminar-libro-btn">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                `;
                        librosContainer.insertAdjacentHTML('beforeend', libroHtml);
                    });
                } else {
                    console.error('Error al cargar los libros de la categoría.');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
            });
    });
});




