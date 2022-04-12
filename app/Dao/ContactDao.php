<?php declare(strict_types=1);

namespace App\Dao;

use App\Model\Contact;

class ContactDao
{
    /**
     * 获取好友列表
     * @param  int  $uid
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function friends(int $uid)
    {
        return Contact::with(['user' => function($query) {
                $query->select(['id', 'nickname', 'avatar', 'gender', 'motto']);
            }])->select(['remark', 'friend_id'])
            ->where('user_id', $uid)
            ->get();
    }
}