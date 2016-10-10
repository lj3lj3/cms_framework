<?php

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/9
 * Time: 15:22
 */
class PermissionControllerTest extends PHPUnit_Framework_TestCase
{

    public function testGetAllUser()
    {
        $pc = new PermissionController();
        $results = $pc->getAllUser();
        $this->assertEmpty($results);
    }

}
