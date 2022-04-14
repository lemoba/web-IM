<?php declare(strict_types=1);

namespace App\Dao\Talk;

use App\Dao\BaseDao;
use App\Model\TalkRecord;

class TalkRecordDao extends BaseDao
{
    public function __construct(TalkRecord $model)
    {
        parent::__construct($model);
    }

    /**
     * 保存消息
     * @param  array  $data
     * @return void
     */
    public function saveMessage(array $data)
    {
        $this->create($data);
    }

    public function getMsgList(array $where)
    {
        return TalkRecord::query()->whereIn('user_id', $where)
            ->whereIn('receiver_id', $where)
            ->limit(1000)
            ->get();
    }
}