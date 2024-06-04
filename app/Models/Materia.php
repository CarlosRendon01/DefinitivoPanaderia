<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';

    protected $fillable = [
        'nombre',
        'descripcion',
        'proveedor',
        'cantidad',
        'precio',
        'imagen_url',
        'unidad',
    ];

    // Define la relación con el modelo Producto
    public function productos()
{
    return $this->belongsToMany(Producto::class, 'pro_materia', 'materia_id', 'producto_id')->withPivot('cantidad');
}
}
