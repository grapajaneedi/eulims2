<?php

namespace frontend\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\system\Profile;
use kartik\mpdf\Pdf;
use yii\helpers\Json;
use common\models\lab\CustomerMigration;
use common\models\lab\RequestMigration;
use common\models\lab\SampleMigration;
use common\models\lab\AnalysisMigration;

class ApiController extends ActiveController
{
    public $modelClass = 'common\models\system\Profile';
    
    public function verbs() {
        parent::verbs();
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }
    public function actions() {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = function($action) {
            return new \yii\data\ActiveDataProvider([
                'query' => Profile::find()->where(['user_id' => Yii::$app->user->id]),
            ]);
        };

        return $actions;
    }

    public function actionSync_customer(){ 
        $post = Yii::$app->request->post();
        $ctr = 0;
        if(isset($post)){
            $myvar = Json::decode($post['data']);
            foreach ($myvar as $var) {

                $newCustomer = new CustomerMigration();
                $newCustomer->rstl_id=$var['rstl_id'];
                $newCustomer->customer_name=$var['customerName'];
                $newCustomer->classification_id=$var['classification_id'];
                $newCustomer->latitude=$var['latitude'];
                $newCustomer->longitude=$var['longitude'];
                $newCustomer->head=$var['head'];
                $newCustomer->barangay_id=$var['barangay_id'];
                $newCustomer->address=$var['address'];
                $newCustomer->tel=$var['tel'];
                $newCustomer->fax=$var['fax'];
                $newCustomer->email=$var['email'];
                $newCustomer->customer_type_id=$var['typeId'];
                $newCustomer->business_nature_id=$var['natureId'];
                $newCustomer->industrytype_id=$var['industryId'];
                $newCustomer->created_at=strtotime($var['created']);
                $newCustomer->customer_old_id=$var['id'];
                $newCustomer->Oldcolumn_municipalitycity_id=$var['municipalitycity_id'];
                $newCustomer->Oldcolumn_district=$var['district'];
                if($newCustomer->save()){
                    $ctr++;
                }
            }
           
        }
         echo $ctr;   
    }

    public function actionSync_request(){ 

        $post = Yii::$app->request->post();
        $ctr = 0;
        if(isset($post)){
            $myvar = Json::decode($post['data']);
            // var_dump($myvar); exit();
            foreach ($myvar as $var) {

                $newRequest = new RequestMigration();
                $newRequest->request_ref_num=$var['request_ref_num'];
                $newRequest->request_datetime=$var['request_datetime'];
                $newRequest->rstl_id=$var['rstl_id'];
                $newRequest->lab_id=$var['lab_id'];
                $newRequest->customer_id=$var['customer_id'];
                $newRequest->payment_type_id=$var['payment_type_id'];
                $newRequest->modeofrelease_ids=$var['modeofrelease_ids'];
                $newRequest->discount=$var['discount'];
                $newRequest->purpose_id=$var['purpose_id'];
                $newRequest->conforme=$var['conforme'];
                $newRequest->report_due=$var['report_due'];
                $newRequest->total=$var['total'];
                $newRequest->receivedBy =$var['receivedBy'];
                $newRequest->oldColumn_requestId=$var['oldColumn_requestId'];
                $newRequest->oldColumn_sublabId=$var['oldColumn_sublabId'];
                $newRequest->oldColumn_orId=$var['oldColumn_orId'];
                $newRequest->oldColumn_completed=$var['oldColumn_completed'];
                $newRequest->oldColumn_cancelled=$var['oldColumn_cancelled'];
                $newRequest->oldColumn_create_time=$var['oldColumn_create_time'];
                $newRequest->request_old_id=$var['request_old_id'];
                $newRequest->created_at=0;
                $newRequest->discount_id=0;
                if($newRequest->save()){
                    $ctr++;
                }
            }
        }
        echo $ctr;
    }


    public function actionSync_sample(){ 

        $post = Yii::$app->request->post();
        $ctr = 0;
        if(isset($post)){
            $myvar = Json::decode($post['data']);
            // var_dump($myvar); exit();
            foreach ($myvar as $var) {
                $newSample = new SampleMigration();
                $newSample->rstl_id=$var['rstl_id'];
                $newSample->pstcsample_id=$var['pstcsample_id'];
                $newSample->sample_type_id=$var['sample_type_id'];
                $newSample->sample_code=$var['sample_code'];
                $newSample->samplename=$var['samplename'];
                $newSample->description=$var['description'];
                $newSample->sampling_date=$var['sampling_date'];
                $newSample->remarks=$var['remarks'];
                $newSample->request_id=$var['request_id'];
                $newSample->sample_month=$var['sample_month'];
                $newSample->sample_year=$var['sample_year'];
                $newSample->active=$var['active'];
                $newSample->sample_old_id=$var['sample_old_id'];
                $newSample->oldColumn_requestId=$var['oldColumn_requestId'];
                $newSample->oldColumn_completed=$var['oldColumn_completed'];
                $newSample->oldColumn_datedisposal=$var['oldColumn_datedisposal'];
                $newSample->oldColumn_mannerofdisposal=$var['oldColumn_mannerofdisposal'];
                $newSample->oldColumn_batch_num=$var['oldColumn_batch_num'];
                $newSample->oldColumn_package_count=$var['oldColumn_package_count'];
                $newSample->testcategory_id=0;
                if($newSample->save()){
                    $ctr++;
                }
            }
        }
       echo $ctr;

    }


    public function actionSync_analysis(){ 
        $post = Yii::$app->request->post();
        $ctr = 0;
        if(isset($post)){
            $myvar = Json::decode($post['data']);
            // var_dump($myvar); exit();
            foreach ($myvar as $var) {
                $newanalysis = new AnalysisMigration();
                $newanalysis->rstl_id=$var['rstl_id'];
                $newanalysis->pstcanalysis_id=$var['pstcanalysis_id'];
                $newanalysis->sample_id=$var['sample_id'];
                $newanalysis->sample_code=$var['sample_code'];
                $newanalysis->testname=$var['testname'];
                $newanalysis->method=$var['method'];
                $newanalysis->references=$var['references'];
                $newanalysis->quantity=$var['quantity'];
                $newanalysis->fee=$var['fee'];
                $newanalysis->test_id=$var['test_id'];
                $newanalysis->cancelled=$var['cancelled'];
                $newanalysis->date_analysis=$var['date_analysis'];
                $newanalysis->user_id=$var['user_id'];
                $newanalysis->is_package=$var['is_package'];
                $newanalysis->oldColumn_deleted=$var['oldColumn_deleted'];
                $newanalysis->analysis_old_id=$var['analysis_old_id'];
                $newanalysis->oldColumn_taggingId=$var['oldColumn_taggingId'];
                $newanalysis->oldColumn_result=$var['oldColumn_result'];
                $newanalysis->oldColumn_package_count=$var['oldColumn_package_count'];
                $newanalysis->oldColumn_requestId=$var['oldColumn_requestId'];
                $newanalysis->request_id=0;
                $newanalysis->testcategory_id=0;
                $newanalysis->sample_type_id=0;
                if($newanalysis->save()){
                    $ctr++;
                }
            }
        }
        echo $ctr;
    }


}
