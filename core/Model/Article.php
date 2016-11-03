<?php

//namespace Core\Model;
require_once dirname(__FILE__) . "/ArticleData.php";

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/22
 * Time: 8:38
 */
class Article extends BaseModel
{
    const TAG = "Article";

    const TABLE_NAME = 'article';

    // columns of this table
    const C_CAT_ID = "catid";
    const C_TITLE = 'title';
    /**
     * 未知
     */
    const C_STYLE = "style";
    const C_AUTHOR = "author";
    /**
     * 核审人员
     */
    const C_VERIFIER = "verifier";
    /**
     * 签发人员
     * TODO: 更改为issuer
     */
    const C_ISSUER = "qianfa";
    const C_COPY_FROM = "copyfrom";
    const C_THUMB = "thumb";
    const C_KEYWORDS = "keywords";
    const C_DESCRIPTION = "description";
    const C_POSTER = "poster";
    /**
     * 所属专题
     */
    const C_SPECIAL = "special";
    const C_IS_LINK = "islink";
    const C_URL = "url";
    const C_HITS = "hits";
    /**
     * 录入者ID
     * TODO: 去除录入者ID
     */
    const C_USER_ID = "userid";
    /**
     * 录入者名称
     */
    const C_USER_NAME = "username";
    /**
     * TODO: 更改为publishedtime
     */
    const C_PUBLISHED_TIME = "inputtime";
    const C_UPDATE_TIME = "updatetime";
    /**
     * 未知
     */
    const C_SORT = "sort";
    const C_STATUS = "status";

    /**
     * 这是是article_data之中的数据
     */
//    const C_CONTENT = "content";

//    protected $pdo = '';
    public $catId = '';
    public $title = '';
    public $style = '';
    public $author = '';
    public $verifier = '';
    public $issuer = '';
    public $copyFrom = '';
    public $thumb = '';
    public $keywords = '';
    public $description = '';
    public $poster = '';
    public $special = '';
    public $isLink = '';
    public $url = '';
    public $hits = '';
    public $userId = '';
    public $userName = '';
    public $publishedTime = '';
    public $updateTime = '';
    public $sort = '';
    public $status = '';

//    public $content = '';

//    protected $content = '';

//    public function __construct()
//    {
//        parent::__construct();
//
//    }

//    protected $tableName = '';


    /*public function __construct($databaseConfig)
    {
        $this->pdo = new PDO($databaseConfig['dsn'], $databaseConfig['name'], $databaseConfig['password']);
    }*/

    public function __construct($id = null)
    {
//        $dbConfig = $GLOBALS['config']['database'];
//        $this->pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=test', 'root', 'root');
//        $this->pdo = new PDO($dbConfig['dsn'], $dbConfig['name'], $dbConfig['password']);
        $this->tableName = Article::TABLE_NAME;
        parent::__construct($id);
    }

    /*public function queryAll()
    {
        $statement = $this->pdo->query("select * from " . $this->tableName);
//        echo $statement;
        $statement->setFetchMode(PDO::FETCH_OBJ);
//        $statement->execute();
        return $statement->fetchAll();
    }*/

    public function query()
    {
        $this->whereKeyAndValue = array(
            Article::C_ID => $this->id
        );
        $this->setFetchMode(null, get_class($this));
//        $this->doQuery();
//        $this->pdo
//        $statement = $this->pdo->query('select * from '. $this->tableName . ' where id = ' . $id);
//        $statement->setFetchMode(PDO::FETCH_OBJ);
        return $this->doQuery();
    }

    public function queryWithContent()
    {
        $this->whereKeyAndValue = array(
            $this->getTableName() . "." . Article::C_ID => $this->id
        );
        $article = new Article();
        $articleData = new ArticleData();

//        $this->queryBuilder("*")->join($articleData)->on($article, Article::C_ID, $articleData, ArticleData::C_ID)->where()
//        ->justRun();
//        $this->doQuery();
//        $this->pdo
//        $statement = $this->pdo->query('select * from '. $this->tableName . ' where id = ' . $id);
//        $statement->setFetchMode(PDO::FETCH_OBJ);
        return $this->queryBuilder("*")->join($articleData)->on($article, Article::C_ID, $articleData,
        ArticleData::C_ID)->where()
            ->justRun();
    }

    public function save()
    {
        $this->keyAndValue = $this->toArray();
        // 不写入点击量
        unset($this->keyAndValue[Article::C_HITS]);

        return $this->doInsert();
//        $statement = $this->pdo->prepare("insert into $this->tableName (title, content) VALUES (:title,
//        :content)");
//        $statement->setAttribute(":table", $this->tableName);
//        $statement->setAttribute(":title", $title);
//        $statement->setAttribute(":content", $content);
//        $statement->setAttribute(":id", $id);
//        return $statement->execute(array(
//            ":table" => $this->tableName,
//            ":title" => $title,
//            ":content" => $content,
//            ":id" => $id,
//        ));
//        $statement = $this->pdo->query('select * from '. $this->tableName . ' where id = ' . $id);
//        $statement->setFetchMode(PDO::FETCH_OBJ);
    }

    /**
     * 将对象转换成数组 用于前台显示和后台持久化
     * @return mixed 包含全部变量的数组
     */
    public function toArray()
    {
        return array(
            Article::C_CAT_ID => $this->catId,
            Article::C_TITLE => $this->title,
            Article::C_STYLE => $this->style,
            Article::C_AUTHOR => $this->author,
            Article::C_VERIFIER => $this->verifier,
            Article::C_ISSUER => $this->issuer,
            Article::C_COPY_FROM => $this->copyFrom,
            Article::C_THUMB => $this->thumb,
            Article::C_KEYWORDS => $this->keywords,
            Article::C_DESCRIPTION => $this->description,
            Article::C_POSTER => $this->poster,
            Article::C_SPECIAL => $this->special,
            Article::C_IS_LINK => $this->isLink,
            Article::C_URL => $this->url,
            Article::C_HITS => $this->hits,
            Article::C_USER_ID => $this->userId,
            Article::C_USER_NAME => $this->userName,
            Article::C_PUBLISHED_TIME => $this->publishedTime,
            Article::C_UPDATE_TIME => $this->updateTime,
            Article::C_SORT => $this->sort,
            Article::C_STATUS => $this->status,
        );
    }
}