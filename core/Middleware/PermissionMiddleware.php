<?php

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/9
 * Time: 11:39
 */
class PermissionMiddleware extends Middleware
{

    public function handler($request, $pipes)
    {



        parent::handler($request, $pipes);

//        echo "end permission<br>";
    }
}