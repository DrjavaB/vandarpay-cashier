<?php

namespace Vandar\Cashier\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthList extends Model
{
    protected $table = "vandar_auth_list";

    protected $fillable = [
        'token_type', 'expires_in', 'access_token', 'refresh_token'
    ];
}
