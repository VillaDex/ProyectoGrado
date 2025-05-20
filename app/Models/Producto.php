<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'estado',
        'url_imagen',
    ];

    public function setStockAttribute($value)
    {
        $this->attributes['stock'] = $value;

        if ($value == 0) {
            $this->attributes['estado'] = 'agotado';
        } else {
            $this->attributes['estado'] = 'disponible';
        }
    }

    public function tieneStockBajo()
    {
        return $this->stock == 1;
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}