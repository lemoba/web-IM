<?php declare(strict_types=1);

namespace App\Controller\Talk;

use App\Controller\BaseController;
use App\Helper\CodeResponse;
use App\Service\TalkService;
use support\Request;
use think\facade\Validate;


class TalkController extends BaseController
{
    /**
     * 创建聊天列表
     * @param  Request  $request
     * @return \support\Response
     */
    public function create(Request $request)
    {
        $input = $request->only(['receiver_id', 'talk_type']);

        $validate = Validate::rule('receiver_id', 'require|integer|min:1')
            ->rule('talk_type', 'require|integer|in:1,2');

        if (!$validate->check($input)) {
            return $this->fail(CodeResponse::PARMA_ILLEGAL, $validate->getError());
        }

        TalkService::getInstance()->createTalk($input);

        return $this->success();
    }

    /**
     * 获取聊天列表
     * @return \support\Response
     */
    public function talkList()
    {
        $data = TalkService::getInstance()->talkList();
        return $this->success($data);
    }
}