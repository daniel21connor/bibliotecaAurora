<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    use HasFactory;

    protected $table = 'favoritos'; // Nombre de la tabla

    protected $fillable = ['libro_id'];

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
}
