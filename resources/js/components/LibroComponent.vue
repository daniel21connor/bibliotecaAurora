<!-- Template: Define la estructura HTML del componente -->
<template>
    <div>
        <!-- Botón para regresar al inicio -->
        <button class="btn btn-secondary mb-4" @click="regresarAlInicio">Regresar al Inicio</button>

        <h2>Libros Disponibles</h2>

        <!-- Input para filtrar libros -->
        <div class="mb-4">
            <input type="text" v-model="filtro" class="form-control" placeholder="Buscar por título o autor" />
        </div>

        <!-- Muestra mensajes de éxito o error -->
        <div v-if="mensaje" class="alert alert-success">{{ mensaje }}</div>

        <!-- Lista de libros -->
        <div class="row" v-if="libros.length">
            <!-- Itera sobre cada libro filtrado -->
            <div class="col-md-4 libro-item" v-for="libro in librosFiltrados" :key="libro.id">
                <div class="card mb-4">
                    <!-- Imagen del libro -->
                    <img :src="'/images/' + libro.imagen" class="card-img-top" alt="Portada del Libro" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <!-- Campo editable para el título -->
                        <h5 class="card-title">Título:</h5>
                        <input type="text" v-model="libro.titulo" @change="guardarCambios(libro)" class="form-control mb-2" />

                        <!-- Campo editable para el autor -->
                        <h6 class="card-subtitle mb-2">Autor:</h6>
                        <input type="text" v-model="libro.autor" @change="guardarCambios(libro)" class="form-control mb-3" />

                        <!-- Botón para eliminar el libro -->
                        <button class="btn btn-danger" @click="eliminarLibro(libro.id)">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensaje si no hay libros disponibles -->
        <div v-else>
            <p>No hay libros disponibles.</p>
        </div>
    </div>
</template>

<script>
export default {
    // Define los datos reactivos del componente
    data() {
        return {
            libros: [], // Array para almacenar los libros
            mensaje: null, // Mensaje para mostrar al usuario (éxito/error)
            filtro: '', // Texto para filtrar libros
        };
    },

    // Propiedades computadas
    computed: {
        // Filtra los libros basándose en el texto de búsqueda
        librosFiltrados() {
            return this.libros.filter(libro => {
                return libro.titulo.toLowerCase().includes(this.filtro.toLowerCase()) ||
                    libro.autor.toLowerCase().includes(this.filtro.toLowerCase());
            });
        }
    },

    // Se ejecuta cuando el componente se monta en el DOM
    mounted() {
        this.cargarLibros(); // Carga los libros al iniciar el componente
    },

    // Métodos del componente
    methods: {
        // Carga los libros desde la API
        async cargarLibros() {
            try {
                const response = await fetch('/api/libros');
                if (!response.ok) {
                    throw new Error('Error al cargar los libros');
                }
                this.libros = await response.json();
            } catch (error) {
                console.error('Error al cargar los libros:', error);
                this.mensaje = 'Error al cargar los libros. Por favor, intenta de nuevo.';
            }
        },

        // Elimina un libro específico
        async eliminarLibro(libroId) {
            if (confirm('¿Estás seguro de que deseas eliminar este libro?')) {
                try {
                    const response = await fetch(`/api/libros/${libroId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    });
                    if (!response.ok) {
                        throw new Error('Error al eliminar el libro');
                    }
                    // Elimina el libro de la lista local
                    this.libros = this.libros.filter(libro => libro.id !== libroId);
                    this.mensaje = 'Libro eliminado exitosamente.';
                } catch (error) {
                    console.error('Error en la solicitud:', error);
                    this.mensaje = 'Error al eliminar el libro. Por favor, intenta de nuevo.';
                }
            }
        },

        // Guarda los cambios de un libro editado
        async guardarCambios(libro) {
            try {
                const response = await fetch(`/api/libros/${libro.id}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        titulo: libro.titulo,
                        autor: libro.autor
                    })
                });
                if (!response.ok) {
                    throw new Error('Error al actualizar el libro');
                }
                this.mensaje = 'Libro actualizado exitosamente.';
            } catch (error) {
                console.error('Error en la solicitud:', error);
                this.mensaje = 'Error al actualizar el libro. Por favor, intenta de nuevo.';
            }
        },

        // Redirige al usuario a la página de inicio
        regresarAlInicio() {
            window.location.href = '/';
        }
    }
};
</script>

<style scoped>
/* Estilo para los elementos de libro */
.libro-item {
    cursor: pointer;
}

/* Flexbox para organizar el contenido de la tarjeta */
.card-body {
    display: flex;
    flex-direction: column;
}

/* Estilo para los inputs de texto */
.card-body input[type="text"] {
    width: 100%;
    margin-bottom: 10px;
}

/* Márgenes para títulos y subtítulos */
.card-title, .card-subtitle {
    margin-bottom: 5px;
}
</style>
