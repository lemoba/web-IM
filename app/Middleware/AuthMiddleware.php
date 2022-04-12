<?php declare(strict_types=1);

namespace App\Middleware;

use App\Enum\CommEnum;
use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Service\UserService;
use DI\Annotation\Inject;
use Shopwwi\WebmanAuth\Facade\Auth;
use support\Redis;
use Tinywan\Jwt\JwtToken;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{

    /**
     * @Inject()
     * @var UserService
     */
    protected $userService;

    public function process(Request $request, callable $next): Response
    {
        $uid = $this->userService->uid();
        if (!$uid || !Redis::exists(CommEnum::ACCESS_TOKEN.$uid)) {
            return json([
                'code' => 401,
                'message' => 'unauthorized'
            ]);
        }
        return $next($request);
    }
}