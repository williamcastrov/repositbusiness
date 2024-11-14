<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MultiVenderOrder extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'multivende_orders';

    protected $fillable = [
        'id',
        'client_id',
        'orden_number',
        'payment',
        'code',
        'origin',
        'net',
        'tags',
        'status',
        'verification_status',
        'payment_status',
        'delivery_status',
        'comment',
        'sold_at',
        'is_multiwarehouse',
        'courier_name',
        'shipping_mode',
        'created_at',
        'updated_at',
        'created_by_id',
    ];

    protected $dates = [
        'sold_at', 
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    public function setSoldAtAttribute($value)
    {
        $this->attributes['sold_at'] = Carbon::parse($value)->setTimezone('America/Bogota')->format('Y-m-d H:i:s');
    }
}
