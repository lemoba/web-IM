<?php declare(strict_types=1);

namespace App\Controller\Common;

use App\Controller\BaseController;
use App\Helper\CodeResponse;
use App\Model\User;
use App\Services\Common\SmsService;
use support\Request;

class CommonController extends BaseController
{
    public function sendSmsCode(Request $request)
    {
        $mobile = $request->input('mobile');

        // 手机号为空
        if (empty($mobile)) {
            return $this->fail(CodeResponse::PARMA_ILLEGAL);
        }

        $user = User::query()->where('mobile', $mobile)->first();
        // 手机号已注册
        if ($user) {
            return $this->fail(CodeResponse::AUTH_MOBILE_REGISTERED);
        }

        //发送短信
        SmsService::sendCaptchaMsg($mobile);

        $data = [
            'is_debug' => 1,
            'sms_code' => 12345
        ];

        return $this->success($data);
    }

}