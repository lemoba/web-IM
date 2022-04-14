<?php declare(strict_types=1);

namespace App\Service\Talk;

use App\Dao\Talk\TalkSessionDao;
use App\Model\TalkSession;
use App\Service\BaseService;
use App\Traits\Singleton;
use DI\Annotation\Inject;

class TalkService extends BaseService
{
    use Singleton;
    /**
     * @Inject()
     * @var TalkSessionDao
     */
    protected $talkDao;

    /**
     * 创建聊天
     * @param  array  $data
     * @return void
     */
    public function createTalk(array $data)
    {
        $data['user_id'] = $this->uid();
        $data['created_at'] = date('Y-m-d H:m:s');
        $data['updated_at'] = date('Y-m-d H:m:s');
        return $this->talkDao->createTalkSession($data);
    }

    /**
     * 聊天列表
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function talkList()
    {
        return TalkSession::with(['user'])->where('user_id', $this->uid())
            ->orderBy('is_top', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}