<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\SocketService;
use App\Service\Talk\TalkRecordService;
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
        echo "用户连接信息: user_id:{$uid} | fd: {$fd} 时间:" . date('Y-m-d H:h:i') .PHP_EOL;
        SocketService::getInstance()->bind($fd, $uid);
    }

    public static function onMessage($fd, $message)
    {
        $data = json_decode($message, true);
        $data['time'] = time();
        $receiveFd = SocketService::getInstance()->findFd($data['receiver_id']); // 获取fd
        TalkRecordService::getInstance()->saveMessage($data); // 保存消息
        if ($receiveFd) {
            Gateway::sendToClient($receiveFd, json_encode($data));
        }
        echo "sendFd: {$fd} - reciveFd: {$receiveFd} - message: {$data['content']}".PHP_EOL;
    }

    public static function onClose($fd)
    {
        SocketService::getInstance()->unbind($fd);
    }
}