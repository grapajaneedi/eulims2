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
	
        $searchModel = new BackuprestoreLogsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new BackuprestoreLogs();
		 
        $month = (int)$_POST['month'] + 1;
        $year =  $_POST['year'];
        
        
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
                $newOp->purpose= $op['purpose'];
                $newOp->payment_status_id= $op['payment_status_id'];
                $newOp->save(false);
                $op_count++;
		 
                foreach ($op['paymentitems'] as $item){
                    $paymentitem_count++;          
                    $newPaymentitem = new Restore_paymentitem();
                    $newPaymentitem->paymentitem_id= $item['paymentitem_id'];
                    $newPaymentitem->rstl_id=$item['rstl_id'];
                    $newPaymentitem->request_id=$item['request_id'];
                    $newPaymentitem->request_type_id=$item['request_type_id'];
                    $newPaymentitem->orderofpayment_id=$newOp->orderofpayment_id;
                    $newPaymentitem->details=$item['details'];
                    $newPaymentitem->amount=$item['amount'];
                    $newPaymentitem->cancelled=$item['cancelled'];
                    $newPaymentitem->status=$item['status'];
                    $newPaymentitem->receipt_id=$item['receipt_id'];
                    $newPaymentitem->save(true); 
                }
                
                foreach ($op['subsidiary_customer'] as $item1){
                    $sc= new SubsidiaryCustomer();
                    $sc->subsidiary_customer_id= $item1['subsidiary_customer_id'];
                    $sc->orderofpayment_id=$item1['orderofpayment_id'];
                    $sc->customer_id=$item1['customer_id'];
                    $sc->save();
                    $op_sc++;
                }
         }
		Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$month.' '.$year); 
              
				
                $sql = "SET FOREIGN_KEY_CHECKS = 1;";

                $model->activity = "Restored data for the month of ".$month."-".$year;
                $model->transaction_date = date('Y-M-d');
                $model->op_data = count($data)."/".$op_count;
                $model->pi_data = count($op['paymentitems'])."/".$paymentitem_count;
                $model->sc_data = count($op['subsidiary_customer'])."/".$op_count;
                $model->status = "COMPLETED";
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$month.' '.$year); 
                $model->save(false);
                
                $transaction->commit();
        }catch (\Exception $e) {
            Yii::$app->session->setFlash('warning', ' There was a problem connecting to the server. Please try again'); 
          
            $transaction->rollBack();
            return $this->renderAjax('/finance/backup_restore', [
                'model'=>$model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
             ]);
	}catch (\Throwable $e) {
            Yii::$app->session->setFlash('warning', ' There was a problem connecting to the server. Please try again'); 
          
            $transaction->rollBack();
           return $this->renderAjax('/finance/backup_restore', [
            'model'=>$model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}	
	
       
        return $this->redirect('/api/finance');
     
     }

    public function actionCustomer()
    {
        return $this->render('customers');
    }
}