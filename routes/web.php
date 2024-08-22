<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ContactoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación.
| Estas rutas se cargan por el RouteServiceProvider dentro del grupo de middleware "web".
|
*/

// Ruta para la página de inicio ('/')
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Ruta para ver los libros por categoría
Route::get('/categoria/{categoriaId}', [LibroController::class, 'mostrarLibros'])->name('mostrarLibros');

// Ruta para la vista de libros favoritos
Route::get('/favoritos', [FavoritoController::class, 'verFavoritos'])->name('verFavoritos');

// Ruta para agregar un libro a favoritos
Route::post('/favoritos/agregar/{libroId}', [FavoritoController::class, 'agregarFavorito'])->name('agregarFavorito');

// Ruta para eliminar un libro de favoritos
Route::delete('/favoritos/eliminar/{id}', [FavoritoController::class, 'eliminarFavorito'])->name('eliminarFavorito');

// Ruta para la vista de contacto
Route::get('/contacto', [ContactoController::class, 'verContacto'])->name('verContacto');

// Ruta para mostrar el formulario de creación de un libro
Route::get('/libros/crear', [LibroController::class, 'crear'])->name('crearLibro');

// Ruta para almacenar un nuevo libro
Route::post('/libros', [LibroController::class, 'almacenar'])->name('almacenarLibro');

// Ruta para eliminar un libro
Route::delete('/libros/{id}', [LibroController::class, 'eliminar'])->name('eliminarLibro');





