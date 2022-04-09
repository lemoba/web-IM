<?php declare(strict_types=1);

namespace App\controller;

use App\helper\CodeReponse;
use support\Db;
use support\Log;
use support\Redis;

class CheckHealthController extends BaseController
{
    public function check_health()
    {
        try {
            Db::select('select 1;');
            Redis::ping(1);
            return $this->message(CodeReponse::SUCCESS, 'web database and redis is working');
        }catch (\Exception $e) {
            Log::error('database or redis is not working');
            return $this->fail(CodeReponse::FAIL, 'database or redis is not working: '.$e->getMessage());
        }
    }
}