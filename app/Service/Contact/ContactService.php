<?php declare(strict_types=1);

namespace App\Service\Contact;

use App\Dao\ContactDao;
use App\Service\BaseService;
use App\Service\SocketService;
use App\Service\UserService;
use App\Traits\Singleton;
use DI\Annotation\Inject;

class ContactService extends BaseService
{
    use Singleton;

    /**
     * @Inject()
     * @var ContactDao
     */
    protected $contactDao;

    /**
     * @Inject()
     * @var UserService
     */
    protected $userSerive;
    /**
     * 获取好友列表
     * @param $uid
     * @return void
     */
    public function friends()
    {
        $res = $this->contactDao->friends($this->uid());

        return $res->map(function ($item) {
            $is_online = SocketService::getInstance()->isOnLine($item->user->id);
            return array_merge($item->user->toArray(), [
                'remark' => $item->remark,
                'is_online' => $is_online
            ]);
        });
    }
}