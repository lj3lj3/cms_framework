<?php

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/27
 * Time: 11:41
 */
class ArticleData extends BaseModel
{
    const TABLE_NAME = 'article_data';

    const C_CONTENT = "content";

    const EDITOR_VALUE = "editorValue";

    public $content;


    public function __construct($id = null)
    {
        $this->tableName = ArticleData::TABLE_NAME;
        parent::__construct($id);
    }

    /**
     * TODO: 自动匹配值并进行自动赋值操作
     * @return mixed
     */
    public function save()
    {
        $this->keyAndValue = $this->toArray();
        return $this->doInsert();
    }

    /*public function update()
    {
        return parent::update(array(
            ArticleData::C_CONTENT => $this->content,
        ));
    }*/

    /**
     * 将对象转换成数组 用于前台显示
     * @return mixed 包含全部变量的数组
     */
    public function toArray()
    {
        return array(
            ArticleData::C_ID => $this->id,
            ArticleData::C_CONTENT => $this->content
        );
    }
}