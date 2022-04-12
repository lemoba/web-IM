<?php declare(strict_types=1);

namespace App\Controller\Common;

use App\Controller\BaseController;
use App\Dao\UserDao;
use App\Helper\CodeResponse;
use App\Model\User;
use App\Service\Common\SmsService;
use DI\Annotation\Inject;
use support\Request;
use Tinywan\Storage\Storage;

class CommonController extends BaseController
{
    /**
     * @Inject()
     * @var SmsService
     */
    private $smsSerices;

    /**
     * @Inject()
     * @var UserDao
     */
    private $userDao;

    /**
     * 发送短信验证码
     * @param  Request  $request
     * @return \support\Response
     * @throws \App\Exception\BusinessException
     */
    public function sendSmsCode(Request $request)
    {
        $mobile = $request->input('mobile');

        // 手机号为空
        if (empty($mobile)) {
            return $this->fail(CodeResponse::PARMA_ILLEGAL);
        }


        // 判断手机是否存在
        $user = $this->userDao->isExistMobile($mobile);

        if ($user) {
            return $this->fail(CodeResponse::AUTH_MOBILE_REGISTERED);
        }

        //发送短信
        $this->smsSerices->sendCaptchaMsg($mobile);

        $data = [
            'is_debug' => 1,
            'sms_code' => 12345
        ];

        return $this->success($data);
    }


    public function uploadAvatar(Request $request)
    {
        Storage::config();
        $res = Storage::uploadFile();
        return $this->success(['avatar' => $res[0]['url']]);
    }
}