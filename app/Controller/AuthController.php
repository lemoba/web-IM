<?php declare(strict_types=1);

namespace App\Controller;

use App\Dao\UserDao;
use App\Helper\CodeResponse;
use App\Service\Common\SmsService;
use App\Service\UserService;
use App\Validate\AuthValidate;
use DI\Annotation\Inject;
use support\exception\BusinessException;
use support\Request;
use Tinywan\Jwt\JwtToken;

class AuthController extends BaseController
{
    /**
     * @Inject()
     * @var UserService
     */
    private $userService;

    /**
     * @Inject()
     * @var SmsService
     */
    private $smsSerivce;

    /**
     * @Inject()
     * @var UserDao
     */
    private $userDao;

    public function register(Request $request)
    {
        $input = $request->all();

        // 验证手机号
        if (!$this->verifyMobile($input ['mobile'])) {
            return $this->fail(CodeResponse::AUTH_INVALID_MOBILE);
        }

        // 验证其他参数
        $validate = new AuthValidate();

        if (!$validate->check($input)) {
            return $this->fail(CodeResponse::PARMA_ILLEGAL, $validate->getError());
        }


        // 检查验证码
        $this->smsSerivce->checkCaptcha($input['mobile'], $input['sms_code']);

        // 保存信息
        $this->userService->register($input);

        return $this->success();
    }

    public function login(Request $request)
    {
        $mobile = $request->input('mobile');
        $password = $request->input('password');

        // 参数不为空
        if (!$mobile || !$password) {
            return $this->fail(CodeResponse::PARMA_ILLEGAL);
        }

        // 验证手机号
        if (!$this->verifyMobile($mobile)) {
            return $this->fail(CodeResponse::AUTH_INVALID_MOBILE);
        }

        $user = $this->userDao->findByMobile($mobile);

        // 判断用户是否存在
        if (is_null($user)) {
            return $this->fail(CodeResponse::AUTH_MOBILE_UNREGISTERED);
        }

        // 判断密码
        if (!pwDecrpt($password, $user->password)) {
            return $this->fail(CodeResponse::AUTH_INVALID_PASSWORD);
        }


        // 生成jwt
        $token = JwtToken::generateToken([
            'id' => $user->id,
            'nickname' => $user->nickname,
            'avatar' => $user->avatar
        ]);
        return $this->success($token);
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