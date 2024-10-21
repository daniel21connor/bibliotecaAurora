<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro; // Modelo de Libro (asumiendo que ya está creado)
use App\Models\Categoria; // Modelo de Categoría

class LibroController extends Controller
{
    // Método para mostrar todos los libros
    public function index() {
        try {
            $libros = Libro::all();
            return response()->json($libros);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar los libros: ' . $e->getMessage()], 500);
        }
    }


    // Método para mostrar los libros de una categoría específica
    public function mostrarLibros($categoriaId)
    {
        // Buscar la categoría por ID
        $categoria = Categoria::find($categoriaId);

        if (!$categoria) {
            // Responder con JSON si la solicitud es una API, de lo contrario redirigir
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Categoría no encontrada.'], 404);
            }
            return redirect('/')->with('error', 'Categoría no encontrada.');
        }

        // Obtener los libros de la categoría
        $libros = Libro::where('categoria_id', $categoriaId)->get();

        // Si es una solicitud API, devolver los libros en formato JSON
        if (request()->expectsJson()) {
            return response()->json($libros);
        }

        // Si no es una solicitud API, devolver la vista 'welcome'
        return view('welcome', compact('libros', 'categoria'));
    }


    // Método para mostrar el formulario de creación de un libro
    public function crear()
    {
        $categorias = Categoria::all(); // Obtener todas las categorías
        return view('crear', compact('categorias'));
    }

    // Método para almacenar un nuevo libro
    public function almacenar(Request $request)
    {
        // Validar los datos
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'imagen' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048' // Limitar el tamaño de la imagen a 2MB
        ]);

        // Crear una nueva instancia de Libro
        $libro = new Libro;
        $libro->titulo = $request->titulo;
        $libro->autor = $request->autor;
        $libro->categoria_id = $request->categoria_id;

        if ($request->hasFile('imagen')) {
            // Obtener el archivo de imagen
            $imagen = $request->file('imagen');

            // Crear un nombre único para la imagen
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

            // Almacenar la imagen en la carpeta 'public/images'
            $imagen->move(public_path('images'), $nombreImagen);

            // Asignar el nombre de la imagen al libro
            $libro->imagen = $nombreImagen;
        }

        // Guardar el libro en la base de datos
        $libro->save();

        // Devolver una respuesta JSON
        return response()->json(['success' => true, 'message' => 'Libro agregado exitosamente.']);
    }

    // Método para almacenar la imagen
    private function almacenarImagen($imagen)
    {
        return $imagen->store('imagenes_libros', 'public'); // Guardar en el storage público
    }

    // Método para eliminar un libro
    public function eliminar($id)
    {
        $libro = Libro::find($id);
        if ($libro) {
            // Aquí podrías agregar lógica para eliminar la imagen del disco si es necesario
            $libro->delete();
            return response()->json(['success' => true, 'message' => 'Libro eliminado exitosamente.']);
        }
        return response()->json(['success' => false, 'message' => 'Libro no encontrado.'], 404);
    }

    // Método para mostrar el formulario de edición de un libro
    public function editar($id)
    {
        // Buscar el libro por ID
        $libro = Libro::find($id);
        if (!$libro) {
            return response()->json(['success' => false, 'message' => 'Libro no encontrado.'], 404);
        }

        // Devolver el libro en formato JSON
        return response()->json($libro);
    }

// Método para actualizar un libro
    public function actualizar(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            // Cambié `categoria_id` ya que no lo estás usando en el frontend
            // 'categoria_id' => 'required|integer|exists:categorias,id',
            // Si decides que la categoría no se debe actualizar, elimina esto.
            'imagen' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048' // Limitar el tamaño de la imagen a 2MB
        ]);

        // Buscar el libro por ID
        $libro = Libro::find($id);
        if (!$libro) {
            return response()->json(['success' => false, 'message' => 'Libro no encontrado.'], 404);
        }

        // Actualizar los atributos del libro
        $libro->titulo = $request->input('titulo');
        $libro->autor = $request->input('autor');

        // Si decides mantener la categoría, asegúrate de que se envíe desde el frontend
        // $libro->categoria_id = $request->input('categoria_id');

        // Manejar la imagen si se subió
        if ($request->hasFile('imagen')) {
            // Aquí podrías eliminar la imagen anterior si es necesario
            $libro->imagen = $this->almacenarImagen($request->file('imagen'));
        }

        // Guardar los cambios en la base de datos
        $libro->save();

        // Devolver una respuesta JSON
        return response()->json(['success' => true, 'message' => 'Libro actualizado exitosamente.']);
    }
}
