<?php
/**
 * 搜索
 *
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Controller
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */

class SearchController extends XFrontBase
{
    /**
     * 首页
     */
    public function actionIndex() {
        $keyword = CHtml::encode(strip_tags(trim($this->_gets->getParam('keyword'))));
        $postModel = new Post();
        $postCriteria = new CDbCriteria();
        if($keyword)
            $postCriteria->addSearchCondition('t.title', $keyword);
        $postCriteria->addCondition ( 't.status_is=:status');
        $postCriteria->params[':status'] = 'Y';
        $postCriteria->with = 'catalog';
        $postCriteria->order = 't.id DESC';
        $young91QuestionCount = $postModel->count( $postCriteria );
        $postPages = new CPagination( $young91QuestionCount );
        $postPages->pageSize = 15;
        $postPageParams = XUtils::buildCondition( $_GET, array ( 'keyword'    ) );
        $postPageParams['#'] = 'list';
        $postPages->params = is_array( $postPageParams ) ? $postPageParams : array ();
        $postCriteria->limit = $postPages->pageSize;
        $postCriteria->offset = $postPages->currentPage * $postPages->pageSize;
        $postList = $postModel->findAll( $postCriteria );
        $this->render( 'index', array( 'young91DataList'=>$postList, 'young91Pagebar'=>$postPages ) );
    }
}
