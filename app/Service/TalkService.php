<?php declare(strict_types=1);

namespace App\Service;

use App\Dao\TalkDao;
use App\Model\TalkSession;
use App\Traits\Singleton;
use DI\Annotation\Inject;

class TalkService extends BaseService
{
    use Singleton;
    /**
     * @Inject()
     * @var TalkDao
     */
    protected $talkDao;

    public function createTalk(array $data)
    {
        $data['user_id'] = $this->uid();
        $data['created_at'] = date('Y-m-d H:m:s');
        $data['updated_at'] = date('Y-m-d H:m:s');
        return $this->talkDao->createTalkSession($data);
    }

    public function talkList()
    {
        return TalkSession::with(['user' => function ($query) {
            $query->select('id', 'nickname', 'gender',  'motto', 'is_robot', 'avatar');
        }])->where('user_id', $this->uid())
            ->orderBy('is_top', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}