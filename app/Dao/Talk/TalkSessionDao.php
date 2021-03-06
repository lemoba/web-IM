<?php declare(strict_types=1);

namespace App\Dao\Talk;

use App\Dao\BaseDao;
use App\Model\TalkSession;

class TalkSessionDao extends BaseDao
{
    public function __construct(TalkSession $model)
    {
        parent::__construct($model);
    }

    /**
     * 创建聊天列表
     * @param  array  $data
     * @return void
     */
    public function createTalkSession(array $data)
    {
        $where = [
            'user_id' => $data['user_id'],
            'receiver_id' => $data['receiver_id']
        ];
        $res = $this->where($where)->exists();

        // 有记录就更新
        if ($res) {
            $this->update($where, ['updated_at' => $data['updated_at']]);
            return;
        }
        // 没有就创建
        $this->create($data);
    }
}