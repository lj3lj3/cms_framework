<?php
namespace Core\Controller;
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/23
 * Time: 11:01
 */
class BaseController
{
    protected $tplDir;

    protected $smarty;

    public function __construct()
    {
        $this->tplDir = dirname(dirname(__DIR__)) . '/resource/views/templates/';
        $this->smarty = $GLOBALS['smarty'];
    }
}