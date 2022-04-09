<?php

namespace app\controller;

use App\helper\CodeReponse;
use support\Request;

class BaseController
{
    protected function codeReturn(array $codeReponse, $data, $info = '')
    {
        [$code, $msg] = $codeReponse;
        $msg = !empty($info) ? $info : $msg;
        $res = ['code' => $code, 'msg' => $msg];

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
        return $this->codeReturn(CodeReponse::SUCCESS, $data);
    }

    public function fail(array $codeResponse = CodeReponse::FAIL, $info = '')
    {
        return $this->codeReturn($codeResponse, null, $info);
    }

    public function message(array $codeResponse = CodeReponse::SUCCESS, $info = '')
    {
        return $this->codeReturn($codeResponse, null, $info);
    }
}
