<?php

namespace App\Controller;

use App\Dao\UserDao;
use App\Model\User;
use DI\Annotation\Inject;
use Shopwwi\WebmanAuth\Facade\Auth;
use think\Validate;
use Tinywan\Jwt\JwtToken;

class BaseController extends AbstractController
{
    /**
     * @Inject()
     * @var UserDao
     */
    private $userDao;
    /**
     * 验证手机号
     * @param  string  $mobile
     * @return bool
     */
    public function verifyMobile(string $mobile)
    {
        $regex = '/^1[3456789][0-9]{9}$/';
        $validate = new Validate();
        $result = $validate->rule('mobile', ['regex' => $regex])->check([
            'mobile' => $mobile
        ]);
        return $result;
    }

    /**
     * 获取用户信息
     * @return User
     */
    public function user()
    {
        $uid = JwtToken::getCurrentId();
        return $this->userDao->find($uid);
    }
}
