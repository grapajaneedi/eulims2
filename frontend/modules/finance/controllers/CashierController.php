<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Op;
use common\models\finance\OpSearch;
use common\models\finance\Paymentitem;
use common\models\finance\Receipt;
use yii\data\ActiveDataProvider;
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
     public function actionCreateReceipt()
    {
        $model = new Receipt();
       // $searchModel = new ReceiptSearch();
      //  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       // $dataProvider->pagination->pageSize=5;
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create_receipt', [
                'model' => $model,
               // 'searchModel' => $searchModel,
              //  'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->render('create_receipt', [
                'model' => $model,
             //   'searchModel' => $searchModel,
               // 'dataProvider' => $dataProvider,
            ]);
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
