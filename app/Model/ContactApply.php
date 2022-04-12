<?php

namespace App\Model;

use support\Model;

class ContactApply extends Model
{
    protected $table = 'contact_apply';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'friend_id',
        'remark',
        'created_at'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'friend_id' => 'integer',
        'created_at' => 'datetime'
    ];
}
