<?php
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:19 PM
 */

//namespace Core\Controller;

require_once dirname(dirname(dirname(__FILE__))) . '/Model/BaseModel.php';
require_once dirname(dirname(dirname(__FILE__))) . '/Model/Article.php';
require_once dirname(dirname(__FILE__)) . '/BaseController.php';

require_once dirname(dirname(dirname(__FILE__))) . '/VO/Common/DivTitle.php';
require_once dirname(dirname(dirname(__FILE__))) . '/Model/Article.php';

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/swcms/Page.class.php';


class AdminArticleController extends BaseController
{
    const TAG = "AdminArticleController";


    public function index()
    {
        // PageX中自动获取p参数为页面数
//        $p = $this->request->getParam("p");
//        if ($p == NULL) {
//            $p = 0;
//        }

        $articleObj = Article::newInstance();
        $counts = $articleObj->queryBuilder("count(*)")->justRun();
        $px = new Pagex(20);    //每条20
        // 数据返回一个数组 然后每条记录又是一个数组
        $px->total = $counts[0][0];

//        $articleObject = new Article;
//
//        $articles = $articleObject->queryAll();
        $articles = $articleObj->queryBuilder("*")->orderBy(array(Article::C_UPDATE_TIME),
            array
            (BaseModel::DESC))
            ->limit($px->thispage, $px->pagesize)
            ->justRun();

//        require __DIR__ . '/../../resources/views/article/index.php';

//        $smarty = $GLOBALS['smarty'];

//        $this->smarty->assign('name','Ned');
        $pageHtml = $px->pageshow('admin');

        // 转换时间
        $count = count($articles);
        for ($index = 0; $index < $count; $index++) {
            $articles[$index][Article::C_UPDATE_TIME] = date("Y-m-d H:i:s", $articles[$index][Article::C_UPDATE_TIME]);
        }

        $this->smarty->assign('articles', $articles);
        $this->smarty->assign('pageHtml', $pageHtml);

        //** un-comment the following line to show the debug console
        //$smarty->debugging = true;

        $this->smarty->display($this->tplDir . 'admin/article/index.tpl');
    }

    /*public function show()
    {
        $divTitle = new DivTitle();
        $divTitle->left_title = "要闻";
        $divTitle->add2right("首页", "http://yl.wenming.cn/");
        $divTitle->add2right("要闻", "http://yl.wenming.cn/jrtj/");
        $data['divTitle'] = $divTitle->toArray();

        $id = $this->request->getParam("id");
        if ($id == NULL) {
            $id = 0;
        }

        /**
         * @var $articleArray array
         *//*
        $articleArray = Article::newInstance($id)->queryWithContent();
        // 转换时间
        $articleArray[0][Article::C_UPDATE_TIME] = date("Y-m-d H:i:s", $articleArray[0][Article::C_UPDATE_TIME]);

        $data['article'] = $articleArray[0];

        $this->smarty->assign("data", $data);
        $this->smarty->display($this->tplDir . "article.tpl");
    }*/

    public function create()
    {
//        echo "create";
        $this->smarty->display($this->tplDir . 'admin/article/create.tpl');
//        require __DIR__ . '/../../resources/views/article/create.php';
    }

    public function store()
    {
        // 多张表对应多个Model
        $article = Article::newInstance();
        $article->catId = 1;    // 之后修改
        $article->title = $this->request->getParam(Article::C_TITLE, "");
        $article->style = $this->request->getParam(Article::C_STYLE, "");
        $article->author = $this->request->getParam(Article::C_AUTHOR, "");
        $article->verifier = $this->request->getParam(Article::C_VERIFIER, "");
        $article->issuer = $this->request->getParam(Article::C_ISSUER, "");
        $article->copyFrom = $this->request->getParam(Article::C_COPY_FROM, "");
        $article->thumb = $this->request->getParam(Article::C_THUMB, "");
        $article->keywords = $this->request->getParam(Article::C_KEYWORDS, "");
        $article->description = $this->request->getParam(Article::C_DESCRIPTION, "");
        $article->poster = $this->request->getParam(Article::C_POSTER, "");
        $article->special = $this->request->getParam(Article::C_SPECIAL, 0);
        $article->isLink = $this->request->getParam(Article::C_IS_LINK, 0);
        $article->url = $this->request->getParam(Article::C_URL, "");
        //$article->hits = $this->request->getParam(Article::C_HITS, "");
        // 从session中读取
        $article->userId = 0;
        $article->userName = "test";
        $article->updateTime = $article->publishedTime = time();
        $article->sort = $this->request->getParam(Article::C_SORT, 0);
        $article->status = $this->request->getParam(Article::C_STATUS, 0);
        $insertId = $article->save();

        $articleData = ArticleData::newInstance($insertId);
        $articleData->content = $this->request->getParam(ArticleData::C_CONTENT, "");
        $insertId = $articleData->save();



//        $articleData = ArticleData::newInstance($id);

//        $row = Article::newInstance()->update($post['id'], $post['title'], $post['content']);
//        $articleObject = new Article;
//        $row = $articleObject->update($post['id'], $post['title'], $post['content']);

        echo $insertId != NULL ? "成功" : "失败";
    }

    public function edit()
    {
        $articleArray = Article::newInstance($this->request->getParam(Article::C_ID, 0))->queryWithContent();

        if (count($articleArray) == 0) {
            throw new Exception("没有记录");
        }
        $this->smarty->assign('article', $articleArray[0]);
        $this->smarty->display($this->tplDir . 'admin/article/edit.tpl');
//        require __DIR__ . '/../../resources/views/article/edit.php';
    }

    public function update()
    {
        $params = $this->request->parameters();
        $id = $this->request->getParam(BaseModel::C_ID, 0);
        // 多张表对应多个Model
        $article = Article::newInstance($id);
        $rowCount = $article->update(array(
            Article::C_TITLE => $params[Article::C_TITLE],
            Article::C_AUTHOR => $params[Article::C_AUTHOR],
            Article::C_VERIFIER => $params[Article::C_VERIFIER],
            Article::C_ISSUER => $params[Article::C_ISSUER],
            Article::C_COPY_FROM => $params[Article::C_COPY_FROM],
            Article::C_THUMB => $params[Article::C_THUMB],
            Article::C_DESCRIPTION => $params[Article::C_DESCRIPTION],
            Article::C_URL => $params[Article::C_URL],
            // 如果设置了islink就代表已经选中了
            Article::C_IS_LINK => isset($params[Article::C_IS_LINK]) ? 1 : 0,
            // 更新updatetime为当前时间
            Article::C_UPDATE_TIME => time(),
            Article::C_STATUS => $params[Article::C_STATUS],
        ));
        if ($rowCount != 1) {
            throw new Exception("update error:" . $params);
        }

        $articleData = ArticleData::newInstance($id);
//        $articleData->content = $this->request->getParam(ArticleData::EDITOR_VALUE, "");
        $rowCount = $articleData->update(array(
            ArticleData::C_CONTENT => $this->request->getParam(ArticleData::C_CONTENT, ""),
        ));


//        $articleData = ArticleData::newInstance($id);

//        $row = Article::newInstance()->update($post['id'], $post['title'], $post['content']);
//        $articleObject = new Article;
//        $row = $articleObject->update($post['id'], $post['title'], $post['content']);

        echo $rowCount == 1 ? "成功" : "失败";
    }

    public function delete()
    {
        echo Article::newInstance($this->request->getParam(BaseModel::C_ID, 0))->delete() == 1 ? "成功" : "失败";
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

