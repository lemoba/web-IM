<?php

namespace App\Model;

use support\Model;

class Contact extends Model
{
    protected $table = 'contact';

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'friend_id');
    }
}
