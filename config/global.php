<?php
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:08 PM
 */

defined('IN_CMS') or exit('No direct script access allowed');;


$config = array(
    'name' => 'CMS',
    'debug' => true,
    'database' => require 'database.php',
    'plugin' => require 'plugin.php',
    'middleware' => require 'middleware.php',

);