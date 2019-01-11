<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

use Yii;
use yii\base\Component;
use yii\web\JsExpression;
//use yii\helpers\ArrayHelper;
//use common\models\lab\Request;
//use kartik\grid\GridView;
use yii\web\NotFoundHttpException;
//use common\models\system\LogSync;
//use common\models\system\ApiSettings;
use linslin\yii2\curl;


/**
 * Description of Referral Component
 * Get Data from Referral API for local eULIMS
 * @author OneLab
 */
class ReferralComponent extends Component{

    /**
     * FindOne testname
     * @param integer $testnameId
     * @return array
     */
    function getTestnameOne($testnameId){
        $apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/testnameone?testname_id='.$testnameId;
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);
        return json_decode($list);
    }
    /**
     * FindOne Method reference
     * @param integer $methodrefId
     * @return array
     */
    function getMethodrefOne($methodrefId){
        $apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/methodreferenceone?methodref_id='.$methodrefId;
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);
        return json_decode($list);
    }

    function getMethodTotal($testnameId){
        if($testnameId > 0){
            $apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/testnamemethodref?testname_id='.$testnameId;
            $curl = new curl\Curl();
            $data = $curl->get($apiUrl);
        } else {
            $data = [];
        }
        return count($data);
    }
}
