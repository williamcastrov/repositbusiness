<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiigoProducto extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'siigo_producto'; // Nombre de la tabla

    protected $fillable = [
        'id_siigo',
        'code',
        'name',
        'type',
        'active',
        'description',
        'precio',
        'referencia',
        'stock_control',
        'available_quantity',
        'unit',
        'barcode',
        'brand',
        'model',
    ];
}