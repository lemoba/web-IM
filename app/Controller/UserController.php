<?php declare(strict_types=1);

namespace App\Controller;

use support\Request;
use Tinywan\Jwt\JwtToken;

class UserController extends BaseController
{
    public function setting()
    {
        return $this->success();
    }

    public function detail(Request $request)
    {
        return $this->success($request->uid);
    }
}