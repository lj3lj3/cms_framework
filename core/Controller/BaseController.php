<?php
//namespace Core\Controller;
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/23
 * Time: 11:01
 */
class BaseController
{
    protected $tplDir;
    protected $modelDir;

    /**
     * @var Smarty
     */
    protected $smarty;

    public function __construct()
    {
        $this->tplDir = dirname(dirname(dirname(__FILE__))) . '/resource/views/templates/';
        $this->modelDir = dirname(dirname(__FILE__)). '/Model/';
        $this->smarty = $GLOBALS['smarty'];
    }

    // TODO: 在middleware中调用每个目录的Controller中的此方法 进行权限检查
    public static function checkPermission($request)
    {

    }
}