<template>
    <div class="container mt-5">
        <h2>Agregar Nuevo Libro</h2>
        <form @submit.prevent="enviarFormulario" class="custom-form" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="titulo">Título</label>
                <input type="text" v-model="libro.titulo" class="form-control" id="titulo" placeholder="Título del libro" required>
            </div>
            <div class="form-group mb-3">
                <label for="autor">Autor</label>
                <input type="text" v-model="libro.autor" class="form-control" id="autor" placeholder="Autor del libro" required>
            </div>
            <div class="form-group mb-3">
                <label for="categoria_id">Categoría</label>
                <select v-model="libro.categoria_id" class="form-select" id="categoria_id" required>
                    <option v-for="categoria in categorias" :value="categoria.id" :key="categoria.id">
                        {{ categoria.nombre }}
                    </option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="imagen">Imagen (Archivo)</label>
                <input type="file" @change="procesarImagen" class="form-control" id="imagen" required>
            </div>
            <button type="submit" class="btn-custom">Agregar Libro</button>
        </form>
        <button @click="volverInicio" class="btn btn-link mt-3">Volver a Inicio</button>
    </div>
</template>

<script>
import axios from 'axios';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css'; // Importa los estilos de Toastify

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
        procesarImagen(event) {
            const file = event.target.files[0];
            if (file && file.size < 2 * 1024 * 1024) { // Máximo 2MB
                this.libro.imagen = file;
            } else {
                Toastify({
                    text: "La imagen es demasiado grande (máximo 2MB).",
                    duration: 3000,
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)"
                }).showToast();
            }
        },

        async enviarFormulario() {
            try {
                const formData = new FormData();
                formData.append('titulo', this.libro.titulo);
                formData.append('autor', this.libro.autor);
                formData.append('categoria_id', this.libro.categoria_id);
                if (this.libro.imagen) {
                    formData.append('imagen', this.libro.imagen);
                }

                // Envía la solicitud POST a la API
                const response = await axios.post('/api/libros', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                // Muestra notificación de éxito
                Toastify({
                    text: "Libro agregado exitosamente.",
                    duration: 3000,
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
                }).showToast();

                this.resetForm();
            } catch (error) {
                // Muestra notificación de error
                Toastify({
                    text: "Error al agregar el libro.",
                    duration: 3000,
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)"
                }).showToast();
            }
        },

        resetForm() {
            this.libro = {
                titulo: '',
                autor: '',
                categoria_id: '',
                imagen: null
            };
            document.getElementById('imagen').value = null; // Limpiar campo imagen
        },

        volverInicio() {
            window.location.href = '/';
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: auto;
}

.custom-form {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f8f9fa;
}

.form-group {
    margin-bottom: 15px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
}

.btn-custom {
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-custom:hover {
    background-color: #0056b3;
}
</style>
