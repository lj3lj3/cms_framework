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
}