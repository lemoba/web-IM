<?php declare(strict_types=1);

namespace App\Cache;

use App\Cache\Repository\HashGroupRepository;
use App\Enum\RedisEnum;
use support\Redis;

class SocketFdBindUser
{
    public function bind(string $fd, int $uid)
    {
       Redis::hSet(RedisEnum::HASH_WS_USER, $fd, $uid);
    }

    public function unbind(string $fd)
    {
        Redis::hDel(RedisEnum::HASH_WS_USER, $fd);
    }

    public function findUidByFd(string $fd): int
    {
        return (int)Redis::hGet(RedisEnum::HASH_WS_USER, $fd);
    }
}