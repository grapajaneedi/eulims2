<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Request;
use common\models\lab\Discount;
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
use yii\helpers\Url;
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
                    'delete' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Request models.
     * @return mixedfmkldcwnkldsnkdnfklnwfkwldnfdkwflnddnfwkdlnfdlwknclkwnxlkwcnwdlkdnkdnklewdnklewdnklewdnlkew
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
        $analysisQuery = Analysis::find()->where(['request_id' => $id]);
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

       if(isset($_GET['request_id'])){
        $id = $_GET['request_id'];
        $mpdf = new \Mpdf\Mpdf([
            'format' => [35,66], 
            'orientation' => 'L',
        ]);
    
        $request = Request::find()->where(['request_id' => $id]);
        $samplesquery = Sample::find()->where(['request_id' => $id])->all();

        

        $requestquery = Request::find()->where(['request_id' => $id])->one();
        
        foreach ($samplesquery as $sample) {
            $limitreceived_date = substr($requestquery['request_datetime'], 0,10);
            $mpdf->AddPage('','','','','',0,0,0,0);
            $samplecode = '<font size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$sample['sample_code']."</b>&nbsp;&nbsp;".$sample['samplename'].
            '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="1"><b>Received:&nbsp;&nbsp;</b>'.$limitreceived_date.'&nbsp;&nbsp;<b>Due:&nbsp;&nbsp;</b>'.$requestquery['report_due'];
        
            $mpdf->WriteHTML("<barcode code=".$sample['sample_code']." type='C39' />");
            $mpdf->WriteHTML($samplecode);

            $text = '<font size="5">WI-003-F1';
            $text2 = '<font size="5"><b>Rev 03/03.01.18<b>';

            $i = 1;
            $analysisquery = Analysis::find()->where(['sample_id' => $sample['sample_id']])->all();
                   foreach ($analysisquery as $analysis){
                        $mpdf->WriteHTML("&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>".$analysis['testname']."</font>");

                        if ($i++ == 3)
                        break;
                   }               
            }          
            $mpdf->Output();
       }
    }

    public function actionTest($id){
        $Func=new Functions();
        $response=$Func->GenerateSampleCode($id);
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

        //UPDATE FEE

        $requestquery = Request::find()->where(['request_id' => $request_id])->one();
        $discountquery = Discount::find()->where(['discount_id' => $requestquery->discount_id])->one();

        $rate =  $discountquery->rate;
        
        $sql = "SELECT SUM(fee) as subtotal FROM tbl_analysis WHERE request_id=$request_id";
        $Connection = Yii::$app->labdb;
        $command = $Connection->createCommand($sql);
        $row = $command->queryOne();
        $subtotal = $row['subtotal'];
        $total = $subtotal - ($subtotal * ($rate/100));

        $Connection= Yii::$app->labdb;
        $sql="UPDATE `tbl_request` SET `total`='$total' WHERE `request_id`=".$request_id;
        $Command=$Connection->createCommand($sql);
        $Command->execute();


        $Request->request_ref_num=$ReferenceNumber;
        if($Request->save()){
            $Transaction->commit();
            $Func=new Functions();
            $response=$Func->GenerateSampleCode($request_id);
            if($response){
                $return="Success";
                Yii::$app->session->setFlash('success', 'Request Ref #/Sample Code Successfully Generated!');
            }else{
                $Transaction->rollback();
                Yii::$app->session->setFlash('danger', 'Request Ref #/Sample Code Failed to Generate!');
                $return="Failed";
            }
        }else{
            Yii::$app->session->setFlash('danger', 'Request Ref #/Sample Code Failed to Generate!');
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
        /*echo "<pre>";
        print_r(Yii::$app->request->post());
        echo "</pre>";
        exit;
         * 
         */
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Request Successfully Created!');
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
            $model->request_type_id=1;
            $model->modeofreleaseids='1';
            if($profile){
                $model->receivedBy=$profile->firstname.' '. strtoupper(substr($profile->middleinitial,0,1)).'. '.$profile->lastname;
            }else{
                $model->receivedBy="";
            }
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
            Yii::$app->session->setFlash('success', 'Request Successfully Updated!');
            return $this->redirect(['view', 'id' => $model->request_id]);
        } else {
            if($model->request_ref_num){
                $model->request_ref_num=NULL;
            }
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
        $Request=$this->findModel($id);
        if($Request){//Success
            $Request->status_id=2;
            $ret=$Request->save();
        }else{
            $ret=false;
        }
        return $ret;
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
