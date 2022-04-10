<?php declare(strict_types=1);

namespace App\Service;

use App\Dao\UserDao;
use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Traits\Singleton;
use Tinywan\Jwt\JwtToken;

class UserService extends BaseService
{
    /**
     * @var UserDao
     */
    private $userDao;

    public function __construct(UserDao $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * 账号注册
     * @param  array  $data
     */
    public function register(array $data)
    {
        $user = $this->userDao->isExistMobile($data['mobile']);

        // 已注册
        if ($user) {
            throw new BusinessException(CodeResponse::AUTH_MOBILE_REGISTERED);
        }

        // 保存到DB
        $res = $this->userDao->create([
            'mobile'   => $data['mobile'],
            'password' => pwCrypt($data['password']),
            'nickname' => strip_tags($data['nickname']), // 去除特殊字符
        ]);
    }
}