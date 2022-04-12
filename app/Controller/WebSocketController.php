<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\SocketService;
use App\Service\UserService;
use GatewayWorker\Lib\Gateway;
use support\Log;

class WebSocketController
{

    public static function onWorkerStart($worker)
    {

    }

    public static function onConnect($fd)
    {

    }
    public static function onWebSocketConnect($fd, $data)
    {
        $token = $data['get']['token'] ?? '';
        $uid = UserService::verifyToken($token);
        if (!$uid) {
            Log::error('unauthorized');
            Gateway::closeClient($fd);
        }
        //echo "用户连接信息: user_id:{$uid} | fd: {$fd} 时间:" . date('Y-m-d H:h:i') .PHP_EOL;
        SocketService::getInstance()->bind($fd, $uid);
    }

    public static function onMessage($fd, $message)
    {
        Gateway::sendToClient($fd, "receive message $message");
    }

    public static function onClose($fd)
    {
        SocketService::getInstance()->unbind($fd);
        //echo "用户下线: fd: {$fd} 时间:" . date('Y-m-d H:h:i') .PHP_EOL;
    }
}