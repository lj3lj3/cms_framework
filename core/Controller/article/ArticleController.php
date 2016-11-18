<?php

defined('IN_CMS') or exit('No direct script access allowed');;
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/11/1
 * Time: 11:41
 */
class ArticleController extends BaseController
{
    const TAG = 'ArticleController';

    public function show()
    {
        $data['divTitle'] = array(
            'img' => '',
            'left_title' => '要闻',
            'left_link' => '',
            'right' => array(
                '首页' => 'http://yl.wenming.cn/',
                '要闻' => 'http://yl.wenming.cn/jrtj/',
            ),
        );

        $id = getRequestParam('id');

        // 读取静态文件
        $path = "article/$id.html";
        if($this->isStatic($path)){
            return;
        }

        // 静态文件不存在 读取数据库 进行显示并生成新的静态文件
        $db = new DB();
        $tArticleName = $db->tablePrefix . 'article';
        $tArticleDataName = $db->tablePrefix . 'article_data';
        /**
         * @var $articleArray array
         */
        $articleArray = $db->sql("select * from $tArticleName left join $tArticleDataName on $tArticleName.id = 
        $tArticleDataName.id where $tArticleName.id = $id");

        // 转换时间
        $articleArray[0]['updatetime'] = getFormattedTime($articleArray[0]['updatetime']);

        $data['article'] = $articleArray[0];

        $this->assign("data", $data);
        $this->display("article/show.html", $path);
    }
}