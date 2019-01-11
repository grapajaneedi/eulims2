<?php
namespace frontend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\system\Profile;
use kartik\mpdf\Pdf;
use yii\helpers\Json;
use common\models\lab\CustomerMigration;
use common\models\lab\RequestMigration;
use common\models\lab\SampleMigration;
use common\models\lab\AnalysisMigration;
use common\models\lab\Customer;
use common\models\finance\CheckMigration;
use common\models\finance\ReceiptMigration;
use common\models\finance\PaymentitemMigration;
use common\models\finance\OrderofpaymentMigration;
use common\models\finance\DepositMigration;
use common\models\finance\CollectionMigration;

use common\models\finance\Restore_op;
use common\models\finance\Deposit;

/* @property Customer $customer */
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

   
      public function actionSync_orderofpayment(){
          
        $post = Yii::$app->request->post(); //get the post
        $data = Yii::$app->request->post('data');
        
        $ctr = 0;
        //$idsave=[];
        $idsave="";
        $idfail="";
        $listIds = [];
        foreach ($data as $op) {
            $newOp = new OrderofpaymentMigration();
            $newOp->rstl_id= $op['rstl_id'];

            $newOp->transactionnum= $op['transactionnum'];
            $newOp->collectiontype_id= $op['collectiontype_id'];
            $newOp->payment_mode_id= $op['payment_mode_id'];
            $newOp->on_account= $op['on_account'];
            $newOp->order_date= $op['order_date'];
            $newOp->customer_id= $op['customer_id'];
            $newOp->receipt_id=null;//$op['receipt_id'];
            $newOp->purpose= $op['purpose'];
            $newOp->payment_status_id= $op['payment_status_id'];
            $newOp->local_orderofpayment_id=$op['orderofpayment_id'];
            if($newOp->save()){
                $ctr++;
               // array_push($idsave, $op['orderofpayment_id']);
                $idsave=$op['orderofpayment_id'];
            }
            else{
                $idfail=$op['orderofpayment_id'];
            }
        }
        $detail=[
            'num'=>$ctr,
            'idsave'=>$idsave,
            'idfail'=>$idfail
                
        ];
        array_push($listIds, $detail);
        
        return $listIds;
      }

}
