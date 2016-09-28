<?php
namespace Core\Controller\admin;

use Core\Controller\BaseController;

require dirname(__DIR__) . '/BaseController.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/23
 * Time: 11:19
 */


//require dirname(dirname(dirname(__FILE__))) . "/Model/BaseModel.php";
//require dirname(dirname(__FILE__)) . '/BaseController.php';


class AdminController extends BaseController
{

    public function index()
    {
        $this->smarty->display($this->tplDir . 'admin/index.html.tpl');
    }
}

//$controller = new AdminController();
//$controller->index();
