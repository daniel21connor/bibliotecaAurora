<template>
  <div>
    <h2>Lista de Perfumes</h2>

    <!-- Mostrar error si lo hay -->
    <div v-if="error" class="alert alert-danger">{{ error }}</div>

    <!-- Mostrar spinner mientras se cargan los datos -->
    <div v-if="loading" class="spinner-border text-primary" role="status">
      <span class="sr-only">Cargando...</span>
    </div>

    <!-- Mostrar la lista de productos cuando se cargan los datos -->
    <ul v-if="productos.length > 0" class="list-group">
      <li v-for="producto in productos" :key="producto.id" class="list-group-item">
        <strong>{{ producto.nombre }}</strong> - {{ producto.descripcion }} - Precio: ${{ producto.precio }}
        <img :src="producto.imagen" alt="Imagen del producto" width="100">
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      productos: [],  // Almacena la lista de productos
      token: 'cSqgijwPyIzhfNJIec0A25UypPUCUVueCQxIN3xm46058b27',  // Token fijo
      error: null,    // Almacena mensajes de error
      loading: false  // Estado de carga
    };
  },
  mounted() {
    this.fetchProductos(); // Llama a la función al montar el componente
  },
  methods: {
    fetchProductos() {
      this.loading = true; // Comienza la carga
      axios.get('http://3.140.239.144/api/productos', {
        headers: {
          'Authorization': `Bearer ${this.token}`,  // Agrega el token en los headers
          'Accept': 'application/json'              // Asegura que la solicitud se haga como JSON
        }
      })
          .then(response => {
            if (Array.isArray(response.data)) {
              this.productos = response.data;  // Guarda los datos de productos
            } else {
              this.error = 'Los datos recibidos no son válidos.'; // Maneja el error
              console.error('Datos recibidos:', response.data);  // Para depuración
            }
          })
          .catch(error => {
            // Manejo de errores
            if (error.response) {
              this.error = `Error ${error.response.status}: ${error.response.data.message || error.response.statusText}`;
              console.error('Error con respuesta:', error.response);
            } else if (error.request) {
              this.error = 'No se recibió una respuesta del servidor.';
              console.error('Error en la solicitud:', error.request);
            } else {
              this.error = `Error al cargar los datos: ${error.message}`;
              console.error('Error:', error.message);
            }
          })
          .finally(() => {
            this.loading = false; // Termina la carga
          });
    }
  }
};
</script>

<style>
.spinner-border {
  display: block;
  margin: 20px auto;
}
</style>
