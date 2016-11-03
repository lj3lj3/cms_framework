<?php
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:56 PM
 */

//namespace Core;

class Request
{
    protected $uri;
    // array of uri
    protected $uriPieces;
    protected $parameters;
    protected $method;
    protected $post;

    /*public static function newInstance()
    {
        return new self();
    }*/

    public function __construct()
    {
        $this->uri = trim($_SERVER['REDIRECT_URL'], '/');
        $this->uriPieces = explode('/', $this->uri);

        parse_str($_SERVER['QUERY_STRING'], $parr);
        $this->parameters = $parr;

        $this->method = $_SERVER['REQUEST_METHOD'];

        // Only on set
        if (isset($_POST)) {
            $this->post = $_POST;
            // 包含POST数据
            $this->parameters = array_merge($this->parameters, $this->post);
        }

    }

    public function uri()
    {
//        REQUEST_URI
//        REDIRECT_URL
//        return trim($_SERVER['REDIRECT_URL'], '/');
        return $this->uri;
    }

    public function uriPieces()
    {
        return $this->uriPieces;
    }

    public function firstUriPiece()
    {
        return $this->uriPieces[0];
    }

    /**
     * set uri, for testing
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function parameters()
    {
        // Only on set
//        if (isset($_SERVER['QUERY_STRING'])){
//            parse_str($_SERVER['QUERY_STRING'], $parr);
//            return $parr;
        return $this->parameters;
//        }

//        return array();
    }

    /**
     * @param $name string 获取的参数的名称
     * @param null $default 参数不存在时返回的默认值
     * @return null
     */
    public function getParam($name, $default = NULL)
    {
        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        }

        return $default;
    }

    public function method()
    {
//        return $_SERVER['REQUEST_METHOD'];
        return $this->method;
    }

    public function POST()
    {
        // Only on set
        if (isset($this->post)) {
            return $this->post;
        }

        return array();
    }
}