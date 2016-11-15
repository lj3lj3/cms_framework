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

        $this->tpl->assign("data", $data);
        $this->tpl->display(tpl_dir . "article/show.html");
    }
}