<?php declare(strict_types=1);

namespace App\Enum;

class SmsEnum
{
    // Redis
    const REGISTER_CAPTCHA = "register_captcha_";
    const REGISTER_CAPTCHA_LOCK = "register_captcha_lock_";
    const REGISTER_CAPTCHA_COUNT = "register_captcha_count_";
}