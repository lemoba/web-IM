<?php declare(strict_types=1);

namespace App\Controller;

use App\Helper\CodeResponse;

abstract class AbstractController
{
    private function codeReturn(array $codeReponse, $data, $info = '')
    {
        [$code, $msg] = $codeReponse;
        $res = ['code' => $code, 'message' => $info ?: $msg];

        if (!is_null($data)) {
            // if (is_array($data)) {
            //     $data = array_filter($data, function ($item) {
            //         return $item != null;
            //     });
            // }
            $res['data'] = $data;
        }
        return json($res);
    }

    final function success($data = null)
    {
        return $this->codeReturn(CodeResponse::SUCCESS, $data);
    }

    final function fail(array $codeResponse = CodeResponse::FAIL, $info = '')
    {
        return $this->codeReturn($codeResponse, null, $info);
    }

    final function message(array $codeResponse = CodeResponse::SUCCESS, $info = '')
    {
        return $this->codeReturn($codeResponse, null, $info);
    }

    final function failOrSuccess(bool $flag)
    {
        if ($flag) {
            return $this->success();
        }
        return $this->fail();
    }
}