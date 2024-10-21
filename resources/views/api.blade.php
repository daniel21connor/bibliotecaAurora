<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Perfumes</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @vite(['resources/js/app.js'])
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h1>Tienda de Perfumes</h1>
<input type="text" id="search-input" placeholder="Buscar productos...">
<div id="product-list"></div>

<script>
    const token = '86|cKLH4zs9lYJwat1ocpLaI4CzLx5O9yT6pKgC5Q02de60b83b'; // Reemplaza esto con el token que tu amigo recibió

    fetch('http://192.168.56.1:8000/api/productos', {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json',
        },
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Aquí puedes manejar la lista de productos
            renderProducts(data); // Llama a la función para renderizar los productos
        })
        .catch(error => {
            console.error('Error:', error);
        });

    // Función para renderizar los productos
    function renderProducts(products) {
        const productList = document.getElementById('product-list');
        productList.innerHTML = ''; // Limpiar la lista actual
        products.forEach(product => {
            const productElement = document.createElement('div');
            productElement.classList.add('product');
            productElement.innerHTML = `
                    <h3>${product.name}</h3>
                    <p>$ ${product.price.toLocaleString('es-CO')}</p>
                    <img src="${product.image}" alt="${product.name}">
                `;
            productList.appendChild(productElement);
        });
    }
</script>
</body>
</html>
