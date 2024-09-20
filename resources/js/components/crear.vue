<template>
    <div class="container mt-5">
        <header class="text-center mb-4">
            <h1>Agregar Nuevo Libro</h1>
        </header>

        <main>
            <!-- Formulario para agregar un libro -->
            <form @submit.prevent="enviarFormulario" enctype="multipart/form-data">
                <!-- Campo para el título del libro -->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" v-model="libro.titulo" required>
                </div>

                <!-- Campo para el autor del libro -->
                <div class="mb-3">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" class="form-control" id="autor" v-model="libro.autor" required>
                </div>

                <!-- Campo para seleccionar la categoría del libro -->
                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoría</label>
                    <select class="form-select" id="categoria_id" v-model="libro.categoria_id" required>
                        <option v-for="categoria in categorias" :value="categoria.id" :key="categoria.id">
                            {{ categoria.nombre }}
                        </option>
                    </select>
                </div>

                <!-- Campo para cargar una imagen del libro -->
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" @change="procesarImagen">
                </div>

                <!-- Botón para enviar el formulario -->
                <button type="submit" class="btn btn-primary">Agregar Libro</button>
            </form>
        </main>

        <!-- Botón para volver al inicio -->
        <footer class="text-center mt-5">
            <button @click="volverInicio" class="btn btn-link">Volver a Inicio</button>
        </footer>
    </div>
</template>

<script>
export default {
    data() {
        return {
            libro: {
                titulo: '',
                autor: '',
                categoria_id: '',
                imagen: null
            },
            categorias: [
                { id: 1, nombre: 'Literatura' },
                { id: 2, nombre: 'Filosofía' },
                { id: 3, nombre: 'Poesía' }
            ]
        };
    },
    methods: {
        // Maneja el cambio en el campo de imagen
        procesarImagen(event) {
            const file = event.target.files[0];
            if (file && file.size < 2 * 1024 * 1024) {  // Verifica que la imagen no exceda los 2MB
                this.libro.imagen = file;
            } else {
                alert('La imagen es demasiado grande. Por favor selecciona una imagen de menos de 2MB.');
            }
        },

        // Envía el formulario para agregar un libro
        enviarFormulario() {
            const formData = new FormData();
            formData.append('titulo', this.libro.titulo);
            formData.append('autor', this.libro.autor);
            formData.append('categoria_id', this.libro.categoria_id);
            if (this.libro.imagen) {
                formData.append('imagen', this.libro.imagen);
            }

            // Obtén el token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Realiza la solicitud POST
            fetch('/libros', {  // Asegúrate de que la ruta sea la correcta
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Libro agregado exitosamente');
                        this.resetForm();
                    } else {
                        alert('Error al agregar el libro: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un problema al agregar el libro.');
                });
        },

        // Resetea el formulario después de enviar los datos
        resetForm() {
            this.libro = {
                titulo: '',
                autor: '',
                categoria_id: '',
                imagen: null
            };
            document.getElementById('imagen').value = null;  // Limpia el campo de imagen
        },

        // Redirige al usuario a la página de inicio
        volverInicio() {
            window.location.href = '/'; // Redirecciona a la página principal
        }
    }
};
</script>

<style scoped>
/* Estilos personalizados */
.container {
    max-width: 600px;
    margin: 0 auto;
}

h1 {
    font-size: 2rem;
    margin-bottom: 1.5rem;
}

footer button {
    font-size: 1rem;
}
</style>
