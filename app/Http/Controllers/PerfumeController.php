<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Asegúrate de agregar esto
use Illuminate\Http\JsonResponse;
use App\Models\Producto; // Asegúrate de que esta línea esté presente


class PerfumeController extends Controller
{
    public function getProductos(): JsonResponse
    {
        $productos = Producto::all(); // Obtiene todos los productos de la base de datos
        return response()->json($productos); // Devuelve los productos como JSON
    }
}
