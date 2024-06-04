<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención de nombres de Laravel
    protected $table = 'productos';

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';

    // Especifica qué campos pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen_url', // Agrega el campo imagen_url
        'precio',
        'cantidad',
    ];

    // Define la relación con el modelo Pedido
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'ped_prod', 'producto_id', 'pedido_id');
    }

    // Define la relación con el modelo Materia
    public function materias()
{
    return $this->belongsToMany(Materia::class, 'pro_materia', 'producto_id', 'materia_id')->withPivot('cantidad');
}


    // Define la relación con el modelo Venta
    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'venta_prod', 'producto_id', 'venta_id')
        ->withPivot('cantidad')
        ->withTimestamps();
    }

    // Aquí puedes definir relaciones, scopes, y otros comportamientos del modelo
}
