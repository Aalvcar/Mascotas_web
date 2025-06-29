<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class MascotaAAC extends Model
{
    use HasFactory;

    // Asociación de la tabla 'comentarios' con el modelo.
    protected $table = 'mascotas';

    // Definición de los atributos asignables en masa.
    protected $fillable = ['nombre', 'descripcion', 'tipo', 'publica', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
