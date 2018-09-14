<?php 

namespace frontend\modules\api\controllers;

use yii\web\Controller;
use Yii;
use linslin\yii2\curl;
use common\models\lab\Restore_request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Customer;
use yii\helpers\Json;

/**
 * Default controller for the `Lab` module
 */
class LabController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('backup_restore');

    }

    public function actionRestore(){
        $apiUrl="https://api3.onelab.ph/get/requests?rstl_id=11";
        $curl = new curl\Curl();
        $responselab = $curl->get($apiUrl);   
        $lab = Json::decode($responselab);

        $count = 0;
        foreach ($lab as $var)
        {     
            //REQUEST   
            $newRequest = new Restore_request();
            $newRequest->request_id= $var['request_id'];
            $newRequest->request_ref_num = $var['request_ref_num'];
            $newRequest->request_datetime= $var['request_datetime'];
            $newRequest->rstl_id= $var['rstl_id'];
            $newRequest->lab_id= $var['lab_id'];
            $newRequest->customer_id= $var['customer_id'];
            $newRequest->payment_type_id= $var['payment_type_id'];
            $newRequest->modeofrelease_ids= $var['modeofrelease_ids'];
            $newRequest->discount = $var['discount'];
            $newRequest->purpose_id= $var['purpose_id'];
            $newRequest->conforme= $var['conforme'];
            $newRequest->report_due= $var['report_due'];
            $newRequest->total= $var['total'];
            $newRequest->receivedBy = $var['receivedBy'];
            $newRequest->recommended_due_date = $var['recommended_due_date'];
            $newRequest->est_date_completion = $var['est_date_completion'];
            $newRequest->items_receive_by = $var['items_receive_by'];
            $newRequest->equipment_release_date = $var['equipment_release_date'];
            $newRequest->certificate_release_date = $var['certificate_release_date'];
            $newRequest->released_by = $var['released_by'];
            $newRequest->posted = $var['posted'];
            $newRequest->status_id = $var['status_id'];
            $newRequest->selected = $var['selected'];
            $newRequest->other_fees_id = $var['other_fees_id'];
            $newRequest->request_type_id = $var['request_type_id'];
            $newRequest->position = $var['position'];
            $newRequest->completed = $var['completed'];
            $newRequest->received_by = $var['received_by'];
            $newRequest->payment_status_id = $var['payment_status_id'];
            $newRequest->oldColumn_requestId= $var['oldColumn_requestId'];
            $newRequest->oldColumn_sublabId= $var['oldColumn_sublabId'];
            $newRequest->oldColumn_orId = $var['oldColumn_orId'];
            $newRequest->oldColumn_completed= $var['oldColumn_completed'];
            $newRequest->oldColumn_cancelled= $var['oldColumn_cancelled'];
            $newRequest->oldColumn_create_time= $var['oldColumn_create_time'];
            $newRequest->request_old_id= $var['request_old_id'];
            $newRequest->created_at= $var['created_at'];
            $newRequest->discount_id= $var['discount_id'];
            $newRequest->customer_old_id= $var['customer_old_id'];
            $newRequest->tmpCustomerID= $var['tmpCustomerID'];
            $count++;
            if($newRequest->save(true)){
                    $message = "saved request";               
            }else{
                    $message = "not saved request";
            }

          
         
           // \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        }

        Yii::$app->session->setFlash('success', $count.' Records Successfully Restored'); 
        return $this->redirect(['index']);
    }

    public function actionCustomer()
    {
        return $this->render('customers');
    }
}