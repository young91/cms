<?php
/**
 * 入口
 *
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */

error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('DS', DIRECTORY_SEPARATOR);
define('WWWPATH', str_replace(array('\\', '\\\\'), '/', dirname(__FILE__)));
$framework = dirname(__FILE__) . DS. 'framework'.DS.'yiilite.php';
$config = WWWPATH . DS .'protected'.DS.'config'.DS.'main.php';
require_once ($framework);
Yii::createWebApplication($config)->run();