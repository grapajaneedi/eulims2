<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Request;
use common\models\lab\Analysis;
use common\models\lab\AnalysisSearch;
use common\models\lab\RequestSearch;
use common\models\lab\Requestcode;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\lab\Sample;
use yii\db\Query;
use common\models\lab\Customer;
use DateTime;
use common\models\system\Profile;
use common\components\Functions;
use linslin\yii2\curl\Curl;
use kartik\mpdf\Pdf;
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
        $dataProvider->pagination->pageSize=10;
        $samplesQuery = Sample::find()->where(['request_id' => $id]);
        $sampleDataProvider = new ActiveDataProvider([
                'query' => $samplesQuery,
                'pagination' => [
                    'pageSize' => 10,
                ],
             
        ]);

        $analysisQuery = Analysis::find()->where(['sample_id' => 1]);
        $analysisdataprovider = new ActiveDataProvider([
                'query' => $analysisQuery,
                'pagination' => [
                    'pageSize' => 10,
                ],
             
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sampleDataProvider' => $sampleDataProvider,
            'analysisdataprovider'=> $analysisdataprovider,
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
    public function actionPdf(){
        $pdf=new \common\components\MyPDF();
        $Content="<button>Click me</button>";

        $pdf->renderPDF($Content,NULL,NULL,['orientation'=> Pdf::ORIENT_LANDSCAPE]);

        
    }

    public function actionPrintlabel(){
       // $pdf=new \common\components\MyPDF();

       if(isset($_GET['request_id'])){

        $id = $_GET['request_id'];

        $pdf = new Pdf();

        $pdf->format=[66,35];
        $pdf->marginBottom=0;
        $pdf->marginLeft=0;
        $pdf->marginRight=0;
        $pdf->marginTop=0;

        $requestQuery = Request::find()->where(['request_id' => $id]);

        $Content= $this->renderPartial('_printlabel', ['requestQuery' => $requestQuery]);
        $pdf->content = $Content;
        $pdf->render($Content);
       }
    }

    public function actionTest($id){
        $Func=new Functions();
        $response=$Func->GenerateSampleCode(12);
        echo $response;
    }
    public function actionSaverequestransaction(){
        $post= Yii::$app->request->post();
        // echo $post['request_id'];
        //exit;
        $return="Failed";
        $request_id=(int) $post['request_id'];
        $lab_id=(int) $post['lab_id'];
        $rstl_id=(int) $post['rstl_id'];
        $year=(int) $post['year'];
        // Generate Reference Number
        $func=new Functions();
        $Proc="spGetNextGeneratedRequestSampleCode(:RSTLID,:LabID)";
        $Params=[
            ':RSTLID'=>$rstl_id,
            ':LabID'=>$lab_id
        ];
        $Connection= Yii::$app->labdb;
        $Transaction =$Connection->beginTransaction();
        $Row=$func->ExecuteStoredProcedureOne($Proc, $Params, $Connection);
        $ReferenceNumber=$Row['GeneratedRequestCode'];
        $RequestIncrement=$Row['RequestIncrement'];
        //Update the tbl_requestcode
        $Requestcode= Requestcode::find()->where([
            'rstl_id'=>$rstl_id,
            'lab_id'=>$lab_id,
            'year'=>$year
        ])->one($Connection);
        if(!$Requestcode){
            $Requestcode=new Requestcode();
        }
        $Requestcode->request_ref_num=$ReferenceNumber;
        $Requestcode->rstl_id=$rstl_id;
        $Requestcode->lab_id=$lab_id;
        $Requestcode->number=$RequestIncrement;
        $Requestcode->year=$year;
        $Requestcode->cancelled=0;
        $Requestcode->save();
        //Update tbl_request table
        $Request= Request::find()->where(['request_id'=>$request_id])->one($Connection);
        $Request->request_ref_num=$ReferenceNumber;
        if($Request->save()){
            $Transaction->commit();
            $Func=new Functions();
            $response=$Func->GenerateSampleCode($Request->request_id);
            if($response){
                $return="Success";
            }else{
                $Transaction->rollback();
                $return="Failed";
            }
        }else{
            $Transaction->rollback();
            $return="Failed";
        }
        return $return;
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
                return $this->renderAjax('create', [
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
