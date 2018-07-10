<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Op;
use frontend\modules\finance\components\models\CollectionSearch;
use common\models\finance\Paymentitem;
use frontend\modules\finance\components\models\Ext_Receipt as Receipt;
use common\models\finance\ReceiptSearch;
use common\models\finance\Orseries;
use common\models\finance\Collection;
use common\models\finance\Check;
use common\models\finance\Deposit;
use yii\web\NotFoundHttpException;
use common\models\finance\DepositSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\db\Query;

class CashierController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    //Order of Payment
    public function actionCollection()
    {
        $model =new Op();
        $searchModel = new CollectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('collection/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    public function actionBilling(){
        $model =new Op();
        $searchModel = new CollectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('billing/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    public function actionViewOp($id)
    { 
         
         $paymentitem_Query = Paymentitem::find()->where(['orderofpayment_id' => $id]);
         $paymentitemDataProvider = new ActiveDataProvider([
                'query' => $paymentitem_Query,
                'pagination' => [
                    'pageSize' => 10,
                ],
        ]);
         
         return $this->render('collection/view', [
            'model' => $this->findModel($id),
            'paymentitemDataProvider' => $paymentitemDataProvider,
        ]);

    }
    protected function findModel($id)
    {
        if (($model = Op::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    // End of Order of Payment
    
    //-------Receipt
   
    public function actionReceipt()
    {
        $model = new Receipt();
        $searchModel = new ReceiptSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('receipt/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
     public function actionCreateReceipt($op_id)
    {
        $op_model=$this->findModel($op_id);
        $model = new Receipt();
        
        if ($model->load(Yii::$app->request->post())) {
            $connection=Yii::$app->financedb;
            $transaction =$connection->beginTransaction();
             $session = Yii::$app->session;
             try  {
               // $model->getDb()=$connection;
                $model->rstl_id=$GLOBALS['rstl_id'];
                $model->terminal_id=$GLOBALS['terminal_id'];
                $model->collection_id=$op_model->collection->collection_id;
                $this->update_nextor($model->or_series_id,$connection);
               // $model->or_series_id=$model->or_series_id;
                $model->or_number=$model->or;
                $model->total=0;
                $model->cancelled=0;
                $model->save(false);
                $this->created_receipt($op_id,$model->receipt_id);
                 $transaction->commit();
              //  $session->set('savepopup',"executed");
                return $this->redirect(['/finance/cashier/view-receipt?receiptid='.$model->receipt_id]); 
             } catch (Exception $e) {
                 $transaction->rollBack();
                 return $e;
             }
        }
         $model->receiptDate=date('Y-m-d');
         $model->payment_mode_id=$op_model->payment_mode_id;
         $model->collectiontype_id=$op_model->collectiontype_id;
        if(Yii::$app->request->isAjax){
           
            return $this->renderAjax('receipt/_form', [
                'model' => $model,
                'op_model'=> $op_model,
            ]);
        }else{
            return $this->render('receipt/_form', [
                'model' => $model,
                'op_model'=> $op_model,
            ]);
        }
    }
    public function actionViewReceipt($receiptid)
    { 
        $receipt=$this->findModelReceipt($receiptid);
        $collection_id=$receipt->collection_id;
        $collection=$this->findModelCollection($collection_id);
        $op_id=$collection->orderofpayment_id;
        
        $paymentitem_Query = Paymentitem::find()->where(['orderofpayment_id' => $op_id])->andWhere(['status' => 1]);
        $paymentitemDataProvider = new ActiveDataProvider([
                'query' => $paymentitem_Query,
                'pagination' => [
                'pageSize' => 10,
                ],
        ]);
        $check_Query = Check::find()->where(['receipt_id' => $receiptid]);
        $checkDataProvider = new ActiveDataProvider([
                'query' => $check_Query,
                'pagination' => [
                'pageSize' => 10,
                ],
        ]);
        return $this->render('receipt/view', [
            'model' => $receipt,
            'op_model'=>$this->findModel($op_id),
            'paymentitemDataProvider' => $paymentitemDataProvider,
            'check_model'=>$checkDataProvider,
        ]);

    }
    protected function findModelReceipt($id)
    {
        if (($model = Receipt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
   
    public function actionNextor($id)
    {
        if(!empty($id))
        {
            $model = Orseries::findOne($id);
            $nextOR=$model->nextor;
            $endOR=$model->endor;
            if($nextOR > $endOR){
                echo JSON::encode(['nxtOR'=>'Please update O.R Series','success'=>false]);
            }
            else{
                echo JSON::encode(['nxtOR'=>$nextOR,'success'=>true]);
            }
            
        } else {
            echo JSON::encode(['nxtOR'=>"OR Series not selected.",'success'=>false]);
        }
    }
     public function update_nextor($orseries_id,$connection){
       $sql_update='UPDATE tbl_orseries SET nextor=nextor +1 WHERE or_series_id=:orseries_id';
       $Command=$connection->createCommand($sql_update);
       $Command->bindValue(':orseries_id',$orseries_id);
       $Command->execute();
     }
     
    public function created_receipt($opID,$receiptid){
        if(!empty($opID))
        {
            Yii::$app->financedb->createCommand()
            ->update('tbl_orderofpayment', ['created_receipt' => $receiptid], 'orderofpayment_id= '.$opID)
            ->execute(); 
            
        }
     }
    //End of Receipt
     //------------DEPOSIT
    public function actionDeposit()
    {
        $model = new Deposit();
        $searchModel = new DepositSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('deposit/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    public function actionAddDeposit()
    {
        $model = new Deposit();
        
        if ($model->load(Yii::$app->request->post())) {
            $session = Yii::$app->session;
             try  {
                 $model->rstl_id=$GLOBALS['rstl_id'];
                 $model->start_or=$this->findModelReceipt($model->start_or)->or_number;
                 $model->end_or=$this->findModelReceipt($model->end_or)->or_number;
                // $model->amount=($model->amount);
                /* echo'<pre>';
                 var_dump(Yii::$app->request->post());
                  echo'</pre>';
                 exit;*/
                $model->save(false);
                $this->update_receipt_depositid($model->start_or, $model->end_or, $model->deposit_id);
                $session->set('savepopup',"executed");
                 return $this->redirect(['/finance/cashier/deposit/']);
                //
                
             } catch (Exception $e) {
                   return $e;
             }
        }
        $model->deposit_date=date('Y-m-d');
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('deposit/_form', [
                'model' => $model,
            ]);
        }else{
            return $this->render('deposit/_form', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionListorseries() {
        // var_dump($_POST['depdrop_parents']);
        //exit();
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Orseries::find()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                //$out[] = ['id' => '0', 'name' => 'Please Select'];
                foreach ($list as $i => $or) {
                    $out[] = ['id' => $or['or_series_id'], 'name' => $or['or_series_name']];
                    if ($i == 0) {
                        $selected = $or['or_series_id'];
                    }
                }
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }
    
    public function actionStartOr() {
       // var_dump($_POST['depdrop_parents']);
      // exit();
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
        $ids = $_POST['depdrop_parents'];
        $deposit_type_id = empty($ids[0]) ? null : $ids[0];
        $or_series_id= empty($ids[1]) ? null : $ids[1];
        

            $list = Receipt::find()->andWhere(['or_series_id'=>$or_series_id])->andWhere(['deposit_type_id'=>$deposit_type_id])->andWhere(['deposit_id'=>null])->asArray()->all();
         //  $list = Receipt::find()->andWhere(['or_series_id'=>$ids])->andWhere(['deposit_id'=>null])->asArray()->all();
            $selected  = null;
            if ($ids != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $or) {
                    $out[] = ['id' => $or['receipt_id'], 'name' => $or['or_number']];
                    if ($i == 0) {
                        $selected = $or['receipt_id'];
                    }
                }
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }
    
    public function actionEndOr() {
        //SELECT receipt_id,or_number FROM tbl_receipt WHERE deposit_type_id=1 AND or_series_id=1 AND (or_number BETWEEN 2900000 AND 2900001)
     
        $out = [];
        if (isset($_POST['depdrop_parents']) <> '') {
            $id = end($_POST['depdrop_parents']);
            $receipt=$this->findModelReceipt($id);
             $list=(new Query)
            ->select('receipt_id,or_number')
            ->from('eulims_finance.tbl_receipt')
            ->where(['deposit_type_id' => $receipt->deposit_type_id])
            ->andWhere(['or_series_id' => $receipt->or_series_id]) 
            ->andWhere(['deposit_id'=>null]) 
            ->andWhere(['>=', 'or_number',$receipt->or_number])
                   //  ['<=', 'population', $upper]
            ->all();
        // echo $wallet["balance"];
            //$list = Receipt::find()->andWhere(['receipt_id'=>$id])->andWhere(['deposit_id'=>null])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $test) {
                    $out[] = ['id' => $test['receipt_id'], 'name' => $test['or_number']];
                    if ($i == 0) {
                        $selected = $test['receipt_id'];
                    }
                }
                
                echo Json::encode(['output' => $out, 'selected'=>'']);
                return;
            }
        }
        else{
            echo Json::encode(['output' => '', 'selected'=>'']);
            exit;
        }
        //
    }
   public function actionCalculateTotalDeposit($id,$endor) {
        $total = 0;
        $start_receipt=$this->findModelReceipt($id);
        $start_or=$start_receipt->or_number;
        $deposit_type_id= $start_receipt->deposit_type_id;
        $or_series_id=$start_receipt->or_series_id;
        $end_receipt=$this->findModelReceipt($endor);
        $end_or=$end_receipt->or_number;
        
        $sum=(new Query)
            ->select('receipt_id,or_number,total')
            ->from('eulims_finance.tbl_receipt')
            ->where(['deposit_type_id' => $deposit_type_id])
            ->andWhere(['or_series_id' => $or_series_id]) 
            ->andWhere(['deposit_id'=>null]) 
            ->andWhere(['between', 'or_number',$start_or,$end_or])
                   //  ['<=', 'population', $upper]
            ->sum('total');
        if($id == '' ){
            echo 'why?huhuhu';
        }
        else{
           //->sum('amount')
            echo $sum;
        }
     }
    
     public function update_receipt_depositid($startor,$endor,$depositid){
        if(!empty($startor) && !empty($endor) )
        {
            Yii::$app->financedb->createCommand()
            ->update('tbl_receipt', ['deposit_id' => $depositid], ['between', 'or_number',$startor,$endor])
            ->execute(); 
            
        }
     }
    //------------------END of DEPOSIT
    //------------COLLECTION
    protected function findModelCollection($id)
   {
       if (($model = Collection::findOne($id)) !== null) {
           return $model;
       } else {
           throw new NotFoundHttpException('The requested page does not exist.');
       }
   }
    protected function findPaymentitem($id)
   {
       if (($model = Paymentitem::findOne($id)) !== null) {
           return $model;
       } else {
           throw new NotFoundHttpException('The requested page does not exist.');
       }
   }
    public function actionAddCollection($opid,$receiptid)
    {
      //  var_dump($receiptid);
       // exit;
        $op=$this->findModel($opid);
        $collection_id=$op->collection->collection_id;
       // $collection=$this->findModelCollection($collection_id);
        $paymentitem_Query = Paymentitem::find()->where(['orderofpayment_id' => $opid])->andWhere(['status' => 0]);
        $paymentitemDataProvider = new ActiveDataProvider([
                'query' => $paymentitem_Query,
        ]);
        
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('collection/_paymentitem', ['dataProvider'=> $paymentitemDataProvider,'receiptid'=>$receiptid,'collection_id'=>$collection_id]);
        }
        else{
            return $this->render('collection/_paymentitem', ['dataProvider'=> $paymentitemDataProvider,'receiptid'=>$receiptid,'collection_id'=>$collection_id]);
        }
    }
    public function actionSaveCollection($id,$receiptid,$collection_id){
        $collection=$this->findModelCollection($collection_id);
        $op_id=$collection->orderofpayment_id;
        $sub_total=$collection->sub_total;
        $wallet_amount=$collection->wallet_amount;
        $op_model=$this->findModel($op_id);
        $amount=$op_model->total_amount;
        $receipt_model=$this->findModelReceipt($receiptid);
        $receipt_total=$receipt_model->total;
         if($id <> '' ){
            $str_total = explode(',', $id);
            $arr_length = count($str_total); 
            $total=0;
            for($i=0;$i<$arr_length;$i++){
                 $paymentitem =$this->findPaymentitem($str_total[$i]);
                  Yii::$app->financedb->createCommand()
                    ->update('tbl_paymentitem', ['status' => 1], 'paymentitem_id= '.$str_total[$i])
                    ->execute(); 
                  $total+=$paymentitem->amount;
            } 
         $amount_total=$sub_total+$total;   
         $sum_total=$sub_total+$total+$wallet_amount; 
         $receipt_total_amount=$receipt_total+$total;
             Yii::$app->financedb->createCommand()
                    ->update('tbl_receipt', ['total' => $receipt_total_amount], 'receipt_id= '.$receiptid)
                    ->execute();
             
             if($sum_total == $amount){
                 Yii::$app->financedb->createCommand()
                    ->update('tbl_collection', ['amount' => $amount_total,'sub_total'=>$sum_total,'payment_status_id' => 1], 'collection_id= '.$collection_id)
                    ->execute();
             }
             if($sum_total < $amount){
                 Yii::$app->financedb->createCommand()
                    ->update('tbl_collection', ['amount' => $amount_total,'sub_total'=>$sum_total,'payment_status_id' => 2], 'collection_id= '.$collection_id)
                    ->execute();
             }
             return $this->redirect(['/finance/cashier/view-receipt?receiptid='.$receiptid]); 
         }else{
             
         }
    }
     public function actionCalculateTotal($id) {
        $total = 0;
        if($id == '' ){
            echo $total;
        }
        else{
            $str_total = explode(',', $id);
            $arr_length = count($str_total); 
            for($i=0;$i<$arr_length;$i++){
                 $paymentitem =$this->findPaymentitem($str_total[$i]);
                 $total+=$paymentitem->amount;
            }
            echo $total;
        }
     }
    //-------------END of COLLECTION
     //------CHECK
    public function actionAddCheck($receiptid)
    {
         $model = new Check();
         $receipt=$this->findModelReceipt($receiptid);
         $total_collection=$receipt->total;
         $sum = Check::find()->where(['receipt_id'=>$receiptid])->sum('amount');
        // var_dump($sum);
        // exit;
        if ($model->load(Yii::$app->request->post())) {
            $session = Yii::$app->session;
             try  {
                $model->receipt_id=$receiptid;
                $model->save(false);
                 return $this->redirect(['/finance/cashier/view-receipt?receiptid='.$receiptid]);
                //$session->set('savepopup',"executed");
                
             } catch (Exception $e) {
                   return $e;
             }
        }
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('check/_form', [
                'model' => $model,
                'check_amount'=>$sum,
                'total_collection'=>$total_collection,
            ]);
        }else{
            return $this->render('check/_form', [
                'model' => $model,
                'check_amount'=>$sum,
                'total_collection'=>$total_collection,
            ]);
        }
    }
    
     //-----------END of CHECK
    public function actionReports()
    {
        return $this->render('reports/index');
    }
    
}
