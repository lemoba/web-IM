<?php declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Webman\Exception\ExceptionHandler;
use Webman\Http\Request;
use Webman\Http\Response;

class Handler extends ExceptionHandler
{

    public function report(Throwable $e)
    {
        return parent::report($e);
        // TODO: Implement report() method.
    }

    public function render(Request $request, Throwable $e): Response
    {
        if ($e instanceof BusinessException) {
            return json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
        return parent::render($request, $e);
    }
}