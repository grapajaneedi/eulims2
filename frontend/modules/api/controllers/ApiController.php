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
use common\models\finance\Restore_paymentitem;
use common\models\finance\Restore_deposit;
use common\models\finance\Restore_receipt;
use common\models\finance\Restore_check;

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
           // $newOp = new Restore_op();
            $newOp= new OrderofpaymentMigration();
            $newOp->rstl_id= $op['rstl_id'];

            $newOp->transactionnum= $op['transactionnum'];
            $newOp->collectiontype_id= $op['collectiontype_id'];
            $newOp->payment_mode_id= $op['payment_mode_id'];
            $newOp->on_account= $op['on_account'];
            $newOp->order_date= $op['order_date'];
            $newOp->customer_id= $op['customer_id'];
            $newOp->receipt_id=$op['receipt_id'];
            $newOp->purpose= $op['purpose'];
            $newOp->payment_status_id= $op['payment_status_id'];
            $newOp->local_orderofpayment_id=$op['orderofpayment_id'];
            if($newOp->save()){
                foreach ($op['payment_item'] as $paymentitem) {
                   // $newPaymentitem = new Restore_paymentitem();
                    $newPaymentitem = new PaymentitemMigration();
                    //$newPaymentitem->paymentitem_id= $item['local_paymentitem_id'];
                    $newPaymentitem->rstl_id=$paymentitem['rstl_id'];
                    $newPaymentitem->request_id=$paymentitem['request_id'];
                    $newPaymentitem->request_type_id=$paymentitem['request_type_id'];
                    $newPaymentitem->orderofpayment_id=$newOp->orderofpayment_id;
                    $newPaymentitem->local_orderofpayment_id=$paymentitem['orderofpayment_id'];
                    $newPaymentitem->details=$paymentitem['details'];
                    $newPaymentitem->amount=$paymentitem['amount'];
                    $newPaymentitem->cancelled=$paymentitem['cancelled'];
                    $newPaymentitem->status=$paymentitem['status'];
                    $newPaymentitem->receipt_id=$paymentitem['receipt_id'];
                    $newPaymentitem->local_paymentitem_id= $paymentitem['paymentitem_id'];
                    $newPaymentitem->save();
                }
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
      
       public function actionSync_orderofpaymentx(){
          
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
            $newOp->receipt_id=$op['receipt_id'];
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
      
      public function actionSync_receipt(){
          
        $post = Yii::$app->request->post(); //get the post
        $data = Yii::$app->request->post('data');
        
        $ctr = 0;
        //$idsave=[];
        $idsave="";
        $idfail="";
        $idsaveop="";
        $idfailop="";
        $listIds = [];
        foreach ($data as $receipt) {
            //$newReceipt = new Restore_receipt();
            $newReceipt = new ReceiptMigration();
            ////////-----------------------------------------///////////////////////
            $newReceipt->rstl_id=$receipt['rstl_id'];
            $newReceipt->orderofpayment_id=$receipt['local_orderofpayment_id'];
            $newReceipt->deposit_type_id=$receipt['deposit_type_id'];
            $newReceipt->or_series_id=$receipt['or_series_id'];
            $newReceipt->or_number=$receipt['or_number'];
            $newReceipt->receiptDate=$receipt['receiptDate'];
            $newReceipt->payment_mode_id=$receipt['payment_mode_id'];
            $newReceipt->payor=$receipt['payor'];
            $newReceipt->collectiontype_id=$receipt['collectiontype_id'];
            $newReceipt->total=$receipt['total'];
            $newReceipt->deposit_id=$receipt['local_deposit_id'];
            $newReceipt->customer_id=$receipt['customer_id'];
            $newReceipt->terminal_id=1;
            $newReceipt->cancelled=0;
            $newReceipt->local_receipt_id=$receipt['local_receipt_id'];

            ///////////////----------------------------------
            if($newReceipt->save()){
                foreach ($receipt['check'] as $item) {
                    //$newCheck = new Restore_check();
                     $newCheck = new CheckMigration();
                     $newCheck->receipt_id= $newReceipt->receipt_id;
                     $newCheck->local_receipt_id=$receipt['local_receipt_id'];
                     $newCheck->local_check_id=$item['local_check_id'];
                     $newCheck->bank=$item['bank'];
                     $newCheck->checknumber=$item['checknumber'];
                     $newCheck->checkdate=$item['checkdate'];
                     $newCheck->amount=$item['amount'];
                     $newCheck->save(false); 
                }
                 foreach ($receipt['op'] as $op) {
                    // $newOp = new Restore_op();
                     $newOp= new OrderofpaymentMigration();
                     $newOp->rstl_id= $op['rstl_id'];

                     $newOp->transactionnum= $op['transactionnum'];
                     $newOp->collectiontype_id= $op['collectiontype_id'];
                     $newOp->payment_mode_id= $op['payment_mode_id'];
                     $newOp->on_account= $op['on_account'];
                     $newOp->order_date= $op['order_date'];
                     $newOp->customer_id= $op['customer_id'];
                     //$newOp->receipt_id=$op['receipt_id'];
                     $newOp->receipt_id=$newReceipt->receipt_id;
                     $newOp->purpose= $op['purpose'];
                     $newOp->payment_status_id= $op['payment_status_id'];
                     $newOp->local_orderofpayment_id=$op['orderofpayment_id'];
                     if($newOp->save()){
                         foreach ($op['payment_item'] as $paymentitem) {
                            // $newPaymentitem = new Restore_paymentitem();
                             $newPaymentitem = new PaymentitemMigration();
                             //$newPaymentitem->paymentitem_id= $item['local_paymentitem_id'];
                             $newPaymentitem->rstl_id=$paymentitem['rstl_id'];
                             $newPaymentitem->request_id=$paymentitem['request_id'];
                             $newPaymentitem->request_type_id=$paymentitem['request_type_id'];
                             $newPaymentitem->orderofpayment_id=$newOp->orderofpayment_id;
                             $newPaymentitem->local_orderofpayment_id=$paymentitem['orderofpayment_id'];
                             $newPaymentitem->details=$paymentitem['details'];
                             $newPaymentitem->amount=$paymentitem['amount'];
                             $newPaymentitem->cancelled=$paymentitem['cancelled'];
                             $newPaymentitem->status=$paymentitem['status'];
                             //$newPaymentitem->receipt_id=$paymentitem['receipt_id'];
                             $newPaymentitem->receipt_id=$newReceipt->receipt_id;
                             $newPaymentitem->local_paymentitem_id= $paymentitem['paymentitem_id'];
                             $newPaymentitem->save();
                         }
                   
                     }
                     
                 }
               
                $idsave=$receipt['local_receipt_id'];
            }
            else{
                $idfail=$receipt['local_receipt_id'];
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

     public function actionSync_deposit(){
          
        $post = Yii::$app->request->post(); //get the post
        $data = Yii::$app->request->post('data');
        
        $ctr = 0;
        $idsave="";
        $idfail="";
        $listIds = [];
        foreach ($data as $item) {
           // $newDeposit = new Restore_deposit();
            $newDeposit = new DepositMigration();
            $newDeposit->local_deposit_id= $item['local_deposit_id'];
            $newDeposit->rstl_id= $item['rstl_id'];
            $newDeposit->or_series_id= $item['or_series_id'];
            $newDeposit->start_or= $item['start_or'];
            $newDeposit->end_or= $item['end_or'];
            $newDeposit->amount= $item['amount'];
            $newDeposit->deposit_type_id= $item['deposit_type_id'];
            $newDeposit->deposit_date= $item['deposit_date'];
            if($newDeposit->save()){
                $ctr++;
               // array_push($idsave, $op['orderofpayment_id']);
                $idsave=$item['local_deposit_id'];
            }
            else{
                $idfail=$item['local_deposit_id'];
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
      
      public function actionSync_paymentitem(){
          
        $post = Yii::$app->request->post(); //get the post
        $data = Yii::$app->request->post('data');
        
        $ctr = 0;
        $idsave="";
        $idfail="";
        $listIds = [];
        foreach ($data as $paymentitem) {
           //$newPaymentitem = new Restore_paymentitem();
            $newPaymentitem = new PaymentitemMigration();
            //$newPaymentitem->paymentitem_id= $item['local_paymentitem_id'];
            $newPaymentitem->rstl_id=$paymentitem['rstl_id'];
            $newPaymentitem->request_id=$paymentitem['request_id'];
            $newPaymentitem->request_type_id=$paymentitem['request_type_id'];
            $newPaymentitem->orderofpayment_id=$paymentitem['orderofpayment_id'];
            $newPaymentitem->local_orderofpayment_id=$paymentitem['orderofpayment_id'];
            $newPaymentitem->details=$paymentitem['details'];
            $newPaymentitem->amount=$paymentitem['amount'];
            $newPaymentitem->cancelled=$paymentitem['cancelled'];
            $newPaymentitem->status=$paymentitem['status'];
            $newPaymentitem->receipt_id=$paymentitem['receipt_id'];
            $newPaymentitem->local_paymentitem_id= $paymentitem['paymentitem_id'];
            
            if($newPaymentitem->save(false)){
                $ctr++;
               // array_push($idsave, $op['orderofpayment_id']);
                $idsave=$paymentitem['paymentitem_id'];
            }
            else{
                $idfail=$paymentitem['paymentitem_id'];
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
