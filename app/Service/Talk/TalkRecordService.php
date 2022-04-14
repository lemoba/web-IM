<?php declare(strict_types=1);

namespace App\Service\Talk;

use App\Dao\Talk\TalkRecordDao;
use App\Dao\Talk\TalkSessionDao;
use App\Service\BaseService;
use App\Traits\Singleton;
use DI\Annotation\Inject;

class TalkRecordService extends BaseService
{
    use Singleton;
    /**
     * @Inject()
     * @var TalkRecordDao
     */
    protected $talkRecordDao;

    /**
     * 保存消息
     * @param  array  $data
     * @return void
     */
    public function saveMessage(array $data)
    {
        $this->talkRecordDao->saveMessage($data);
    }

    public function getTalkRecordList(int $receiver_id)
    {
        $where = [
            'user_id' => $this->uid(),
            'receiver_id' => $receiver_id
        ];
        return $this->talkRecordDao->getMsgList($where);
    }
}