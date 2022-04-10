<?php declare(strict_types=1);

namespace App\Middleware;

use Tinywan\Jwt\JwtToken;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{

    public function process(Request $request, callable $next): Response
    {
        $request->uid = JwtToken::getCurrentId();
        return $next($request);
    }
}