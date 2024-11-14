<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiigoStock extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'siigo_stock';

    protected $fillable = [
        'producto_sku',
        'checkout_id',
        'type',
        'description',
        'quantity',
        'fecha',
    ];
}
