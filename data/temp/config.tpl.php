<?php
/**
 * 系统配置
 * 
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'young91',
    'language'=>'zh_cn',
    'theme'=>'default',
    'timeZone'=>'Asia/Shanghai',
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
	),
    'modules'=>array(
		'admini'=>array(
		     'class'=>'application.modules.admini.AdminiModule',
		),
		'account'=>array(
		     'class'=>'application.modules.account.AccountModule',
		)
	),
	'components'=>array(
        'cache'=>array(
           'class'=>'CFileCache',
        ),
		'db'=>array(
			'connectionString' => 'mysql:host=~dbHost~;dbname=~dbName~',
			'emulatePrepare' => true,
			'enableParamLogging' => true,
			'enableProfiling'=>true,
			'username' => '~dbUsername~',
			'password' => '~dbPassword~',
			'charset' => 'utf8',
			'tablePrefix' => '~dbPre~',
		),
		'errorHandler'=>array(
            'errorAction'=>'error/index',
        ), 
        'urlManager'=>array(
        	//'urlFormat'=>'path',
        	//'urlSuffix'=>'.html',
        	'showScriptName'=>true,
        	'rules'=>array(
        		'post/<id:\d+>/*'=>'post/show',
        		'post/<id:\d+>_<title:\w+>/*'=>'post/show',
        		'post/catalog/<catalog:[\w-_]+>/*'=>'post/index',
        		'page/show/<name:\w+>/*'=>'page/show',
        		'special/show/<name:[\w-_]+>/*'=>'special/show',
        		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        	),
        ),
	),
	'params'=> require(dirname(__FILE__).DS.'params.php'),
);