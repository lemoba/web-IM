<?php declare(strict_types=1);

namespace App\Dao;

use App\Model\User;
use support\Model;

class UserDao extends BaseDao
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * 根据主键查找
     * @param  int  $user_id
     * @return Model
     */
    public function findById(int $user_id)
    {
        return $this->find($user_id);
    }

    public function findByMobile(string $mobile, array $columns = ['*'])
    {
        return $this->first(['mobile' => $mobile], $columns);
    }

    public function isExistMobile(string $mobile): bool
    {
        return $this->where(['mobile' => $mobile])->exists();
    }
}