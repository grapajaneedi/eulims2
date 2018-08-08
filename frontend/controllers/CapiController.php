<?php
namespace frontend\controllers;

use Yii;

use yii\web\Response;

use yii\rest\ActiveController;

use yii\data\ActiveDataProvider;

class CapiController extends ActiveController

{

    public $modelClass = 'common\models\api\OrderOfPayment';

    public $modelClass1 = 'common\models\api\PaymentDetails';

    public function behaviors()
    {
	return [
	    [
	        'class' => 'yii\filters\ContentNegotiator',
	        'only' => ['view', 'index'],
	        'formats' => [
	                'application/json' => Response::FORMAT_JSON,
	        ],
	    ],
            [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 86400,
                ]    
            ],
	];
    }

    public function actionOp(){

     // \Yii::$app->response->format = 'json';
      $model = new $this->modelClass;
      
      if(isset($_GET['id'])){
      	$data = $model::find()->where(["op_id" => $_GET['id']])->all();
      }else{ //if ($model->load(Yii::$app->request->post(), '')) {
	$req_id = 0;
        
	// req_data retrieves the posted json data
	$req_data = Yii::$app->request->post();
        
	// payment_details gets the payment details from posted the json data
	$payment_details = $req_data['payment_details'];
        
	// Save in the tbl_order_of_payment
        $model->transaction_num = $req_data['transaction_num'];
        $model->customer_code = $req_data['customer_code'];
        $model->collection_type = $req_data['collection_type'];
        $model->collection_code = $req_data['collection_code'];
        $model->order_date = $req_data['order_date'];
        $model->agency_code = $req_data['agency_code'];
        $model->total_amount = $req_data['total_amount'];
        $model->op_status = 'Pending';
        $model->save();
       
	// Get the op_id of the stored order of payment data
	$request = $model::find()->where(["transaction_num" => $req_data['transaction_num']])->all();
	$req_id = $request[0]['op_id'];

	// Loop (if there is) and save the payment details 
	//for($i = 0; $i < count($payment_details); $i++){
        $paymentItems = json_decode( $payment_details, true );
        foreach($paymentItems as $paymentItem){

		$model1 = new $this->modelClass1;

		// Save in the tbl_payment_details
		$model1->op_id = $req_id;
		$model1->request_ref_num = $paymentItem->request_ref_num;
		$model1->rrn_date_time = $paymentItem->rrn_date_time;
		$model1->amount = $paymentItem->amount;

		if($model1->validate()){
			$model1->save();
			unset($model1);
			
			// If the data stored successfully
			$data['status'] = 'success';
		}
		else{

			// If there is an error saving the data
			$errors = $model1->errors;
			$data = $errors;
		}
		
	}
	
	
      }else{
      	$data['status'] = 'error';
      }
      Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
      return $data;
    }

}