<?php
/**
 * 标签控制器
 *
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Controller
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */
class TagController extends XFrontBase
{
  /**
   * 标签首页
   */
  public function actionIndex(){
    $postTagsModel = new PostTags();
    $postTagsCriteria = new CDbCriteria();
    $condition = '1';
    $postTagsCriteria->condition = $condition;
    $postTagsCriteria->order = 't.id DESC';
    $count = $postTagsModel->count($postTagsCriteria);
    $post2TagsPages = new CPagination($count);
    $post2TagsPages->pageSize = 300;
    $pageParams = XUtils::buildCondition($_GET, array ());
    $post2TagsPages->params = is_array($pageParams) ? $pageParams : array ();
    $postTagsCriteria->limit = $post2TagsPages->pageSize;
    $postTagsCriteria->offset = $post2TagsPages->currentPage * $post2TagsPages->pageSize;
    $data['young91DataList'] = $postTagsModel->findAll($postTagsCriteria);
    $data['young91Pagebar'] = $post2TagsPages;
    $this->render('index', $data);
  }

  /**
   * tags数据列表
   */
  public function actionPost($name){
     
    $tagName = CHtml::encode(strip_tags(urldecode($name)));

    $tagModel = new Post2tags();
    $post2TagsCriteria = new CDbCriteria();
    if ($tagName) {
        $post2TagsCriteria->addCondition("tag_name = :tagName");
        $post2TagsCriteria->params[':tagName'] = $tagName;
    }
    $post2TagsCriteria->order = 't.id DESC';
    $post2TagsCriteria->with = array ('post' );
    $post2TagsCount = $tagModel->count($post2TagsCriteria);
    $post2TagsPages = new CPagination($post2TagsCount);
    $post2TagsPages->pageSize = 30;
    $pageParams = XUtils::buildCondition($_GET, array ('name' ));
    $post2TagsPages->params = is_array($pageParams) ? $pageParams : array ();
    $post2TagsCriteria->limit = $post2TagsPages->pageSize;
    $post2TagsCriteria->offset = $post2TagsPages->currentPage * $post2TagsPages->pageSize;
    $data['young91DataList'] = $tagModel->findAll($post2TagsCriteria);
    $data['young91Pagebar'] = $post2TagsPages;
    $data['tagName'] = $tagName;
    $this->_seoTitle = 'Tag-'.$tagName;
    $this->render('post2tags', $data);
  }
}
