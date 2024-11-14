<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultivendeToken extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'multivende_tokens';

    protected $fillable = [
        'token',
        'refresh_token',
        'expires_at',
        'create_at',
        'updated_at',
        'client_id',
        'client_secret'
    ];
}
