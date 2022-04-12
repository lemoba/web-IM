<?php declare(strict_types=1);

namespace App\Controller\Contact;

use App\Controller\BaseController;
use App\Service\Contact\ContactApplyService;
use support\Request;

class ContactApplyController extends BaseController
{
    /**
     * @Inject()
     * @var ContactApplyService
     */
    protected $contactApplyService;

    public function create(Request $request)
    {
        $friend_id = $request->input('friend_id');
        $remark = $request->input('remark', '');

        $this->contactApplyService->friendApply((int)$friend_id, $remark);
        return $this->success();
    }

    public function records()
    {

    }
}