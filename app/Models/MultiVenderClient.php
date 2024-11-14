<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MultiVenderClient extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'multivende_clients';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'full_name',
        'name',
        'last_name',
        'document_type',
        'type',
        'identification',
        'phoneNumber',
        'email',
        'address_1',
        'address_2',
        'client_id',
        'merchant_id'
    ];
}
