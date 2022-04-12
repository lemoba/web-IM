<?php declare(strict_types=1);

namespace App\Cache;

use App\Enum\RedisEnum;
use App\Traits\Singleton;
use support\Redis;

class SocketUserBindFd
{
    use Singleton;

    public function bind(string $fd, int $uid)
    {
        Redis::sAdd(RedisEnum::SET_WS_FD.$uid, $fd);
    }

    public function unbind(string $fd, int $uid)
    {
        Redis::sRem(RedisEnum::SET_WS_FD.$uid, $fd);
    }

    public function findFdByUid(int $uid): string
    {
        $key = RedisEnum::SET_WS_FD.$uid;
        if (Redis::exists($key)) {
            return Redis::sRandMember($key, 1)[0];
        }
        return '';
    }
}