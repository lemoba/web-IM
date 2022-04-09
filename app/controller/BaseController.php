<?php

namespace app\controller;

use App\helper\CodeResponse;
use support\Request;

class BaseController
{
    protected function codeReturn(array $codeReponse, $data, $info = '')
    {
        [$code, $msg] = $codeReponse;
        $res = ['code' => $code, 'msg' => $info ?: $msg];

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
}
