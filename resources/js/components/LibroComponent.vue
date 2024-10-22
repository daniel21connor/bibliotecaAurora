<template>
    <div>
        <button class="btn btn-secondary mb-4" @click="regresarAlInicio">Regresar al Inicio</button>

        <h2>Libros Disponibles</h2>

        <div class="mb-4">
            <input type="text" v-model="filtro" class="form-control" placeholder="Buscar por título o autor" />
        </div>

        <div v-if="mensaje" class="alert alert-success">{{ mensaje }}</div>

        <div class="row" v-if="librosFiltrados.length">
            <div class="col-md-4 libro-item" v-for="libro in librosFiltrados" :key="libro.id">
                <div class="card mb-4">
                    <!-- Mostrar la imagen desde la URL -->
                    <img :src="libro.imagen" class="card-img-top" alt="Portada del Libro" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <!-- Título del libro editable -->
                        <h5 class="card-title">Título:</h5>
                        <input type="text" v-model="libro.titulo" @change="guardarCambios(libro)" class="form-control mb-2" />

                        <!-- Autor del libro editable -->
                        <h6 class="card-subtitle mb-2">Autor:</h6>
                        <input type="text" v-model="libro.autor" @change="guardarCambios(libro)" class="form-control mb-3" />

                        <!-- Botón para eliminar el libro -->
                        <button class="btn btn-danger" @click="eliminarLibro(libro.id)">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
            <p>No hay libros disponibles.</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            libros: [],
            mensaje: null,
            filtro: '',
        };
    },

    computed: {
        librosFiltrados() {
            return this.libros.filter(libro => {
                return libro.titulo.toLowerCase().includes(this.filtro.toLowerCase()) ||
                    libro.autor.toLowerCase().includes(this.filtro.toLowerCase());
            });
        }
    },

    mounted() {
        this.cargarLibros();
    },

    methods: {
        async cargarLibros() {
            try {
                const token = localStorage.getItem('token');
                const token1 = '4|7zRejOmOkb67njVQp0fQkCbsVtPnJl8dsKanaewZd73984b5'
                const response = await axios.get('/api/libros', {
                    headers: {
                        'Authorization': `Bearer ${token1}`
                    }
                });
                this.libros = response.data;
            } catch (error) {
                console.error('Error al cargar los libros:', error);
                this.mensaje = 'Error al cargar los libros. Por favor, intenta de nuevo. ' + (error.response?.data?.error || error.message);
            }
        },

        async eliminarLibro(libroId) {
            if (confirm('¿Estás seguro de que deseas eliminar este libro?')) {
                try {
                    await axios.delete(`/api/libros/${libroId}`);
                    this.libros = this.libros.filter(libro => libro.id !== libroId);
                    this.mensaje = 'Libro eliminado exitosamente.';
                } catch (error) {
                    console.error('Error al eliminar el libro:', error);
                    this.mensaje = 'Error al eliminar el libro. Por favor, intenta de nuevo. ' + (error.response?.data?.error || error.message);
                }
            }
        },

        async guardarCambios(libro) {
            try {
                await axios.put(`/api/libros/${libro.id}`, {
                    titulo: libro.titulo,
                    autor: libro.autor
                });
                this.mensaje = 'Libro actualizado exitosamente.';
            } catch (error) {
                console.error('Error al actualizar el libro:', error);
                this.mensaje = 'Error al actualizar el libro. Por favor, intenta de nuevo. ' + (error.response?.data?.error || error.message);
            }
        },

        regresarAlInicio() {
            window.location.href = '/';
        }
    }
};
</script>

<style scoped>
/* Estilos para la tarjeta de cada libro */
.libro-item {
    cursor: pointer;
}

.card-body {
    display: flex;
    flex-direction: column;
}

/* Estilo para los inputs dentro de cada tarjeta */
.card-body input[type="text"] {
    width: 100%;
    margin-bottom: 10px;
}

/* Espaciado entre el título y subtítulo */
.card-title, .card-subtitle {
    margin-bottom: 5px;
}
</style>
