<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Op;
use common\models\finance\OpSearch;
use common\models\finance\Paymentitem;
use common\models\finance\Receipt;
use common\models\finance\ReceiptSearch;
use common\models\finance\Orseries;
use common\models\finance\Collection;
use common\models\finance\Check;
use common\models\finance\Deposit;

use common\models\finance\DepositSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
class CashierController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    //Order of Payment
    public function actionOp()
    {
        $model = new Op();
        $searchModel = new OpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('op', [
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
         
         return $this->render('view_op', [
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

        return $this->render('receipt', [
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
            $session = Yii::$app->session;
             try  {
                $model->rstl_id=11;
                $model->terminal_id=1;
                $model->collection_id=$op_model->collection->collection_id;
                $model->or_number=$model->or;
                $model->check_id='';
                $model->total=0;
                $model->cancelled=0;
                $this->created_receipt($op_id);
                $model->save(false);
                $session->set('savepopup',"executed");
                return $this->redirect(['/finance/cashier/op']); 
             } catch (Exception $e) {
                   return $e;
             }
        }
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create_receipt', [
                'model' => $model,
                'op_model'=> $op_model,
            ]);
        }else{
            return $this->render('create_receipt', [
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
        return $this->render('view_receipt', [
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
            echo JSON::encode(['nxtOR'=>$nextOR,'success'=>true]);
        } else {
            echo JSON::encode(['nxtOR'=>"OR Series not selected.",'success'=>false]);
        }
    }
    
    public function created_receipt($opID){
        if(!empty($opID))
        {
            Yii::$app->financedb->createCommand()
            ->update('tbl_orderofpayment', ['created_receipt' => 1], 'orderofpayment_id= '.$opID)
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

        return $this->render('deposit', [
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
                //$model->receipt_id=$receiptid;
                $model->save(false);
                $session->set('savepopup',"executed");
                 return $this->redirect(['/finance/cashier/deposit']);
                //
                
             } catch (Exception $e) {
                   return $e;
             }
        }
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create_deposit', [
                'model' => $model,
            ]);
        }else{
            return $this->render('create_deposit', [
                'model' => $model,
            ]);
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
            return $this->renderAjax('_paymentitem', ['dataProvider'=> $paymentitemDataProvider,'receiptid'=>$receiptid,'collection_id'=>$collection_id]);
        }
        else{
            return $this->render('_paymentitem', ['dataProvider'=> $paymentitemDataProvider,'receiptid'=>$receiptid,'collection_id'=>$collection_id]);
        }
    }
    public function actionSaveCollection($id,$receiptid,$collection_id){
       // $receiptid=7;
        //var_dump($id);
       // exit;
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
             Yii::$app->financedb->createCommand()
                    ->update('tbl_collection', ['amount' => $total,'sub_total'=>+$total], 'collection_id= '.$collection_id)
                    ->execute();
             Yii::$app->financedb->createCommand()
                    ->update('tbl_receipt', ['total' => $total], 'receipt_id= '.$receiptid)
                    ->execute();
             return $this->redirect(['/finance/cashier/view-receipt?receiptid='.$receiptid]); 
         }else{
             
         }
       // echo JSON::encode(['success'=>true]);
        // return $this->redirect(['/finance/cashier/view-receipt?receiptid='.$receiptid]); 
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
            return $this->renderAjax('create_check', [
                'model' => $model,
                'check_amount'=>$sum,
                'total_collection'=>$total_collection,
            ]);
        }else{
            return $this->render('create_check', [
                'model' => $model,
                'check_amount'=>$sum,
                'total_collection'=>$total_collection,
            ]);
        }
    }
    
     //-----------END of CHECK
    public function actionReports()
    {
        return $this->render('reports');
    }
    
}
