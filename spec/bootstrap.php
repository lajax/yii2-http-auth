<?php

define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);
define('YII_ENV', 'test');
$_SERVER['SCRIPT_NAME'] = '/' . __FILE__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;

$vendorPath = __DIR__ . '/../vendor';
require_once $vendorPath . '/autoload.php';
require_once $vendorPath . '/yiisoft/yii2/Yii.php';
