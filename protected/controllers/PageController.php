<?php
/**
 * 单页控制器
 *
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Controller
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */
class PageController extends XFrontBase
{
  /**
  * 浏览
  */
  public function actionShow( $name ) {
    $young91PageModel = Page::model()->find('title_alias=:titleAlias', array('titleAlias'=>CHtml::encode(strip_tags($name))));
    if ( false == $young91PageModel )
      throw new CHttpException( 404, '内容不存在' );
    $this->_seoTitle = empty( $young91PageModel->seo_title ) ? $young91PageModel->title .' - '. $this->_conf['site_name'] : $young91PageModel->seo_title;
    $tpl = empty($young91PageModel->tpl) ? 'show': $young91PageModel->tpl ;
    $this->render( 'show', array( 'young91Page'=>$young91PageModel ) );
  }

}
