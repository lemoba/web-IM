<?php declare(strict_types=1);

namespace App\Controller\Contact;

use App\Controller\BaseController;
use App\Dao\ContactDao;
use App\Dao\UserDao;
use App\Helper\CodeResponse;
use App\Model\Contact;
use App\Service\Contact\ContactService;
use App\Service\UserService;
use DI\Annotation\Inject;
use support\Request;

class ContactController extends BaseController
{
    /**
     * @Inject()
     * @var UserDao
     */
    protected $userDao;

    /**
     * @Inject()
     * @var ContactService
     */
    protected $contactService;
    /**
     * @Inject()
     * @var UserService
     */
    protected $userService;

    public function search(Request $request)
    {
        $mobile = $request->input('mobile');
        $user = $this->userDao->findByMobile($mobile, [ 'id', 'nickname', 'mobile', 'avatar', 'gender']);

        if (is_null($user)) {
            return $this->fail(CodeResponse::AUTH_INVALID_ACCOUNT);
        }
        return $this->success($user);
    }

    public function detail(Request $request)
    {
        $user_id = $request->input('user_id');
        $info = $this->userService->getUserCard((int)$user_id, $this->userService->uid());
        return $this->success($info);
    }

    public function list()
    {
        $data = $this->contactService->friends();
        return $this->success($data);
    }
}