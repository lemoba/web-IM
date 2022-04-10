<?php declare(strict_types=1);

namespace App\Validate;

use App\Traits\Singleton;
use think\Validate;

class AuthValidate extends Validate
{
    protected $regex = ['/^(((13[0-9]{1})|(15[0-9]{1})|(16[0-9]{1})|(17[3-8]{1})|(18[0-9]{1})|(19[0-9]{1})|(14[5-7]{1}))+\d{8})$/'];

    protected $rule = [
        'sms_code' => 'require',
        'password' => 'require|min:5',
        'mobile' => 'require|regex:mobile',
        'nickname' => 'require|min:3',
    ];

    protected $message = [
        'sms_code' => '验证码不正确',
        'mobile.regex' => '手机号不正确',
        'password' => '密码至少五位',
        'nickname' => '昵称过短'
    ];
}