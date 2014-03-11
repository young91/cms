<?php
/**
 * 内容控制器
 *
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Controller
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */
class PostController extends XFrontBase
{
  /**
   * 首页
   */
  public function actionIndex() {
    $catalog = trim( $this->_gets->getParam( 'catalog' ) );
    $keyword = trim( $this->_gets->getParam( 'keyword' ) );
    $catalogArr = Catalog::alias2idArr( $catalog, $this->_catalog );
    if ( $catalog && $catalogArr ) {
      if ( $catalogArr['display_type'] == 'list' ) {
        $tpl = $catalogArr['template_list'] ?  $catalogArr['template_list'] : 'list_text';
        $resultArr = self::_catalogList( array( 'catalog'=>$catalogArr['id'], 'pageSize'=>$catalogArr['page_size']  ));
      }else {
        $resultArr = self::_catalogItem( array( 'catalog'=>$catalogArr['id'] ) );
        $tpl = empty( $resultArr['young91CatalogShow']->template_page ) ? 'list_page': $resultArr['young91CatalogShow']->template_page ;
      }
    }else {
      $resultArr = self::_catalogList( array( 'keyword'=>$keyword ) );
      $tpl = 'list_text';
    }
    $tplVars = array(
        'catalogArr'=>$catalogArr,
        'catalogChild'=>Catalog::lite(intval($catalogArr['id'])),
    );
    $this->render( $tpl , array_merge($resultArr, $tplVars) );
  }

  /**
   * 获取栏目内容数据
   *
   * @param array   $params
   * @return array  数组
   */
  protected function _catalogList( $params = array() ) {

    $postModel = new Post();
    $postCriteria = new CDbCriteria();
    $condition = '1';
    if ( $params['catalog'] ) {
      $condition .= ' AND t.catalog_id=:catalogId';
      $criteriaParams[':catalogId'] = intval($params['catalog']);
    }
    if ( $params['keyword'] ) {
      $condition .= ' AND t.title=:title';
      $criteriaParams[':title'] = CHtml::encode(strip_tags($params['keyword']));
    }
    $postCriteria->condition = $condition;
    $postCriteria->params = $criteriaParams;
    $postCriteria->order = 't.id DESC';
    $postCriteria->with = 'catalog';
    $count = $postModel->count( $postCriteria );
    $postPages = new CPagination( $count );
    $postPages->pageSize = $params['pageSize'] > 0 ? $params['pageSize'] : 20 ;
    $pageParams = XUtils::buildCondition( $_GET, array ( 'catalog', 'keyword'  ) );
    $postPages->params = is_array( $pageParams ) ? $pageParams : array ();
    $postCriteria->limit = $postPages->pageSize;
    $postCriteria->offset = $postPages->currentPage * $postPages->pageSize;
    $young91DataList = $postModel->findAll( $postCriteria );
    $catalogArr = Catalog::item($params['catalog'], $this->_catalog);
    if($catalogArr){
      $this->_seoTitle = empty($catalogArr['catalog_name'])? $this->_seoTitle : $catalogArr['catalog_name'];
      $young91CatalogData = $catalogArr;
      $this->_seoKeywords = empty($catalogArr['seo_keywords'])? $this->_seoKeywords : $catalogArr['seo_keywords'];
      $this->_seoDescription = empty($catalogArr['seo_description'])? $this->_seoDescription : $catalogArr['seo_description'];
    }
    return array( 'young91DataList'=>$young91DataList, 'young91Pagebar'=>$postPages, 'young91CatalogData'=>$young91CatalogData );
  }

  /**
   * 栏目数据读取
   *
   * @param array
   * @return [type]
   */
  protected function _catalogItem( $params = array() ) {
    $catalogModel = Catalog::model()->findByPk( intval($params['catalog']) );
    if ( $catalogModel ){
      $this->_seoTitle = empty($catalogModel->seo_title)? $catalogModel->catalog_name : $catalogModel->seo_title;
      $this->_seoKeywords = $catalogModel->seo_keywords;
      $this->_seoDescription = $catalogModel->seo_description;
      return array( 'young91CatalogShow'=>$catalogModel);
    }else{
      throw new CHttpException( 404, '内容不存在' );
    }
  }

  /**
   * 浏览详细内容
   */
  public function actionShow( $id ) {
    $young91Show = Post::model()->findByPk( intval( $id ) );
    if ( false == $young91Show )
        throw new CHttpException( 404, '内容不存在' );
    //更新浏览次数
    $young91Show->updateCounters(array ('view_count' => 1 ), 'id=:id', array ('id' => $id ));
    //seo信息
    $this->_seoTitle = empty( $young91Show->seo_title ) ? $young91Show->title  .' - '. $this->_conf['site_name'] : $young91Show->seo_title;
    $this->_seoKeywords = empty( $young91Show->seo_keywords ) ? $this->_seoKeywords  : $young91Show->seo_keywords;
    $this->_seoDescription = empty( $young91Show->seo_description ) ? $this->_seoDescription: $young91Show->seo_description;
    $catalogArr = Catalog::item($young91Show->catalog_id, $this->_catalog);

    if($young91Show->template){
      $tpl = $young91Show->template;
    }elseif($catalogArr['template_show']){
       $tpl = $catalogArr['template_show'];
    }else{
        $tpl = 'show_post';
    }
    //自定义数据
    $attrVal = AttrVal::model()->findAll(array('condition'=>'post_id=:postId','with'=>'attr', 'params'=>array('postId'=>$young91Show->id)));

    $tplVar = array(
        'young91Show'=>$young91Show,
        'attrVal'=>$attrVal,
        'catalogArr'=>$catalogArr,
        'catalogChild'=>Catalog::lite(intval( $young91Show->catalog_id)),
    );
    $this->render( $tpl, $tplVar);
  }

  /**
   * 提交评论
   *
   * @return [type] [description]
   */
  public function actionPostComment() {

    $nickname = trim( $this->_gets->getParam( 'nickname' ) );
    $email = trim( $this->_gets->getParam( 'email' ) );
    $postId = trim( $this->_gets->getParam( 'postId' ) );
    $comment = trim( $this->_gets->getParam( 'comment' ) );
    try {
      if ( empty( $postId ) )
        throw new Exception( '编号丢失' );
      elseif ( empty( $nickname ) || empty( $email ) ||  empty( $comment ) )
        throw new Exception( '昵称、邮箱、内容必须填写' );
      $young91PostCommentModel = new PostComment();

      $young91PostCommentModel ->attributes = array(
          'post_id'=> $postId,
          'nickname'=> $nickname,
          'email'=> $email,
          'content'=> $comment,
      );

      if ( $young91PostCommentModel->save() ) {
        $var['state'] = 'success';
        $var['message'] = '提交成功';
      }else {
        throw new Exception( CHtml::errorSummary( $young91PostCommentModel, null, null, array ( 'firstError' => '' ) ) );
      }
      
    } catch ( Exception $e ) {
      $var['state'] = 'error';
      $var['message'] = '出现错误：'.$e->getMessage();
    }
    exit( CJSON::encode( $var ) );
  }
}
