<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito; // Modelo de Favoritos

class FavoritoController extends Controller
{
    // Muestra la lista de libros favoritos
    public function verFavoritos()
    {
        // Obtener todos los favoritos con la relación de libro
        $favoritos = Favorito::with('libro')->get();
        return view('Favoritos', compact('favoritos'));
    }

    // Método para agregar un libro a favoritos
    public function agregarFavorito(Request $request, $libroId)
    {
        // Verificar si el libro ya está en favoritos
        if (Favorito::where('libro_id', $libroId)->exists()) {
            return redirect('/favoritos')->with('info', 'El libro ya está en favoritos.');
        }

        $favorito = new Favorito;
        $favorito->libro_id = $libroId;
        $favorito->save();

        return redirect('/favoritos')->with('success', 'Libro agregado a favoritos.');
    }

    // Método para eliminar un libro de favoritos
    public function eliminarFavorito($id)
    {
        $favorito = Favorito::find($id);
        if ($favorito) {
            $favorito->delete();
            return redirect('/favoritos')->with('success', 'Libro eliminado de favoritos.');
        }
        return redirect('/favoritos')->with('error', 'Favorito no encontrado.');
    }

// app/Http/Controllers/FavoritoController.php
    public function contarFavoritos()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $count = $user->favoritos()->count(); // Contar los libros favoritos

        return response()->json(['count' => $count]);
    }
}
