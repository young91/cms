<?php
/**
 * 错误信息显示
 * 
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Controller
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */

class ErrorController extends Controller
{
    public $layout = false;
    /**
     * 错误信息显示页
     */
    public function actionIndex ()
    {
        if ($error = Yii::app()->errorHandler->error) {
            switch ($error['code']) {
                case 404: $tpl = 'error404'; break;
                case 500: $tpl = 'error500'; break; 
                default: $tpl = 'error'; break;
            }
            $error['redirect'] = Yii::app()->request->urlReferrer ? Yii::app()->request->urlReferrer: Yii::app()->homeUrl;
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render($tpl, $error);
        }
    }
}