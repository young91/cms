<?php
/**
 * 专题控制器
 *
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Controller
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */
class SpecialController extends XFrontBase
{
  /**
   * 专题首页
   */
  public function actionIndex(){
    $specialModel = new Special();
    $specialCriteria = new CDbCriteria();
    $specialCriteria->addCondition ( 't.status_is=:status');
    $specialCriteria->params[':status'] = 'Y';
    $specialCriteria->order = 't.id DESC';
    $young91SpecialCount = $specialModel->count( $specialCriteria );
    $specialPages = new CPagination( $young91SpecialCount );
    $specialPages->pageSize = 15;
    $specialPageParams = XUtils::buildCondition( $_GET, array (  ) );
    $specialPageParams['#'] = 'list';
    $specialPages->params = is_array( $specialPageParams ) ? $specialPageParams : array ();
    $specialCriteria->limit = $specialPages->pageSize;
    $specialCriteria->offset = $specialPages->currentPage * $specialPages->pageSize;
    $specialList = $specialModel->findAll( $specialCriteria );
    $this->_seoTitle = '专题 - '.$this->_conf['site_name'];
    $this->render( 'index', array( 'young91DataList'=>$specialList, 'young91Pagebar'=>$specialPages ) );
  }

  /**
   * 查看专题
   */
  public function actionShow($name){
    $specialModel = Special::model()->find('title_alias=:titleAlias', array('titleAlias'=>CHtml::encode(strip_tags($name))));
    if ( false == $specialModel )
      throw new CHttpException( 404, '专题不存在' );
    //更新浏览次数
    $specialModel->updateCounters(array ('view_count' => 1 ), 'id=:id', array ('id' => $specialModel->id ));
    $specialPostModel = new Post();
    $criteria = new CDbCriteria();
    $criteria->addCondition ( 't.status_is=:status AND special_id=:specialId');
    $criteria->params = array('status'=>'Y', 'specialId'=>$specialModel->id);
    $criteria->order = 't.id DESC';
    $young91SpecialCount = $specialPostModel->count( $criteria );
    $postPage = new CPagination( $young91SpecialCount );
    $postPage->pageSize = 10;
    $postPageParams = XUtils::buildCondition( $_GET, array ( ) );
    $postPageParams['#'] = 'list';
    $postPage->params = is_array( $postPageParams ) ? $postPageParams : array ();
    $criteria->limit = $postPage->pageSize;
    $criteria->offset = $postPage->currentPage * $postPage->pageSize;
    $specialPostList = $specialPostModel->findAll( $criteria );
    $this->_seoTitle = empty( $specialModel->seo_title ) ? $specialModel->title .' - '. $this->_conf['site_name'] : $specialModel->seo_title;
    $tpl = empty($specialModel->tpl) ? 'show': $specialModel->tpl ;

    $data = array(
        'specialShow'=>$specialModel,
        'specialPostList'=>$specialPostList,
        'young91Pagebar'=>$postPage,
     );
    $this->render($tpl, $data);
  }
}
