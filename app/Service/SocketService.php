<?php declare(strict_types=1);

namespace App\Service;

use App\Cache\SocketFdBindUser;
use App\Cache\SocketUserBindFd;
use App\Traits\Singleton;
use DI\Annotation\Inject;
use GatewayWorker\Lib\Gateway;

class SocketService extends BaseService
{
    use Singleton;
    /**
     * @Inject()
     * @var SocketFdBindUser
     */
    protected $socketFdBindUser;

    /**
     * @Inject()
     * @var SocketUserBindFd
     */
    protected $socketUserBindFd;


    public function bind(string $fd, int $uid)
    {
        Gateway::bindUid($fd, $uid);
        $this->socketFdBindUser->bind($fd, $uid);
        $this->socketUserBindFd->bind($fd, $uid);
    }

    public function unbind(string $fd)
    {
        $uid = $this->findUid($fd);
        $this->socketFdBindUser->unbind($fd);
        $this->socketUserBindFd->unbind($fd, $uid);
    }

    /**
     * 判断指定用户是否在线
     * @param  int  $uid
     * @return bool
     */
    public function isOnLine(int $uid): bool
    {
        $fd = $this->findFd($uid);
        if (!$fd) return false;
        return (bool)Gateway::isOnline($fd);
    }

    public function findUid(string $fd): int
    {
        return $this->socketFdBindUser->findUidByFd($fd);
    }

    public function findFd(int $uid): string
    {
        return $this->socketUserBindFd->findFdByUid($uid);
    }
}