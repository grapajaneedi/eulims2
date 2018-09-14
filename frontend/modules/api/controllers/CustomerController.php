<?php 

namespace frontend\modules\api\controllers;

use yii\web\Controller;
use Yii;
use linslin\yii2\curl;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Customer;

/**
 * Default controller for the `Lab` module
 */
class CustomerController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $requestquery = Request::find()->Where(['rstl_id'=>11])->andWhere(['between', 'request_id', 1, 1000])->all();  
        
                // $samplesquery = Sample::find()
                // ->andWhere(['between', 'request_id', 1, 10])->all();
        
                // $analysisquery = Analysis::find()
                // ->andWhere(['between', 'request_id', 1, 10])->all();
        
                $customerquery = Customer::find()
                ->leftJoin('tbl_request', 'tbl_request.customer_id=tbl_customer.customer_id')
                ->Where(['tbl_customer.rstl_id'=>11])
                ->andWhere(['between', 'tbl_request.request_id', 1, 10000])->all();
        
                $syncarray = [
                    'sync_log'=>[
                        'date_sync'=>'09/11/2018 10:01:12',
                        'rstl_id'=>11,
                        'local_user_id'=>1,
                        'sync_details'=>[
                           [
                             'table_name'=>'tbl_request',
                             'start_id'=>'1',
                             'last_id'=>10
                           ],
                           [
                             'table_name'=>'tbl_sample',
                             'start_id'=>'1',
                             'last_id'=>10
                           ]
                        ]
                    ],
                    'tbl_customer'=> $customerquery
                ];
        
                \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
             
        
               $content = json_encode($syncarray);
               $LabURI="http://api3.onelab.ph.local/lab/getlabmodule";
                $curl = new curl\Curl();
        
        
                return $syncarray;
                exit;
         
                $response = $curl->setOption(
                    CURLOPT_POSTFIELDS, 
                    http_build_query(array(
                    'myPostField' => 'value'
                     )
                 ))
               ->post('http://api3.onelab.ph.local/lab/getlabmodule');
                      
        
        // return $response;
        // exit;
        //        return $response;
        
             //    $response = $curl->setRequestBody(json_encode($syncarray))
                  //  ->setOption(CURLOPT_ENCODING, 'gzip')
                //    ->post('http://api3.onelab.ph.local/lab/getlabmodule');
                //return $response;
    }

    public function actionCustomer()
    {
        return $this->render('customers');
    }
}