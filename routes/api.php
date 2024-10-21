<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
// Obtener todos los libros
Route::get('/libros', [LibroController::class, 'index'])->middleware('auth:sanctum'); // Rutas para obtener todos los libros

// Obtener libros por categoría
Route::get('/libros/categoria/{categoriaId}', [LibroController::class, 'mostrarLibros']); // Rutas para obtener libros por categoría

// Almacenar un nuevo libro
Route::post('/libros', [LibroController::class, 'almacenar']); // Rutas para almacenar un nuevo libro

// Obtener un libro específico por su ID
Route::get('/libros/{id}', [LibroController::class, 'show']); // Rutas para obtener un libro específico

// Actualizar un libro existente
Route::put('/libros/{id}', [LibroController::class, 'actualizar']); // Rutas para actualizar un libro existente

// Eliminar un libro existente
Route::delete('/libros/{id}', [LibroController::class, 'eliminar']); // Rutas para eliminar un libro existente



// Rutas para registro y autenticación de usuarios
Route::post('/register', [AuthController::class, 'register']); // Ruta para registrar un nuevo usuario
Route::post('/login', [AuthController::class, 'login']); // Ruta para iniciar sesión
Route::post('/userinfo', [AuthController::class, 'infouser'])->middleware('auth:sanctum');
