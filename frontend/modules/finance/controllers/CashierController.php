<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Op;
use common\models\finance\OpSearch;

class CashierController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
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
        //return $this->render('op');
    }
    public function actionReceipt()
    {
        return $this->render('receipt');
    }
    public function actionDeposit()
    {
        return $this->render('deposit');
    }
    public function actionReports()
    {
        return $this->render('reports');
    }
}
