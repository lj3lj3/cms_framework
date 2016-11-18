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
//    protected $tplDir;
//    protected $modelDir;

    /**
     * @var Template
     */
    protected $tpl;

    /**
     * @var Smarty
     */
//    protected $smarty;
    /**
     * @var Request
     */
//    protected $request;

    public function __construct()
    {
//        $this->tplDir = dirname(dirname(dirname(__FILE__))) . '/resource/views/templates/';
//        $this->modelDir = dirname(dirname(__FILE__)). '/Model/';
//        $this->smarty = $GLOBALS['smarty'];
//        $this->request = $GLOBALS['request'];
        $this->tpl = $GLOBALS['tpl'];
    }

    public function assign($data, $value = '')
    {
        $this->tpl->assign($data, $value);
    }

    /**
     * 如果存在静态页面则返回静态页面
     * @param $path
     * @return bool
     * @throws Exception
     */
    protected function isStatic($path)
    {
        // 读取静态文件
        $staticFile = static_dir . $path;
        if (file_exists(static_dir . $path)) {
            header("Location: /static/$path");
            return true;
        } else if (!is_writable(dirname($staticFile))) {
            throw new Exception(dirname($staticFile) . '目录不可写');
        }
        return false;
    }

    protected function display($templateFile, $staticPath)
    {
        $staticFile = static_dir . $staticPath;
        // 同时生成静态文件
        ob_start();

        $this->tpl->display(tpl_dir . $templateFile);

        file_put_contents($staticFile, ob_get_clean());
        header("Location: /static/$staticPath");
    }

    protected function directDisplay($templateFile)
    {
        $this->tpl->directDisplay(tpl_dir . $templateFile);
    }
}