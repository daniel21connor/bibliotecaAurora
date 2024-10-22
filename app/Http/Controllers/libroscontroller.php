<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Asegúrate de agregar esto
use Illuminate\Http\JsonResponse;
use App\Models\Libro; // Asegúrate de que esta línea esté presente


class libroscontroller extends Controller
{
    public function getLibros(): JsonResponse
    {
        $libros= Libro::all(); // Obtiene todos los productos de la base de datos
        return response()->json($libros); // Devuelve los productos como JSON
    }
}
