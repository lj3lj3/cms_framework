<?php
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:05 PM
 */

//namespace Core;

require dirname(dirname(__FILE__)). '/config/global.php';
require_once dirname(dirname(__FILE__)) . '/vendor/smarty/libs/Smarty.class.php';

// load plugins
foreach ($GLOBALS['config']['plugin'] as $plugin => $value) {
    if ($plugin == 'smarty' && $value == true) {
        $smarty = new Smarty();
        //var_dump( $smarty);

        $smarty->setTemplateDir(dirname(dirname(__FILE__)) . '/resource/views/templates/');
        $smarty->setCompileDir(dirname(dirname(__FILE__)) . '/resource/views/templates_c/');
        $smarty->setConfigDir(dirname(dirname(__FILE__)) . '/resource/views/configs/');
        $smarty->setCacheDir(dirname(dirname(__FILE__)) . '/resource/views/cache/');

        //$smarty->testInstall();
    }
}

