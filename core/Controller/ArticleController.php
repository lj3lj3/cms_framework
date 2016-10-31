<?php
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:19 PM
 */

//namespace Core\Controller;

require dirname(dirname(__FILE__)) . "/Model/BaseModel.php";
require dirname(dirname(__FILE__)) . "/Model/Article.php";
require 'BaseController.php';


class ArticleController extends BaseController {

    public function index()
    {
//        $articleObject = new Article;
//
//        $articles = $articleObject->queryAll();
        $articles = Article::newInstance()->all();

//        require __DIR__ . '/../../resources/views/article/index.php';

//        $smarty = $GLOBALS['smarty'];

//        $this->smarty->assign('name','Ned');
        $this->smarty->assign('articles', $articles);

        //** un-comment the following line to show the debug console
        //$smarty->debugging = true;

        $this->smarty->display($this->tplDir . 'article/index.php');
    }

    public function create()
    {
//        echo "create";
        $this->smarty->display($this->tplDir . 'article/create.php');
//        require __DIR__ . '/../../resources/views/article/create.php';
    }

    public function store()
    {
        $post = $GLOBALS['request']['post'];

        $articleObject =
        $result = Article::newInstance()->insert($post['title'], $post['content']);

        return $result;
    }

    public function edit()
    {
        $params = $GLOBALS['request']['parameters'];
        $article = Article::newInstance()->query($params['id']);
//        $article = $articleObject->query($params['id']);

        $this->smarty->assign('article', $article[0]);
        $this->smarty->display($this->tplDir . 'article/edit.php');
//        require __DIR__ . '/../../resources/views/article/edit.php';
    }

    public function update()
    {
        $post = $GLOBALS['request']['post'];

        $row = Article::newInstance()->update($post['id'], $post['title'], $post['content']);
//        $articleObject = new Article;
//        $row = $articleObject->update($post['id'], $post['title'], $post['content']);

        echo $row;
    }

    public function delete()
    {
        $params = $GLOBALS['request']['parameters'];
        $result = Article::newInstance()->delete($params['id']);
        echo $result;
    }
}

//$article = new Article($config['database']);
/*$articleController = new ArticleController;

switch ($uri) {
    case 'article':
        if($GLOBALS['method'] == "GET") {
            $articleController->index();
        } else if ($GLOBALS['method'] == 'POST') {
            $articleController->store();
        }
        break;
    case 'article/edit':
        if($GLOBALS['method'] == "GET"){
            $articleController->edit();
        } else if ($GLOBALS['method'] == 'POST') {
            $articleController->update();
        }
        break;
    case 'article/create':
        $articleController->create();
        break;
}*/

