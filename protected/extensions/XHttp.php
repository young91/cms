<?php
/**
 * Http工具类
 * 
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Tools
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */
class XHttp{

	/**
	 * 文件下载
	 */
	static function download ($filename, $showname='', $content='',$expire=180){
		Yii::import( 'application.vendors.*' );
        require_once 'Tp/Http.class.php';
        Http::download($filename, $showname, $content,$expire);
	}
}


