<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = ['nombre', 'apellidos','dni','edad','telefono','correo','direccion','sexo_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cliente) {
            if (self::where('dni', $cliente->dni)->exists()) {
                throw ValidationException::withMessages(['dni' => 'El DNI ya está en uso.']);
            }
        });
    }
}
