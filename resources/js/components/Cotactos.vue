<template>
    <div class="container mt-5">
        <header class="text-center mb-4">
            <h1>Encuéntranos</h1>
            <nav>
                <a href="/" class="btn btn-link" :class="{ active: activeLink === 'inicio' }" @click="setActiveLink('inicio')">Inicio</a>
                <a href="/favoritos" class="btn btn-link" :class="{ active: activeLink === 'favoritos' }" @click="setActiveLink('favoritos')">Favoritos</a>
                <a href="/libros/crear" class="btn btn-link" :class="{ active: activeLink === 'agregar' }" @click="setActiveLink('agregar')">Agregar Libro</a>
            </nav>
        </header>

        <main>
            <div id="carouselExampleCaptions" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://thescreenfandome.com/wp-content/uploads/2024/05/tumblr_839fe026839e668f51470d45788fe6d0_256272fe_1280.jpg" class="d-block w-100" alt="Imagen 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="carousel-title">Fundadora De la Biblioteca Aurora</h5>
                            <p class="carousel-description">Aurora Fundó Esta Biblioteca en 2023.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://centrohistorico.gt/wp-content/uploads/2018/11/biblioteca-04.jpg" class="d-block w-100" alt="Imagen 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="carousel-title">Visítanos En Nuestra Sucursal Principal</h5>
                            <p class="carousel-description">Esta Biblioteca Se Encuentra En Zona 1 En El Edificio Aurora.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <a href="https://www.aurora-music.com">
                            <img src="https://images.squarespace-cdn.com/content/v1/564197f7e4b0d582d75163e1/1625894861380-RH4O9YPFICH3ZYRF515E/a1.jpg?format=1000w" class="d-block w-100" alt="Imagen 3">
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="carousel-title">¡Descubre Más Sobre Nosotros!</h5>
                                <p class="carousel-description">Haz clic aquí para obtener más información.</p>
                            </div>
                        </a>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </main>

        <footer class="text-center mt-5">
            <p>© 2024 Biblioteca Aurora</p>
        </footer>
    </div>
</template>

<script>
export default {
    data() {
        return {
            activeLink: '' // Estado para el enlace activo
        };
    },
    methods: {
        setActiveLink(link) {
            this.activeLink = link;
        }
    }
};
</script>

<style scoped>
/* Estilos personalizados para el carrusel de imágenes */
body {
    background-color: #f8f9fa;
}

h1 {
    font-family: 'Merriweather', serif;
    font-size: 2.5rem;
    font-weight: bold;
    color: #343a40;
    margin-bottom: 1.5rem;
}

nav a {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0 0.5rem;
    transition: color 0.3s ease, background-color 0.3s ease;
}

nav a.active {
    color: #fff;
    background-color: #007bff; /* Cambia el color de fondo cuando el enlace está activo */
    border-radius: 5px;
    padding: 0.5rem 1rem;
}

.carousel {
    width: 100%;
    max-width: 800px; /* Tamaño máximo del carrusel */
    margin: 0 auto;
}

.carousel-inner {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.carousel-item {
    height: 400px; /* Ajusta el alto de las imágenes */
}

.carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Asegura que la imagen cubra el contenedor */
}

.carousel-caption {
    background-color: rgba(0, 0, 0, 0.5);
    padding: 1rem;
    border-radius: 0.5rem;
    bottom: 20px;
}

.carousel-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #f8f9fa;
}

.carousel-description {
    font-size: 1.1rem;
    color: #f8f9fa;
}

footer {
    margin-top: 2rem;
    font-size: 0.9rem;
}
</style>
