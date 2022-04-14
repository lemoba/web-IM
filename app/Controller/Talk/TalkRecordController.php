<?php declare(strict_types=1);

namespace App\Controller\Talk;

use App\Controller\BaseController;
use App\Service\Talk\TalkRecordService;
use support\Request;

class TalkRecordController extends BaseController
{
    public function recordlist(Request $request, $receiver_id)
    {
        $data = TalkRecordService::getInstance()->getTalkRecordList((int)$receiver_id);
        return $this->success($data);
    }
}