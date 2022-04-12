<?php declare(strict_types=1);

namespace App\Dao;

use App\Traits\DaoTrait;
use support\Model;

/**
 * @method Model create(array $value) 新增
 * @method Model find(int $id, array $fields = ['*']) 主键查询
 */

class BaseDao
{
    /**
     * @var Model
     */
    private $model;


    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function __call(string $method, array $arguments)
    {
        return (new $this->model)->{$method}(...$arguments);

        throw new \Exception("Uncaught Error: Call to undefined method {$method}");
    }

    public function first(array $key, array $columns = ['*'])
    {
        return $this->model->select($columns)->where($key)->first();
    }

    public function update(array $key, array $data)
    {
        return $this->model->where($key)->update($data);
    }
}