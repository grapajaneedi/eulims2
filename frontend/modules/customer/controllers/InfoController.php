<?php

namespace frontend\modules\customer\controllers;

use Yii;
use common\models\lab\Customer;
use common\models\lab\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * InfoController implements the CRUD actions for Customer model.
 */
class InfoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    //'getprovince' => ['POST'],
                    'getmunicipality' => ['POST'],
                    'getbarangay' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();
        $model->rstl_id=11;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $session = Yii::$app->session;
            $session->set('savepopup',"executed");
            // return $this->redirect(['view', 'id' => $model->customer_id]);
            return $this->redirect(['index']);
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // if(Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                 $session = Yii::$app->session;
                $session->set('savepopup',"executed");
               return $this->redirect(['index']);
            }   


            if(Yii::$app->request->isAjax){
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }
            else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        // }
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetprovince(){

        $data = array('NA'=>'Not Applicable');

        //append blank
         // echo Html::tag('option', array('value'=>''),Html::encode(null),true);
        echo Html::tag('option', Html::encode('fdgdfbd'), ['value' => 'sdfgdg']);
        // foreach($data as $value=>$name)
        // {
            // echo Html::tag('option',
                       // array('value'=>$value),Html::encode($name),true);
            // echo Html::tag('option',
                       // Html::encode($name),Html::encode($name),true);
        // }

    }

    public function actionGetmunicipality(){
        echo "something";
    }

    public function actionGetbarangay(){
        echo "something";
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
