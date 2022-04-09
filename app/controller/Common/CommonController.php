<?php declare(strict_types=1);

namespace App\controller\Common;

use app\controller\BaseController;
use support\Request;

class CommonController extends BaseController
{
    public function sendSmsCode(Request $request)
    {
        $mobbile = $request->input('mobbile');
        $data = [
            'is_debug' => 1,
            'sms_code' => 6666
        ];
        return $this->success($data);
    }

}