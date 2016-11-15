<?php

defined('IN_CMS') or exit('No direct script access allowed');;
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:19 PM
 */
class AdminArticleController extends BaseController
{
    const TAG = "AdminArticleController";

    public function index()
    {
        $db = new DB();
        $counts = $db->count('article');

        $px = new Pagex(20);    //每条20
        // 数据返回一个数组 然后每条记录又是一个数组
        $px->total = $counts[0][0];
        $pageHtml = $px->pageshow('admin');

        $articles = $db->query('article', '', 'updatetime desc', "$px->thispage, $px->pagesize");

        // 转换时间
        $count = count($articles);
        for ($index = 0; $index < $count; $index++) {
            $articles[$index]['updatetime'] = getFormattedTime($articles[$index]['updatetime']);
        }


//        $this->smarty->assign('articles', $articles);
//        $this->smarty->assign('pageHtml', $pageHtml);

//        $this->smarty->display(tpl_dir . 'admin/article/index.tpl');
//        require_once dirname(dirname(dirname(__FILE__))) . '/Template.php';

//        $tpl = new Template();

        $this->tpl->assign(array(
            'pageHtml' =>$pageHtml,
            'articles' => $articles
        ));

        $this->tpl->directDisplay(tpl_dir . 'admin/article/index.html.php');
    }

    public function create()
    {
        $this->tpl->directDisplay(tpl_dir . 'admin/article/create.html.php');
    }

    public function store()
    {
        $db = new DB();
        $insertId = $db->insert('article', array(
            'catid' => 1,    // 之后修改
            'title' => getRequestParam('title'),
            'author' => 'test',
            'verifier' => getRequestParam('verifier'),
            'qianfa' => getRequestParam('qianfa'),
            'copyfrom' => getRequestParam('copyfrom'),
            'thumb' => getRequestParam('thumb'),
            'keywords' => getRequestParam('keywords'),
            'description' => getRequestParam('description'),
            'poster' => getRequestParam('poster'),
            'special' => getRequestParam('special', 0),
            'islink' => getRequestParam('islink', 0),
            'url' => getRequestParam('url'),
            'userid' => getRequestParam('userid'),
            'username' => getRequestParam('username', 'test'),
            'inputtime' => time(),
            'updatetime' => time(),
            'sort' => getRequestParam('sort'),
            'status' => getRequestParam('status'),
        ));
        $insertId = $db->insert('article_data', array(
            'id' => $insertId,
            'content' => getRequestParam('content'),
        ));

        echo $insertId != NULL ? "成功s" : "失败f";
    }

    public function edit()
    {
        $id = getRequestParam('id');
        $db = new DB();
        $tArticleName = $db->tablePrefix . 'article';
        $tArticleDataName = $db->tablePrefix . 'article_data';
        /**
         * @var $articleArray array
         */
        $articleArray = $db->sql("select * from $tArticleName left join $tArticleDataName on $tArticleName.id = 
        $tArticleDataName.id where $tArticleName.id = $id");

        if (count($articleArray) == 0) {
            throw new Exception("没有记录");
        }
        $this->tpl->assign('article', $articleArray[0]);
        $this->tpl->directDisplay(tpl_dir . 'admin/article/edit.html.php');
    }

    public function update()
    {
        $db = new DB();
        $rowCount = $db->update('article', array(
//            'catid' => 1,    // 之后修改
            'title' => getRequestParam('title'),
            'author' => 'test',
            'verifier' => getRequestParam('verifier'),
            'qianfa' => getRequestParam('qianfa'),
            'copyfrom' => getRequestParam('copyfrom'),
            'thumb' => getRequestParam('thumb'),
            'keywords' => getRequestParam('keywords'),
            'description' => getRequestParam('description'),
            'poster' => getRequestParam('poster'),
            'special' => getRequestParam('special', 0),
            'islink' => getRequestParam('islink', 0),
            'url' => getRequestParam('url'),
//            'userid' => getRequestParam('userid'),
//            'username' => getRequestParam('username'),
//            'inputtime' => time(),
            'updatetime' => time(),
//            'sort' => getRequestParam('sort'),
            'status' => getRequestParam('status'),
        ), array(
            'id' => getRequestParam('id', 0)
        ));

        if ($rowCount != 1) {
            throw new Exception("update error:");
        }

        $rowCountContent = $db->update('article_data', array(
            'content' => getRequestParam('content'),
        ), array(
            'id' => getRequestParam('id', 0),
        ));

        echo $rowCount == 1 ? "成功s" : "失败f";
        echo '<br>';
        echo $rowCountContent == 1 ? "内容修改成功" : "内容未更改或修改失败";
    }

    public function delete()
    {
//        $id = getRequestParam('id', 0);
        if(isset($_POST['checkbox'])){
            $id = getRequestParam('checkbox', 0);
        } else {
            $id = getRequestParam('id', 0);
        }

        $db = new DB();
        $rowCount = $db->delete('article', array(
            'id' => $id,
        ));
        echo $rowCount == 1 ? "成功s" : "失败f";
    }
}
