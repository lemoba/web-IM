<?php declare(strict_types=1);

namespace App\Traits;

trait Singleton
{
    /**
     * @return static
     */
    public static function getInstance()
    {
        return Di(static::class);
    }
}