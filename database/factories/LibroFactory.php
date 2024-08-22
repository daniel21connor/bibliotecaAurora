<?php

namespace Database\Factories;

use App\Models\Libro;
use Illuminate\Database\Eloquent\Factories\Factory;

class LibroFactory extends Factory
{
    protected $model = Libro::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(3),
            'autor' => $this->faker->name,
            'imagen' => $this->faker->imageUrl(640, 480, 'books'),
            'categoria_id' => \App\Models\Categoria::factory(),
        ];
    }
}
