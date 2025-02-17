<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;


    protected $table = 'Lote';

    // Definir los campos que son asignables masivamente
    protected $fillable = [
        'codigo',
        'cantidad',
        'vencimiento',
        'precio_compra',
        'id_compra',
        'id_producto',
    ];

    // Relación con el modelo Compra
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra');
    }

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
