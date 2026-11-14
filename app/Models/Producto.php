<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'sku',
        'nombre',
        'descripcion',
        'marca',
        'presentacion',
        'precio',
        'estado',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'estado' => 'boolean',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(
            Categoria::class,
            'categoria_id'
        );
    }
}
