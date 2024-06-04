<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = ['descripcion', 'total','extras','dinero'];

    protected $casts = ['total','dinero' => 'decimal:2'];

    // Relación con Productos
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'ped_prod')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}
