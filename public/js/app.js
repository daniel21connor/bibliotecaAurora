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






