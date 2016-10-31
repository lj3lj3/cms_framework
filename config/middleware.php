<?php
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/26
 * Time: 15:46
 */

return array(
    'CookieMiddleware',     //首先使用Cookie中间件
    'SessionMiddleware',
    'PermissionMiddleware',
);