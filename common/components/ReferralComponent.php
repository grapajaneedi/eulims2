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
//use common\models\lab\Analysisextend;
//use common\models\system\LogSync;
//use common\models\system\ApiSettings;
use linslin\yii2\curl;
use common\models\lab\exRequestreferral;
use common\models\lab\Analysis;
use common\models\lab\Sample;
use yii\helpers\Json;


/**
 * Description of Referral Component
 * Get Data from Referral API for local eULIMS
 * @author OneLab
 */
class ReferralComponent extends Component {

    public $source = 'http://localhost/eulimsapi.onelab.ph';
    /**
     * FindOne testname
     * @param integer $testnameId
     * @return array
     */
    function getTestnameOne($testnameId){
        $apiUrl=$this->source.'/api/web/referral/listdatas/testnameone?testname_id='.$testnameId;
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
        $apiUrl=$this->source.'/api/web/referral/listdatas/methodreferenceone?methodref_id='.$methodrefId;
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);
        return json_decode($list);
    }
    /**
     * FindOne Discount
     * @param integer $discountId
     * @return array
     */
    function getDiscountOne($discountId){
        $apiUrl=$this->source.'/api/web/referral/listdatas/discountbyid?discount_id='.$discountId;
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);
        return json_decode($list);
    }
    //get referral laboratory list
    function listLabreferral()
    {
        $apiUrl=$this->source.'/api/web/referral/listdatas/lab';
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);

        //$data = ArrayHelper::map(json_decode($list), 'lab_id', 'labname');
        
        return $list;
    }
    //get referral discount list
    function listDiscountreferral()
    {
        $apiUrl=$this->source.'/api/web/referral/listdatas/discount';
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);

        //$data = ArrayHelper::map(json_decode($list), 'discount_id', 'type');
        
        return $list;
    }
    //get referral purpose list
    function listPurposereferral()
    {
        $apiUrl=$this->source.'/api/web/referral/listdatas/purpose';
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);

        //$data = ArrayHelper::map(json_decode($list), 'purpose_id', 'name');
        
        return $list;
    }
    //get referral mode of release list
    function listModereleasereferral()
    {
        $apiUrl=$this->source.'/api/web/referral/listdatas/moderelease';
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);

        //$data = ArrayHelper::map(json_decode($list), 'modeofrelease_id', 'mode');
        
        return $list;
    }
    //get matching services
    function listMatchAgency($requestId){

        $request = exRequestreferral::findOne($requestId);

        $sample = Sample::find()
            ->select('sampletype_id')
            ->where('request_id = :requestId', [':requestId' => $requestId])
            ->groupBy('sampletype_id')
            ->asArray()->all();

        $sampletypeId = implode(',', array_map(function ($data) {
            return $data['sampletype_id'];
        }, $sample));

        $analysis = Analysis::find()
            ->joinWith('sample')
            ->where('tbl_sample.request_id = :requestId',[':requestId'=>$requestId])
            ->groupBy(['testname_id','methodref_id'])
            ->asArray()->all();

        $testnameId = implode(',', array_map(function ($data) {
            return $data['test_id'];
        }, $analysis));

        $methodrefId = implode(',', array_map(function ($data) {
            return $data['methodref_id'];
        }, $analysis));

        $apiUrl=$this->source.'/api/web/referral/services/listmatchagency?rstl_id='.$request->rstl_id.'&lab_id='.$request->lab_id.'&sampletype_id='.$sampletypeId.'&testname_id='.$testnameId.'&methodref_id='.$methodrefId;
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);

        if($list == 'false'){
            return null;
        } else {
            $agencyId = implode(',', array_map(function ($data) {
                return $data['agency_id'];
            }, json_decode($list,true)));
            
            $list_agency = $this->listAgency($agencyId);
            return $list_agency;
        }
    }
    //get list agencies
    function listAgency($agencyId)
    {   
        if(!empty($agencyId)){
            $agencies = rtrim($agencyId);

            $apiUrl=$this->source.'/api/web/referral/listdatas/listagency?agency_id='.$agencies;
            $curl = new curl\Curl();
            $list = $curl->get($apiUrl);
            return $list;
        } else {
            return null;
        }
    }
    //check if notified
    function checkNotify($requestId,$agencyId)
    {
        if($requestId > 0 && $agencyId > 0) {
            $apiUrl=$this->source.'/api/web/referral/notifications/checknotify?request_id='.$requestId.'&agency_id='.$agencyId;
            $curl = new curl\Curl();
            $list = $curl->get($apiUrl);
            return $list;
        } else {
            return 'Not valid request!';
        }
    }
    //check if active lab
    function checkActiveLab($labId, $agencyId)
    {
        if($labId > 0 && $agencyId > 0) {
            $apiUrl=$this->source.'/api/web/referral/referrals/checkactivelab?lab_id='.$labId.'&agency_id='.$agencyId;
            $curl = new curl\Curl();
            $list = $curl->get($apiUrl);
            return $list;
        } else {
            return 'Not valid request!';
        }
    }
    //post delete request
    function removeReferral($agencyId,$requestId)
    {
        if($agencyId > 0 && $requestId > 0){
            $apiUrl=$this->source.'/api/web/referral/referrals/deletereferral';
            $curl = new curl\Curl();
            $data = Json::encode(['request_id'=>$requestId,'rstl_id'=>$agencyId],JSON_NUMERIC_CHECK);
            $response = $curl->setRequestBody($data)
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Content-Length' => strlen($data),
            ])->post($apiUrl);

            return $response;
        } else {
            return 0;
        }
    }
    //get count notifications
    function countNofication($rstlId)
    {
        if($rstlId > 0) {
            $apiUrl=$this->source.'/api/web/referral/notifications/countnotification?rstl_id='.$rstlId;
            $curl = new curl\Curl();
            $list = $curl->get($apiUrl);
            return $list;
        } else {
            return 'Not valid rstl!';
        }
    }
}
