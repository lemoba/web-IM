<?php

namespace App\Model;

use support\Model;

class User extends Model
{
    protected $fillable = [
        'mobile',
        'nickname',
        'avatar',
        'gender',
        'password',
        'motto',
        'email',
        'is_robot',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'gender'   => 'integer',
        'is_robot' => 'integer',
    ];

    protected $hidden = [
        'password'
    ];
}
