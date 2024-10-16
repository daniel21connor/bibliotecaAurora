<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\LibroController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Prefijo para todas las rutas relacionadas con libros
Route::prefix('libros')->group(function () {
    // Obtener todos los libros
    Route::get('/', [LibroController::class, 'index']);

    // Obtener libros por categoría
    Route::get('/categoria/{categoriaId}', [LibroController::class, 'mostrarLibros']);

    // Mostrar el formulario de creación de libros (opcional si usas API)
    Route::get('/crear', [LibroController::class, 'crear']);

    // Almacenar un nuevo libro
    Route::post('/', [LibroController::class, 'almacenar']);

    // Mostrar el formulario de edición de un libro (opcional si usas API)
    Route::get('/{id}/editar', [LibroController::class, 'editar']); // Ruta para mostrar el formulario de edición

    // Obtener un libro específico por su ID
    Route::get('/{id}', [LibroController::class, 'show']);

    // Actualizar un libro existente
    Route::put('/{id}', [LibroController::class, 'actualizar']);

    // Eliminar un libro existente
    Route::delete('/{id}', [LibroController::class, 'eliminar']);
});
