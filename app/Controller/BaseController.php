<?php

namespace App\Controller;

use App\Helper\CodeResponse;
use think\Validate;

class BaseController
{
    protected function codeReturn(array $codeReponse, $data, $info = '')
    {
        [$code, $msg] = $codeReponse;
        $res = ['code' => $code, 'message' => $info ?: $msg];

        if (!is_null($data)) {
            if (is_array($data)) {
                $data = array_filter($data, function ($item) {
                    return $item != null;
                });
            }
            $res['data'] = $data;
        }
        return json($res);
    }

    public function success($data = null)
    {
        return $this->codeReturn(CodeResponse::SUCCESS, $data);
    }

    public function fail(array $codeResponse = CodeResponse::FAIL, $info = '')
    {
        return $this->codeReturn($codeResponse, null, $info);
    }

    public function message(array $codeResponse = CodeResponse::SUCCESS, $info = '')
    {
        return $this->codeReturn($codeResponse, null, $info);
    }

    /**
     * 验证手机号
     * @param  string  $mobile
     * @return bool
     */
    public function verifyMobile(string $mobile)
    {
        $regex = '/^(((13[0-9]{1})|(15[0-9]{1})|(16[0-9]{1})|(17[3-8]{1})|(18[0-9]{1})|(19[0-9]{1})|(14[5-7]{1}))+\d{8})$/';
        $validate = new Validate();
        $result = $validate->rule('mobile', ['regex' => $regex])->check([
            'mobile' => $mobile
        ]);
        return $result;
    }
}
