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

        parse_str($_SERVER['QUERY_STRING'], $parr);
        $this->parameters = $parr;

        $this->method = $_SERVER['REQUEST_METHOD'];

        // Only on set
        if (isset($_POST)) {
            $this->post = $_POST;
        }

    }

    public function uri()
    {
//        REQUEST_URI
//        REDIRECT_URL
//        return trim($_SERVER['REDIRECT_URL'], '/');
        return $this->uri;
    }

    // set uri, for testing
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