<?php

namespace frontend\modules\finance\controllers;
use Yii;
use common\models\finance\clientSearch;
use common\models\finance\Client;

class BillingController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionManager(){
        return $this->render('manager');
    }
    /**
     * Creates a new client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionClientcreate()
    {
        $model = new Client();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/finance/billing/client']);
        } else {
            $model->account_number="<autogenerate>";
            $model->signature_date=date('Y-m-d');
            $model->signed=1;
            $model->active=1;
            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('client/create', [
                    'model' => $model,
                ]);
            }
        }
    }
    public function actionClient(){
        //echo str_pad(11, 3,'0',STR_PAD_LEFT);
        //exit;
        $searchModel = new clientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('client/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionInvoices(){
        return $this->render('invoices');
    }
    public function actionAr(){
        return $this->render('ar');
    }
    public function actionReports(){
        return $this->render('reports');
    }
}
