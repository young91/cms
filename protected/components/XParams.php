<?php
/**
 * 静态参数
 * 
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Tools
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */

class XParams{
	static $adminiLoggerType = array('login'=>'登录','create'=>'录入','delete'=>'删除','update'=>'编辑');
	static $attrScope = array('post'=>'内容','config'=>'系统配置','page'=>'单页');
	static $attrItemType = array('input'=>'文本输入','select'=>'下拉选择','checkbox'=>'多选','textarea'=>'大段内容','radio'=>'单选');
	/**
	 * 取参数值
	 */
	static public function get($val, $type){
		switch ($type) {
			case 'adminiLoggerType': return self::$adminiLoggerType[$val]; break;
			default: break;
		}
	}
}
