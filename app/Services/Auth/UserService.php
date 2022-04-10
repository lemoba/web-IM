<?php declare(strict_types=1);

namespace App\services\Auth;

use App\Model\User;

class UserService
{
    public static function getUserByMobile(string $mobile)
    {
        return User::query()->where('mobile', $mobile)->first();
    }
}