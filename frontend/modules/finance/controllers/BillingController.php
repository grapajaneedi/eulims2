<?php

namespace frontend\modules\finance\controllers;
use Yii;
use common\models\finance\clientSearch;
use common\models\finance\Client;
use common\models\finance\Op;
use common\models\finance\BillingSearch;
use common\models\finance\SoaSearch;
use common\models\finance\Soa;
use common\models\finance\Billing;
use yii\data\ActiveDataProvider;

class BillingController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionManager(){
        $searchModel = new SoaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/soa/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionSoa(){
        $searchModel = new SoaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('../soa/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single client model.
     * @param integer $id
     * @return mixed
     */
    public function actionClientview($id)
    {
        $model = Client::find()->where(['client_id'=>$id])->one();
        if(\Yii::$app->request->isAjax){
            return $this->renderAjax('client/view', [
                'model' => $model,
            ]);
        }else{
            return $this->render('client/view', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionClientupdate($id)
    {
        $model = Client::find()->where(['client_id'=>$id])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/finance/billing/client']);
        } else {
            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('client/update', [
                    'model' => $model,
                ]);
            }else{
                 return $this->render('client/update', [
                    'model' => $model,
                ]);
            }
        }
    }
    public function actionClientdelete($id){
        $model = Client::findOne($id);
        $model->delete();
        return $this->redirect(['/finance/billing/client']);
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
            }else{
                return $this->render('client/create', [
                    'model' => $model,
                ]);
            }
        }
    }
    public function actionClient(){
        //echo str_pad(11, 3,'0',STR_PAD_LEFT);
        //exit;
        $model=new Client();
        $searchModel = new clientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('client/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model
        ]);
    }
    public function actionUpdate(){
        echo "Update Billing";
    }
    public function actionCreate(){
        echo "Create Billing";
    }
    public function actionInvoices(){
        $model = new Op();
        $searchModel = new BillingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('invoices/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    public function actionAr(){
        return $this->render('ar');
    }
    public function actionReports(){
        return $this->render('reports');
    }
}
