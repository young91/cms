<?php
/**
 * young91 DataList Widget
 * 
 * @author        young91
 * @copyright     Copyright (c) 2014 young91. All rights reserved.
 * @link          http://www.ecoutpost.com
 * @package       young91.Widget
 * @license       http://www.ecoutpost.com/license
 * @version       v1.0.0
 */

class DataList extends CWidget
{
    public $model;
    public $id;
    public $params;
    public $datalist;

    public function init() {
        if ( isset( $this->params['cache'] ) ) {
            $cacheData = Yii::app()->cache->get( $this->id );
            if ( $cacheData === false ) {
                $this->datalist = self::_datalist();
            } else {
                $this->datalist =  $cacheData;
            }
        } else {
            $this->datalist =  self::_datalist();
        }
    }

    public function run() {

        $tpl = isset($this->params['tpl'])? $this->params['tpl'] : 'young91';
        $this->render( $tpl , array(
            'datalist'=>$this->datalist,
        ));
    }

    /**
     * 获取数据列表
     *
     * @return [array] [数组]
     */
    protected function _datalist() {

        $model = ucfirst( $this->model );
        $young91Model = new $model();
        $this->params['limit'] && $array['limit'] = $this->params['limit'];
        $this->params['where'] && $array['condition'] = $this->params['where'];
        $this->params['order'] && $array['order'] = $this->params['order'];
        $this->params['select'] && $array['select'] = $this->params['select'];
        $this->params['offset'] && $array['offset'] = $this->params['offset'];
        $this->params['with'] && $array['with'] = $this->params['with'];
        $this->params['alias'] && $array['alias'] = $this->params['alias'];
        $this->params['params'] && $array['params'] = $this->params['params'];
        $this->params['joinType'] && $array['joinType'] = $this->params['joinType'];
        $this->params['group'] && $array['group'] = $this->params['group'];

        try {
            if ( $this->params['sql'] )
                $dataGet = Yii::app()->db->createCommand( $this->params['sql'] )->queryAll();
            else
                $dataGet = $young91Model->findAll( $array );
            foreach ( (array) $dataGet as $key => $row ) {
                foreach ( (array) self::_attributes( $this->params['select'], $young91Model ) as $attr ) {
                    $datalist[$key][$attr] = $row->$attr;
                }
            }
            if ( $this->params['cache'] ) {
                $cacheTime = empty( $this->params['cacheTime'] ) ? 3600 : $this->params['cacheTime'];
                Yii::app()->cache->set( $this->id, $datalist, $cacheTime );
            }

            return (array) $datalist;
        } catch ( Exception $error ) {
            echo '部件 '.__CLASS__.' 调用错误 -->  表名称： '. $model . '&nbsp;&nbsp;标识：' . $this->id  ;
        }
    }

    /**
     * 取字段
     *
     * @param $model
     */
    protected function _attributes( $fields = '', $model = '' ) {
        if ( empty( $fields ) || trim( $fields ) == '*' ) {
            return $model->attributeNames();
        } else {
            $fields = str_replace( '，', ',', $fields );
            return explode( ',', $fields );
        }
    }
}
