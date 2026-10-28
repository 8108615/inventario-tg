<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre',
        'marca',
        'modelo',
        'serie',
        'stock',
        'imagen',
        'estado'
    ];

    /**
     * Relación: Un producto pertenece a una categoría (Ubicación).
     */
    public function categoria()
    {
        return $table = $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
