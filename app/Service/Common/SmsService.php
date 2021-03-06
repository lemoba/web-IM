<?php declare(strict_types=1);

namespace App\Service\Common;

use App\Enum\SmsEnum;
use App\Exception\BusinessException;
use App\Helper\CodeResponse;
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
    protected function setCapchaCode(string $mobile, int $expire = 60 * 3): int
    {
        // 随机生成五位验证码
        // $code = random_int(10000, 99999);
        $code = 12345;
        // 保存手机与验证的映射
        Redis::SETEX(SmsEnum::REGISTER_CAPTCHA.$mobile, $expire, $code);
        return $code;
    }

    /**
     * 发送短信验证码
     * @param  string  $mobile
     * @param  int  $code
     * @return void
     */
    public function sendCaptchaMsg(string $mobile)
    {
        // 2分钟内只能请求一次
        $lock = Redis::SET(SmsEnum::REGISTER_CAPTCHA_LOCK.$mobile,
            1,
            'ex',
            120,
            'nx'
        );

        if (!$lock) {
            throw new BusinessException(CodeResponse::AUTH_CAPTCHA_FREQUENCY);
        }

        // 每天上限10条
        $checkSendCount = $this->checkMobileSendCaptchaCount($mobile);

        if (!$checkSendCount) {
            throw new BusinessException(CodeResponse::AUTH_CAPTCHA_DAILY_LIMT);
        }

        // 生成验证码
        $code = self::setCapchaCode($mobile);

        // 发送验证码
        // $easySms = new EasySms(config('easysms'));
        // $easySms->send($mobile, [
        //     'template' => 'SMS_123287417',
        //     'data' => [
        //         'code' => $code
        //     ],
        // ]);
    }

    /**
     * 检测手机号发送验证码是否已达上限
     * @param  string  $mobile
     * @return bool
     */
    protected function checkMobileSendCaptchaCount(string $mobile): bool
    {
        // 同一个手机号当天只能请求10次
        $countKey = SmsEnum::REGISTER_CAPTCHA_COUNT.$mobile;
        if (Redis::EXISTS($countKey)) {
            if (Redis::GET($countKey) >= 10) {
                return false;
            }
            Redis::INCR($countKey);
        } else {
            Redis::SET($countKey, 1, 'EX', 3600*24);
        }
        return true;
    }

    /**
     * 检查验证码
     * @param  string  $mobile
     * @param  string  $code
     * @return bool
     * @throws BusinessException
     */
    public function checkCaptcha(string $mobile, string $code): bool
    {
        $key = SmsEnum::REGISTER_CAPTCHA.$mobile;
        $check = $code === Redis::GET($key);
        if ($check) {
            Redis::DEL($key);
            return true;
        } else {
            throw new BusinessException(CodeResponse::AUTH_CAPTCHA_UNMATCH);
            return false;
        }
    }
}