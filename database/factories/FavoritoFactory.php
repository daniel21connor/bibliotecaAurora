<?php

namespace Database\Factories;

use App\Models\Favorito;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoritoFactory extends Factory
{
    protected $model = Favorito::class;

    public function definition()
    {
        return [
            'libro_id' => \App\Models\Libro::factory(),
        ];
    }
}
