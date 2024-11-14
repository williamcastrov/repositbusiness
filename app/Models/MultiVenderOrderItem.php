<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MultiVenderOrderItem extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'multivende_orders_item';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_siigo',
        'name',
        'checkout_id',
        'sku',
        'gross',
        'count',
        'total',
        'discount',
        'total_with_discount',
        'payment_by_item',
        'product_version_id',
        'merchant_id'
    ];
}
