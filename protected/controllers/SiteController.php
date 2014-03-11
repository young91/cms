<?php
/**
 * 首页控制器
 * 
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Controller
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */

class SiteController extends XFrontBase
{
    /**
     * 首页
     */
    public function actionIndex ()
    {
      $this->render('index',array('model'=>$model));
    }

}