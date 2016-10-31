<?php

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/26
 * Time: 15:12
 */
class DivTitle
{
    const KEY_IMG = "img";
    const KEY_LEFT_LINK = "left_link";
    const KEY_LEFT_TITLE = "left_title";
    const KEY_RIGHT = "right";

    public $img = "";
    public $left_link = "";
    public $left_title = "";
    public $right = array();

    public function add2right($title, $link)
    {
        $this->right[$title] = $link;
    }

    public function toArray()
    {
        return array(
            DivTitle::KEY_IMG => $this->img,
            DivTitle::KEY_LEFT_LINK => $this->left_link,
            DivTitle::KEY_LEFT_TITLE => $this->left_title,
            DivTitle::KEY_RIGHT => $this->right,
        );
    }
}