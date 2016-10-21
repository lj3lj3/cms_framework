<?php
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:05 PM
 */

//namespace Core;

require_once dirname(dirname(__FILE__)) . '/config/global.php';
require_once dirname(__FILE__) . '/Log/Log.php';
require_once 'Exception.php';
require_once dirname(dirname(__FILE__)) . '/vendor/smarty/libs/Smarty.class.php';
// Log启动
Log::boot(new FileLogHandler());

// For now
define('ERROR_REPORT', 3);

// Set error reporting
if(ERROR_REPORT==1) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
} elseif(ERROR_REPORT==0) {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
}
set_error_handler('error_handler');
set_exception_handler('exception_handler');


// Load plugins
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

