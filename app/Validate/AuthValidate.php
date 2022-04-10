<?php declare(strict_types=1);

namespace App\Validate;

use App\Traits\Singleton;
use think\Validate;

class AuthValidate extends Validate
{
    protected $rule = [
        'nickname' => 'require|min:3',
        'sms_code' => 'require',
        'password' => 'require|min:5',
    ];

    protected $message = [
        'sms_code' => '验证码错误',
        'password' => '密码至少五位',
        'nickname' => '昵称过短'
    ];
}