<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = 'compras';


    protected $fillable = [
        'codigo',
        'fecha_compra',
        'fecha_entrega',
        'total',
        'id_estado_pago',
        'id_proveedor',
    ];

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'id_compra');
    }

    public function estadoPago()
    {
        return $this->belongsTo(Estado::class, 'id_estado_pago');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

   

}
