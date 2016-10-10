<?php

//namespace Core\Model;

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/22
 * Time: 8:38
 */
class Article extends BaseModel
{
    const TABLE_NAME = 'article';
    // columns of this table
    const C_TITLE = 'title';
    const C_CONTENT = 'content';

//    protected $pdo = '';
    protected $id = 0;
    protected $author = '';
    protected $content = '';

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

    public function __construct()
    {
//        $dbConfig = $GLOBALS['config']['database'];
//        $this->pdo = new PDO('mysql:host=localhost;charset=utf8;dbname=test', 'root', 'root');
//        $this->pdo = new PDO($dbConfig['dsn'], $dbConfig['name'], $dbConfig['password']);
        $this->tableName = Article::TABLE_NAME;
        parent::__construct();
    }

    /*public function queryAll()
    {
        $statement = $this->pdo->query("select * from " . $this->tableName);
//        echo $statement;
        $statement->setFetchMode(PDO::FETCH_OBJ);
//        $statement->execute();
        return $statement->fetchAll();
    }*/

    public function query($id)
    {
        $this->whereKeyAndValue = array(
            Article::C_ID => $id
        );
//        $this->doQuery();
//        $this->pdo
//        $statement = $this->pdo->query('select * from '. $this->tableName . ' where id = ' . $id);
//        $statement->setFetchMode(PDO::FETCH_OBJ);
        return $this->doQuery();
    }

    public function update($id, $title, $content)
    {
        $this->keyAndValue = array(
            Article::C_TITLE => $title,
            Article::C_CONTENT => $content,
        );

        $this->whereKeyAndValue = array(
            Article::C_ID => $id,
        );
        return $this->doUpdate();
//        $result =
//        $statement = $this->pdo->prepare("update $this->tableName set title=:title, content=:content where
//        id=:id");
//        $statement->setAttribute(":table", $this->tableName);
//        $statement->setAttribute(":title", $title);
//        $statement->setAttribute(":content", $content);
//        $statement->setAttribute(":id", $id);
//        return $statement->execute(array(
////            ":table" => $this->tableName,
//            ":title" => $title,
//            ":content" => $content,
//            ":id" => $id,
//        ));
//        $statement = $this->pdo->query('select * from '. $this->tableName . ' where id = ' . $id);
//        $statement->setFetchMode(PDO::FETCH_OBJ);

    }

    public function insert($title, $content)
    {
        $this->keyAndValue = array(
            Article::C_TITLE => $title,
            Article::C_CONTENT => $content,
        );
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

    public function delete($id)
    {
        $this->whereKeyAndValue = array(
            BaseModel::C_ID => $id,
        );

        return $this->doDelete();
    }

    public function content()
    {
        return $this->content;
    }

    public function author()
    {
        return $this->author;
    }

    public function save()
    {
        // TODO: Implement save() method.
    }
}