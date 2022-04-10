<?php

namespace App\Controller;

use App\Helper\CodeResponse;
use App\Validate\AuthValidate;
use support\Request;

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


    public function crypt(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function decrpt(string $input, string $real): bool
    {
        return password_verify($input, $real);
    }
}
