<?php declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Exceptions\BusinessException;
use App\Helper\CodeResponse;
use app\Model\User;
use App\Services\Common\SmsService;
use App\Services\Auth\UserService;
use App\Validate\AuthValidate;
use support\Request;

class AuthController extends BaseController
{

    public function register(Request $request)
    {
        $mobile = $request->input('mobile');
        $nickname = $request->input('nickname');
        $password = $request->input('password');
        $sms_code = $request->input('sms_code');

        $validate = new AuthValidate();

        if (!$validate->check(compact('mobile', 'nickname', 'password', 'sms_code'))) {
            throw new BusinessException(CodeResponse::PARMA_ILLEGAL, $validate->getError());
        }

        // 判断手机号是否已经注册
        $user = UserService::getUserByMobile($mobile);

        if (!is_null($user)) {
            return $this->fail(CodeResponse::AUTH_MOBILE_REGISTERED);
        }

        //检查验证码
        //SmsService::checkCaptcha($mobile, $sms_code);


        $user = new User();
        $user->nickname = $nickname;
        $user->password = $this->crypt($password);
        $user->mobile = $mobile;
        $user->save();
        return $this->success();
    }

    public function login(Request $request)
    {


    }


    public function logout()
    {

    }

    public function forget()
    {

    }

    public function refreshToken()
    {

    }
}