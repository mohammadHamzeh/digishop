<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_data extends Model
{
    protected $fillable = [
        'user_id', 'address', 'telephone', 'postal_code'
    ];
}
