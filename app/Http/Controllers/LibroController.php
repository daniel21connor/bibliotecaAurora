<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro; // Modelo de Libro (asumiendo que ya está creado)
use App\Models\Categoria; // Modelo de Categoría

class LibroController extends Controller
{
    public function mostrarLibros($categoriaId)
    {
        $categoria = Categoria::find($categoriaId);
        if (!$categoria) {
            return redirect('/')->with('error', 'Categoría no encontrada.');
        }

        $libros = Libro::where('categoria_id', $categoriaId)->get();
        return view('welcome', compact('libros', 'categoria'));
    }

    // Método para agregar un libro (formulario de creación)
    public function crear()
    {
        return view('crear');
    }

    // Método para almacenar un nuevo libro
    public function almacenar(Request $request)
    {
        $libro = new Libro;
        $libro->titulo = $request->titulo;
        $libro->autor = $request->autor;
        $libro->categoria_id = $request->categoria_id; // Ajustado a categoria_id
        $libro->imagen = $request->imagen; // Suponiendo que cargas una imagen
        $libro->save();

        return redirect('/')->with('success', 'Libro agregado exitosamente.');
    }

    // Método para eliminar un libro
    public function eliminar($id)
    {
        $libro = Libro::find($id);
        if ($libro) {
            $libro->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

}
