<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Orderofpayment;
use common\models\finance\OrderofpaymentSearch;
use common\models\lab\Request;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
/**
 * OrderofpaymentController implements the CRUD actions for Orderofpayment model.
 */
class OrderofpaymentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Orderofpayment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Orderofpayment();
        $searchModel = new OrderofpaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Orderofpayment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]);
        }
        else{  
           return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Orderofpayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orderofpayment();
        $searchModel = new OrderofpaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=5;
        
         if ($model->load(Yii::$app->request->post())) {
           //return $this->redirect(['view', 'id' => $model->orderofpayment_id]);
            //return $this->runAction('index');
          if($model->validate() && $model->save()){
                $session = Yii::$app->session;
                $model->rstl_id=1;
                $model->transactionnum='123456';
                $model->save();
                $session->set('savepopup',"executed");
                return $this->redirect(['/finance/orderofpayment']);
          }
           
        } 
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->render('create', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        
    }

    /**
     * Updates an existing Orderofpayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->orderofpayment_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

     public function actionGetlistrequest()
    {
        $post=Yii::$app->request->post();
        $customer_id=$post['customer_id'];
        $query = Request::find()->where(['customer_id' => $customer_id]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         return $this->renderPartial('_request', ['dataProvider'=>$dataProvider]);

    }
    /**
     * Deletes an existing Orderofpayment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orderofpayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orderofpayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orderofpayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
