<?php 

namespace frontend\modules\api\controllers;

use yii\web\Controller;
use Yii;
use linslin\yii2\curl;
use common\models\finance\Restore_op;
use common\models\finance\Restore_paymentitem;
use common\models\finance\SubsidiaryCustomer;
use common\models\finance\BackuprestoreLogs;
use common\models\finance\BackuprestoreLogsSearch;
use yii\helpers\Json;
use common\models\finance\Restore_receipt;
use common\models\finance\Restore_deposit;
use common\models\finance\Restore_check;
use common\models\finance\Deposit;
set_time_limit(1000);

/**
 * Default controller for the `Lab` module
 */
class FinanceController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
     public function actionIndex()
     {
         $searchModel = new BackuprestoreLogsSearch();
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         $model = new BackuprestoreLogs();
         return $this->render('backup_restore', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
             'model'=>$model,
         ]);
     }
     public function actionRes(){
	//$month = (int)$_POST['month'] + 1;
        $year =  $_POST['year'];
        
        for($month=1;$month < 13;$month++){
          
            $month_value=str_pad($month,2,"0",STR_PAD_LEFT);
            $start = $year."-".$month_value;
            $end = $year."-".$month_value;

            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

            $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/ops/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&opds=".$start."&opde=".$end;



            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            $data = json_decode($response, true);

            $sql = "SET FOREIGN_KEY_CHECKS = 0;";


            $op_count = 0;
            $paymentitem_count = 0;
            $op_sc=0;

            $connection= Yii::$app->financedb;
            $transaction = $connection->beginTransaction();
            $connection->createCommand('set foreign_key_checks=0')->execute();
    
           
            try {
             foreach ($data as $op)
             {    
                   
                    $newOp = new Restore_op();  

                    $newOp->orderofpayment_id= $op['orderofpayment_id'];

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
                    $newOp->save();
                    $op_count++;

                    foreach ($op['paymentitems'] as $item){
                       
                        $paymentitem_count++;          
                        $newPaymentitem = new Restore_paymentitem();
                        $newPaymentitem->paymentitem_id= $item['local_paymentitem_id'];
                        $newPaymentitem->rstl_id=$item['rstl_id'];
                        $newPaymentitem->request_id=$item['request_id'];
                        $newPaymentitem->request_type_id=$item['request_type_id'];
                        $newPaymentitem->orderofpayment_id=$newOp->orderofpayment_id;
                        $newPaymentitem->details=$item['details'];
                        $newPaymentitem->amount=$item['amount'];
                        $newPaymentitem->cancelled=$item['cancelled'];
                        $newPaymentitem->status=$item['status'];
                        $newPaymentitem->receipt_id=$item['receipt_id'];
                        $newPaymentitem->save(); 
                    }

             } 
            
               
                $model = new BackuprestoreLogs();
                
                $model->activity = "Restored data for the month of ".$month."-".$year;
                $model->transaction_date = date('Y-M-d');
                $model->data_date=$month."-".$year;
                $model->op = count($data)."/".$op_count;
                $model->paymentitem = $paymentitem_count."/".$paymentitem_count;
                $model->status = "COMPLETED";
                $model->save();
                
                $transaction->commit();
                
                $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for the year '.$year); 
                  
            }catch (\Exception $e) {
                Yii::$app->session->setFlash('warning', ' There was a problem connecting to the server. Please try again'); 

                $transaction->rollBack();
            }catch (\Throwable $e) {
                Yii::$app->session->setFlash('warning', ' There was a problem connecting to the server. Please try again'); 
                $transaction->rollBack();
          
            }	
        }
       
	
       
        return $this->redirect('/api/finance');
     
     }

    public function actionCustomer()
    {
        return $this->render('customers');
    }
    
    public function actionRes_receipt(){
      
        $year =  $_POST['year'];
        
        for($month=1;$month < 13;$month++){
          
            $month_value=str_pad($month,2,"0",STR_PAD_LEFT);
            $start = $year."-".$month_value;
            $end = $year."-".$month_value;

            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

            $apicom=Yii::$app->components['api_config'];
            
            $apiUrl=$apicom['api_url']."receipts/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&opds=".$start."&opde=".$end;
            
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            $data = json_decode($response, true);

            $sql = "SET FOREIGN_KEY_CHECKS = 0;";


            $receipt_count = 0;
            $deposit_count = 0;
            $check_count=0;

            $connection= Yii::$app->financedb;
            $transaction = $connection->beginTransaction();
            $connection->createCommand('set foreign_key_checks=0')->execute();
    
           // echo"<pre>".var_dump($data)."</pre>";exit;
            try {
             foreach ($data as $receipt)
             {     
                    
                    $newReceipt = new Restore_receipt(); 
                    
                    $newReceipt->receipt_id=$receipt['receipt_id'];
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
                   
                   
                    $newReceipt->save();
                    $receipt_count++;
                    
                    foreach ($receipt['check'] as $item){
                           
                        $newCheck = new Restore_check();

                        $newCheck->check_id=$item['local_check_id'];
                        $newCheck->receipt_id=$item['receipt_id'];
                        $newCheck->bank=$item['bank'];
                        $newCheck->checknumber=$item['checknumber'];
                        $newCheck->checkdate=$item['checkdate'];
                        $newCheck->amount=$item['amount'];
                        $newCheck->save(); 
                             
                        $check_count++;    
                    }
                    
                        
             } 
            
                $transaction->commit();
                $dt=$month."-".$year;
          
                $model= BackuprestoreLogs::find()->where(['data_date'=>$dt])->one();
                $model->receipt=$receipt_count;
                $model->check=$check_count;  
                $model->save(false);
                
              //  $this->Res_deposit($year);
                $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for the year '.$year); 
                  
            }catch (\Exception $e) {
                Yii::$app->session->setFlash('warning', $e->getMessage()); 

                $transaction->rollBack();
            }
        }
       
	$this->Res_deposit($year);
       
        return $this->redirect('/api/finance');
     
     }
     
     public function Res_deposit($year){
         
	
        for($month=1;$month < 13;$month++){
          
            $month_value=str_pad($month,2,"0",STR_PAD_LEFT);
            $start = $year."-".$month_value;
            $end = $year."-".$month_value;

            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

            $apicom=Yii::$app->components['api_config'];
            
            $apiUrl=$apicom['api_url']."deposits/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&opds=".$start."&opde=".$end;
            
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            $data = json_decode($response, true);
         
            $sql = "SET FOREIGN_KEY_CHECKS = 0;";


           
            $deposit_count = 0;
            

            $connection= Yii::$app->financedb;
            $transaction = $connection->beginTransaction();
            $connection->createCommand('set foreign_key_checks=0')->execute();
    
           // echo"<pre>".var_dump($data)."</pre>";exit;
            try {
                foreach ($data as $item){
                    
                    $newDeposit = new Restore_deposit();
                    $count=$this->findDeposit($item['local_deposit_id']);
                    
                    $newDeposit->deposit_id= $item['local_deposit_id'];
                    $newDeposit->rstl_id= $item['rstl_id'];
                    $newDeposit->or_series_id= $item['or_series_id'];
                    $newDeposit->start_or= $item['start_or'];
                    $newDeposit->end_or= $item['end_or'];
                    $newDeposit->amount= $item['amount'];
                    $newDeposit->deposit_type_id= $item['deposit_type_id'];
                    $newDeposit->deposit_date= $item['deposit_date'];
                    
                    if($count == 1){
                        
                    }else{ 
                        $newDeposit->save(); 
                        $deposit_count++;
                    }
                             
                              
                }
               
                $transaction->commit();
                
                $dt=$month."-".$year;
          
                $model= BackuprestoreLogs::find()->where(['data_date'=>$dt])->one();
                $model->deposit = $deposit_count;
                $model->save(false);
                
                $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for the year '.$year); 
                  
            }catch (\Exception $e) {
                Yii::$app->session->setFlash('warning', $e->getMessage()); 

                $transaction->rollBack();
            }
        }
       
	
       
        return $this->redirect('/api/finance');
     
     }
     
    public function findDeposit($depositid)
    {
        $dep = Deposit::find()->where(['deposit_id'=> $depositid])->count();
        return $dep;
    }
}