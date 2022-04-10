<?php declare(strict_types=1);

namespace App\Traits;

trait Singleton
{
    protected static $instance;

    private function __construct(){}

    private function __clone(){}

    public static function getInstance(...$args)
    {
        if (self::$instance instanceof self) {
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}