<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = ['descripcion', 'total'];

    protected $casts = ['total' => 'decimal:2'];

    // Relación con Productos
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'venta_prod')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}

