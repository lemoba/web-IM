<?php declare(strict_types=1);

namespace App\Service;

use Tinywan\Jwt\JwtToken;

class BaseService
{
    /**
     * 获取uid
     * @return int
     */
    public function uid(): int
    {
        return JwtToken::getCurrentId();
    }
    // abstract public static function getInstance();
}