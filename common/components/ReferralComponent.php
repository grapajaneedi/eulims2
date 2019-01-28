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

        /*$sample = Sample::find()
                    ->select('sampletype_id')
                    //->joinWith('labSampletypes')
                    //->where(['tbl_labsampletype.lab_id' => $labId])
                    ->where('request_id = :requestId', [':requestId' => $requestId])
                    ->groupBy('sampletype_id')
                    ->asArray()->all();*/

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

        print_r($request->lab_id);
        echo "sampletypeId";
        print_r($sampletypeId);
        echo "testnameId";
        print_r($testnameId);
        echo "methodrefId";
        print_r($methodrefId);

        exit;

        $apiUrl=$this->source.'/api/web/referral/services/listmatchagency?lab_id='.$request->lab_id.'&sampletype_id='.$sampletypeId.'&testname_id='.$testnameId.'&methodref_id='.$methodrefId;
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);

        return $list;
    }

    function alistMatchAgency($referralId)
    {   
        
        $query = "SELECT * 
            FROM lab_sampletype
            INNER JOIN sampletype_testname
            ON lab_sampletype.`sampletypeId` = sampletype_testname.`sampletype_id`
            INNER JOIN testname_method
            ON sampletype_testname.`testname_id` = testname_method.`testname_id`
            INNER JOIN service
            ON testname_method.`method_id` = service.`method_ref_id`
            
            WHERE lab_sampletype.`lab_id` = 1 AND sampletype_testname.`sampletype_id` = 1
            AND testname_method.`testname_id` = 1 AND service.`method_ref_id` IN (165)";

        //$sql = 'SELECT * FROM customer WHERE status=:status';
        //$customers = Customer::findBySql($sql, [':status' => Customer::STATUS_INACTIVE])->all();






        exit;
       /* $data = (new \yii\db\Query())
                    ->select('CEIL(COUNT(*)/'.$perpage.') AS count_page')
                    ->from('eulims_referral_lab.tbl_methodreference')
                    ->join('INNER JOIN', 'eulims_referral_lab.tbl_testname_method', 'tbl_methodreference.methodreference_id = tbl_testname_method.methodreference_id')
                    //->where()
                    ->where(['testname_id'=>$testnameId])
                    ->andWhere(['<=','tbl_methodreference.methodreference_id',$methodrefId])
                    //->groupBy('tbl_testname.testname_id')
                    ->orderBy('tbl_methodreference.methodreference_id')
                    ->one();


        $crit = new CDbCriteria;
        $crit->select = array('*');
        $crit->with = 'sample';
        $crit->condition = 't.package != :package AND sample.referral_id = :referralId';
        $crit->params = array(':package'=>2,':referralId' => $referralId);
        
        $crit1 = new CDbCriteria;
       //$crit1->select = 'analyses.package_id';
        $crit1->with = 'analyses';
        $crit1->condition = 'analyses.package = :package AND analyses.package_id !=:packageId AND t.referral_id = :referralId';
        $crit1->params = array(':package'=>2,':packageId'=>0,':referralId' => $referralId);
    
        $analyses = Analysis::model()->findAll($crit);
        $packages1 = Sample::model()->findAll($crit1);
    
        $count = 0;
        $count1 = 0;
        $count2 = 0;
        $method_ref_ids = array();
        $package_ids = array();
        $package_ids1 = array();
        $agency_ids = array();

        foreach($analyses as $analysis)
        {
            if(!in_array($analysis->methodReference_id, $method_ref_ids))
            {
                array_push($method_ref_ids, $analysis->methodReference_id);
                $count += 1;
            }
            if(!in_array($analysis->package_id, $package_ids))
            {
                if($analysis->package_id > 0 )
                {
                    array_push($package_ids, $analysis->package_id);
                    $count1++;
                }
            }
        }
        
        $criteria = new CDbCriteria;
        //$criteria->select = array('*, COUNT(method_ref_id) AS methodMatches');
        $criteria->select = array('*, COUNT(method_ref_id) AS methodMatches');
        //$criteria->with = 'agency';
        $criteria->group = 'agency_id';
        $criteria->having = 'methodMatches = :methodMatches';
        $criteria->params = array(':methodMatches' => $count);
        $criteria->addInCondition('method_ref_id', $method_ref_ids);
    
        $agencies = Service::model()->with('agency')->findAll($criteria);
        $forPackage = Service::model()->findAll($criteria);
        
        $arrayAgencies = CJSON::decode(CJSON::encode($forPackage));
        
        if(count($arrayAgencies) > 0)
        {
            foreach($arrayAgencies as $agency)
            {
                array_push($agency_ids, $agency['agency_id']);
            }
            $analysis_agency_ids = implode(',',$agency_ids);
            $analysis_package_ids = implode (',', $package_ids);
            if(count($package_ids) > 0 && count($analysis_package_ids) && count($analysis_agency_ids)){
                $packageOffered = Yii::app()->db->createCommand(
                "SELECT * 
                    FROM package_offer
                    WHERE (agency_id IN (".$analysis_agency_ids.")) AND (package_id IN (".$analysis_package_ids."))"
                )->queryAll();
            }
        }
        
        if(count($package_ids) > 0 && count($packageOffered) == 0){
            return null;
        } else  {
            // if(count($checkAgencylabs) > 0 && count($labStatus) > 0)
                // return null;
            // else
                return $agencies;
        }*/
    }
}
