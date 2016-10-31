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

    public function __construct()
    {
        $this->tableName = ArticleData::TABLE_NAME;
        parent::__construct();
    }

    /**
     * TODO: 自动匹配值并进行自动赋值操作
     * @return mixed
     */
    public function save()
    {
        // TODO: Implement save() method.
    }

    /**
     * 将对象转换成数组 用于前台显示
     * @return mixed 包含全部变量的数组
     */
    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
}