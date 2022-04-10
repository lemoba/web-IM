<?php declare(strict_types=1);

namespace App\Helper;

class CodeResponse
{
    const SUCCESS = [200, 'success'];
    const FAIL = [400, 'failed'];
    const PARMA_ILLEGAL = [401, '参数错误'];

    // 业务返回码
    const MESSAGE_SUCCESS = [0, '短信发送成功'];
    const AUTH_INVALID_ACCOUNT = [700, '账号不存在'];
    const AUTH_CAPTCHA_DAILY_LIMT = [701, '频繁操作，请明天再试'];
    const AUTH_CAPTCHA_FREQUENCY = [702, '请2分钟后再试'];
    const AUTH_CAPTCHA_UNMATCH = [703, '验证码错误'];
    const AUTH_NAME_REGISTERED = [704, '用户已注册'];
    const AUTH_MOBILE_REGISTERED = [705, '该手机号已注册'];
    const AUTH_MOBILE_UNREGISTERED = [706, '手机号未注册'];
    const AUTH_INVALID_MOBILE = [707, '手机号格式错误'];
    const AUTH_OPENID_UNACCESS = [708, ''];
    const AUTH_OPENID_BINDED = [709, ''];
}