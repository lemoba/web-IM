<?php declare(strict_types=1);

namespace App\service\Common;

use App\enum\SmsEnums;
use support\Redis;

class SmsService
{
    /**
     * 生成短信验证码
     * @param  string  $mobbile
     * @param  int  $expire
     * @return int
     * @throws \Exception
     */
    public static function setCapchaCode(string $mobbile, int $expire = 60 * 3): int
    {
        // 随机生成五位验证码
        $code = random_int(10000, 99999);
        // 保存手机与验证的映射
        Redis::SETEX(SmsEnums::REGISTER_CAPTCHA, $expire, $mobbile);

        return $code;
    }
}