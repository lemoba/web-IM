<?php declare(strict_types=1);

namespace App\Model;

use support\Model;

class TalkRecord extends Model
{
   protected $fillable = [
        'talk_type',
        'msg_type',
        'user_id',
        'receiver_id',
        'is_revoke',
        'is_mark',
        'quote_id',
        'content',
        'warn_users',
   ];
}