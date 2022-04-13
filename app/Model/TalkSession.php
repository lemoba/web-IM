<?php declare(strict_types=1);

namespace App\Model;

use support\Model;

class TalkSession extends Model
{
    protected $table = 'talk_session';
    public $timestamps = false;

    protected $fillable = [
        'talk_type',
        'user_id',
        'receiver_id',
        'is_top',
        'is_robot',
        'is_disturb',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'created_at'
    ];

    protected $casts = [
        'talk_type' => 'integer',
        'user_id' => 'integer',
        'receiver_id' => 'integer',
        'is_top' => 'integer',
        'is_robot' => 'integer',
        'is_disturb' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }
}