<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Op;
use common\models\finance\OpSearch;
use common\models\finance\Paymentitem;
use common\models\finance\Receipt;
use common\models\finance\Orseries;

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
        return $this->render('receipt');
    }
     public function actionCreateReceipt($op_id)
    {
        $op_model=$this->findModel($op_id);
       
        $model = new Receipt();
        if ($model->load(Yii::$app->request->post())) {
            $session = Yii::$app->session;
             try  {
                 //echo"gdfgtrd";
                // exit();
                $model->rstl_id=11;
                $model->terminal_id=1;
                $model->collection_id=$op_model->collection->collection_id;
                $model->or_number=$model->or;
                $model->check_id='';
                $model->total=0;
                $model->cancelled=0;
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
               // 'searchModel' => $searchModel,
              //  'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->render('create_receipt', [
                'model' => $model,
                'op_model'=> $op_model,
             //   'searchModel' => $searchModel,
               // 'dataProvider' => $dataProvider,
            ]);
        }
    }
    public function actionNextor($id)
    {
        if(!empty($id))
        {
           // =123456;
            $model = Orseries::findOne($id);
            $nextOR=$model->nextor;
            echo JSON::encode(['nxtOR'=>$nextOR,'success'=>true]);
        } else {
            echo JSON::encode(['nxtOR'=>"OR Series not selected.",'success'=>false]);
        }
    }
    //End of Receipt
    public function actionDeposit()
    {
        return $this->render('deposit');
    }
    public function actionReports()
    {
        return $this->render('reports');
    }
    
}
