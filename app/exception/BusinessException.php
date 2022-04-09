<?php declare(strict_types=1);

namespace App\exception;


use Throwable;
use Webman\Exception\ExceptionHandlerInterface;
use Webman\Http\Request;
use Webman\Http\Response;

class BusinessException extends \Exception
{
    public function __construct(array $codeResponse, $info = '')
    {
        [$code, $msg] = $codeResponse;
        parent::__construct($info ?: $msg, $code);
    }
}