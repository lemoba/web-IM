<?php declare(strict_types=1);

namespace App\Service;

use App\Dao\UserDao;
use App\Enum\CommEnum;
use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Model\Contact;
use App\Model\ContactApply;
use App\Traits\Singleton;
use support\Redis;
use Tinywan\Jwt\JwtToken;

class UserService extends BaseService
{
    /**
     * @Inject()
     * @var UserDao
     */
    private $userDao;

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

    /**
     * 保存token
     * @param  array  $token
     * @param  int  $id
     * @return void
     */
    public function saveToken(array $token, int $id)
    {
        Redis::set(CommEnum::ACCESS_TOKEN . $id, json_encode($token));
    }

    /**
     * 验证token并返回id
     * @param  string  $token
     * @return int
     */
    public static function verifyToken(string $token)
    {
        $res = JwtToken::verify(1, $token);
        return $res['extend']['id'] ?? 0;
    }

    /**
     * 退出登录
     * @return bool
     */
    public function logout(): bool
    {
        $uid = $this->uid();
        return (bool)Redis::del(CommEnum::ACCESS_TOKEN.$uid);
    }

    /**
     * 更新数据库
     * @param  array  $data
     * @return mixed
     */
    public function update(array $data)
    {
        return $this->userDao->updateUserInfo($data, $this->uid());
    }

    /**
     * 获取用户展示
     * @param  int  $friend_id
     * @param  int  $me_id
     * @return array
     */
    public function getUserCard(int $friend_id, int $me_id): array
    {
        $info = $this->userDao->find($friend_id, [
            'id', 'mobile', 'nickname', 'avatar', 'gender', 'motto'
        ]);
        if (is_null($info)) return [];

        $info                    = $info->toArray();
        $info['friend_status']   = 0;//朋友关系[0:本人;1:陌生人;2:朋友;]
        $info['nickname_remark'] = '';
        $info['friend_apply']    = 0;

        if ($me_id != $friend_id) {
            $is_friend = $this->isFriend($me_id, $friend_id, true);
            $info['friend_status'] =  $is_friend ? 2 : 1;

            if ($is_friend) {
                $info['nickname_remark']  = $this->getFriendRemark($me_id, $friend_id);
            } else {
                $res = ContactApply::query()->where([
                    'user_id' => $me_id,
                    'friend_id' => $friend_id
                ])->orderByDesc('id')->exists();
                $info['friend_apply'] = $res ? 1 : 0;
            }
        }
        return $info;
    }

    /**
     * 判断是否是好友关系
     * @param  int  $user_id 用户id
     * @param  int  $friend_id 好友id
     * @param  bool  $isBoth 是否是双向好友
     * @return bool
     */
    public function isFriend(int $user_id, int $friend_id, bool $isBoth = false): bool
    {
        $single = Contact::query()->where([
            'user_id' => $user_id,
            'friend_id' => $friend_id
        ])->exists();

        if (!$isBoth) {
            return $single;
        }

        $both = Contact::query()->where([
            'user_id' => $friend_id,
            'friend_id' => $user_id
        ])->exists();

        return $single && $both;
    }

    /**
     * 获取好友备注
     * @param  int  $user_id
     * @param  int  $friend_id
     * @return string
     */
    public function getFriendRemark(int $user_id, int $friend_id): string
    {
        $remark = Contact::query()->where([
            'user_id' => $user_id,
            'friend_id' => $friend_id
        ])->value('remark');

        return (string)$remark;
    }
}