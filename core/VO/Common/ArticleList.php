<?php

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/26
 * Time: 15:59
 */
class ArticleList
{
    const KEY_TITLE = "title";
    const KEY_LINK = "link";

    protected $list = array();

    public function add2List($title, $link)
    {
        $this->list[$title] = $link;
    }

    public function toArray()
    {
        return $this->list;
    }
}