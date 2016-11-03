<?php

require_once dirname(dirname(dirname(__FILE__))) . "/Model/BaseModel.php";
require_once dirname(dirname(dirname(__FILE__))) . "/Model/Article.php";
require_once dirname(dirname(__FILE__)) . '/BaseController.php';

require_once dirname(dirname(dirname(__FILE__))) . '/VO/Common/DivTitle.php';
require_once dirname(dirname(dirname(__FILE__))) . '/Model/Article.php';
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/11/1
 * Time: 11:41
 */
class ArticleController extends BaseController
{


    public function show()
    {
        $divTitle = new DivTitle();
        $divTitle->left_title = "要闻";
        $divTitle->add2right("首页", "http://yl.wenming.cn/");
        $divTitle->add2right("要闻", "http://yl.wenming.cn/jrtj/");
        $data['divTitle'] = $divTitle->toArray();

        $id = $this->request->getParam("id");
        if ($id == NULL) {
            $id = 1;
        }

        /**
         * @var $articleArray array
         */
        $articleArray = Article::newInstance($id)->queryWithContent();
        // 转换时间
        $articleArray[0][Article::C_UPDATE_TIME] = date("Y-m-d H:i:s", $articleArray[0][Article::C_UPDATE_TIME]);

        $data['article'] = $articleArray[0];

        $this->smarty->assign("data", $data);
        $this->smarty->display($this->tplDir . "article/show.tpl");
    }
}