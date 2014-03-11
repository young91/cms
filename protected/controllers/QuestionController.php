<?php
/**
 * 问答
 *
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Controller
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0
 */

class QuestionController extends XFrontBase
{
    /**
     * 首页
     */
    public function actionIndex() {

        $young91QuestionModel = new Question();
        $young91QuestionCriteria = new CDbCriteria();
        $young91QuestionCriteria->condition = 'status_is=:status';
        $young91QuestionCriteria->params = array( 'status'=>'Y' );
        $young91QuestionCriteria->order = 't.id DESC';
        $young91QuestionCount = $young91QuestionModel->count( $young91QuestionCriteria );
        $young91QuestionPages = new CPagination( $young91QuestionCount );
        $young91QuestionPages->pageSize = 10;
        $young91QuestionPageParams = XUtils::buildCondition( $_GET, array () );
        $young91QuestionPageParams['#'] = 'list';
        $young91QuestionPages->params = is_array( $young91QuestionPageParams ) ? $young91QuestionPageParams : array ();
        $young91QuestionCriteria->limit = $young91QuestionPages->pageSize;
        $young91QuestionCriteria->offset = $young91QuestionPages->currentPage * $young91QuestionPages->pageSize;
        $young91QuestionList = $young91QuestionModel->findAll( $young91QuestionCriteria );
        $this->_seoTitle = '留言咨询 - '.$this->_conf['site_name'];
        $this->render( 'index', array( 'young91QuestionList'=>$young91QuestionList, 'pages'=>$young91QuestionPages ) );
    }

    /**
     * 提交留言
     */
    public function actionPost() {
        if ( $_POST['Question'] ) {
            try {
                $questionModel = new Question();
                $questionModel->attributes = $_POST['Question'];
                if ( $questionModel->save() ) {
                    $var['state'] = 'success';
                    $var['message'] = '提交成功';
                }else {
                    throw new Exception( CHtml::errorSummary( $questionModel, null, null, array ( 'firstError' => '' ) ) );
                }
            } catch ( Exception $e ) {
                $var['state'] = 'error';
                $var['message'] = $e->getMessage();
            }
        }
        exit( CJSON::encode( $var ) );
    }
}
