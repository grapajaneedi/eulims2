<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Request;
use common\models\lab\RequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\lab\Sample;
use yii\db\Query;
use common\models\lab\Customer;
use DateTime;
use common\models\system\Profile;

/**
 * RequestController implements the CRUD actions for Request model.
 */
class RequestController extends Controller
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
     * Lists all Request models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=6;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Request model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $samplesQuery = Sample::find()->where(['request_id' => $id]);
        $sampleDataProvider = new ActiveDataProvider([
                'query' => $samplesQuery,
                'pagination' => [
                    'pageSize' => 10,
                ],
             
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sampleDataProvider' => $sampleDataProvider,
        ]);
    }
    public function actionCustomerlist($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('customer_id as id, customer_name AS text')
                    ->from('tbl_customer')
                    ->where(['like', 'customer_name', $q])
                    ->limit(20);
            $command = $query->createCommand();
            $command->db= \Yii::$app->labdb;
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' =>Customer::find()->where(['customer_id'=>$id])->customer_name];
        }
        return $out;
    }

    /**
     * Creates a new Request model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Request();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->request_id]); ///lab/request/view?id=1
        } else {
            $date = new DateTime();
            $date2 = new DateTime();
            $profile= Profile::find()->where(['user_id'=> Yii::$app->user->id])->one();
            date_add($date2,date_interval_create_from_date_string("1 day"));
            $model->request_datetime=date("Y-m-d h:i:s");
            $model->report_due=date_format($date2,"Y-m-d");
            $model->created_at=date('U');
            $model->rstl_id= $GLOBALS['rstl_id'];
            $model->payment_type_id=1;
            $model->modeofrelease_ids='1';
            $model->discount_id=0;
            $model->discount='0.00';
            $model->total=0.00;
            $model->posted=0;
            $model->status_id=1;
            $model->receivedBy=$profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Request model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->request_id]);
        } else {
            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Request model.
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
     * Finds the Request model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Request the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Request::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //bergel cutara
    //contacted by function to return result to be displayed in select2
    public function actionRequestlist($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('request_id as id, request_ref_num AS text')
                    ->from('tbl_request')
                    ->where(['like', 'request_ref_num', $q])
                    ->limit(20);
            $command = $query->createCommand();
            $command->db= \Yii::$app->labdb;
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' =>Request::find()->where(['request_id'=>$id])->request_ref_num];
        }
        return $out;
    }
}
