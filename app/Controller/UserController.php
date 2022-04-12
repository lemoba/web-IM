<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\UserService;
use DI\Annotation\Inject;
use support\Request;
use Tinywan\Jwt\JwtToken;

class UserController extends BaseController
{
    /**
     * @Inject()
     * @var UserService
     */
    protected $userService;

    public function setting()
    {
        return $this->success();
    }

    /**
     * 获取用户信息
     * @param  Request  $request
     * @return \support\Response
     */
    public function detail(Request $request)
    {
        $userInfo = $this->user();

        $data = [
            'mobile'   => $userInfo->mobile,
            'nickname' => $userInfo->nickname,
            'avatar'   => $userInfo->avatar,
            'motto'    => $userInfo->motto,
            'email'    => $userInfo->email,
            'gender'   => $userInfo->gender,
        ];
        return $this->success($data);
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $this->userService->update($data);
        return $this->success();
    }

}