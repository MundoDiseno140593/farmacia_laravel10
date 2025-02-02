<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'concentracion',
        'adicional',
        'precio',
        'id_lab',
        'id_tip_prod',
        'id_present',
        'estado'
    ];

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'id_lab');
    }

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'id_tip_prod');
    }

    public function presentacion()
    {
        return $this->belongsTo(Presentacion::class, 'id_present');
    }
}
