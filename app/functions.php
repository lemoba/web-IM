<?php

if (! function_exists('reloadRoute')) {
    /**
     * 加载路由.
     */
    function reloadRoute()
    {
        $path = base_path() . '/routes';
        $dirs = scandir($path);
        foreach ($dirs as $dir) {
            if ($dir != '.' && $dir != '..') {
                $routeFilePath = $path . "/{$dir}";
                require_once $routeFilePath;
            }
        }
    }
}

/*
 * 加密
 */
if (!function_exists('pwCrypt')) {
    function pwCrypt($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

/*
 * 解密
 */
if (!function_exists('pwDecrpt')) {
    function pwDecrpt($input, $real) {
        return password_verify($input, $real);
    }
}