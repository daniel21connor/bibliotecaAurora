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
        // Validar los datos (puedes agregar reglas de validación más estrictas si es necesario)
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'imagen' => 'nullable|file|mimes:jpeg,png,jpg,gif'
        ]);

        // Crear una nueva instancia de Libro
        $libro = new Libro;
        $libro->titulo = $request->titulo;
        $libro->autor = $request->autor;
        $libro->categoria_id = $request->categoria_id;

        // Si se subió una imagen, manejar el archivo
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('imagenes_libros', 'public'); // Guardar en el storage público
            $libro->imagen = $imagenPath;
        }

        // Guardar el libro en la base de datos
        $libro->save();

        // Devolver una respuesta JSON en lugar de redirigir
        return response()->json(['success' => true, 'message' => 'Libro agregado exitosamente.']);
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
