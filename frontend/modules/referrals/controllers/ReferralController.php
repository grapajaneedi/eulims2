<?php

namespace frontend\modules\referrals\controllers;

use Yii;
use common\models\referral\Referral;
use common\models\referral\ReferralSearch;
use common\models\lab\Referralrequest;
use yii\web\Controller;
//use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use linslin\yii2\curl;
use common\models\lab\exRequestreferral;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\models\lab\Request;
use common\models\lab\Analysis;
use common\models\lab\Sample;

/**
 * ReferralController implements the CRUD actions for Referral model.
 */
class ReferralController extends Controller
{
    /**
     * {@inheritdoc}
     */
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/

    /**
     * Lists all Referral models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReferralSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Referral model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
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

        $request_type = $this->findModel($id)->request_type_id;

        $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
        
        $samples = Sample::find()->where(['request_id' => $id])->all();
        
        $sample_ids = '';
        foreach ($samples as $sample){
            $sample_ids .= $sample->sample_id.",";
        }
        $sample_ids = substr($sample_ids, 0, strlen($sample_ids)-1);
       
        if ($sample_ids){
            $ids = explode(",", $sample_ids);   
        }else{
            $ids = ['-1'];
        }
        
        $analysisQuery = Analysis::find()
        ->where(['IN', 'sample_id', $ids]);

      //  $analysisQuery = Analysis::find()->where(['sample_id' =>$samples->sample_id]);
        if($request_type == 2) {
            $refcomponent = new ReferralComponent();
            $modelref_request = Referralrequest::find()->where(['request_id'=>$id])->one();

            $analysisdataprovider = new ActiveDataProvider([
                'query' => $analysisQuery,
                'pagination' => [
                    'pageSize' => 10,
                ]
            ]);

            $agency = Json::decode($refcomponent->listMatchAgency($id));

            $agencydataprovider = new ArrayDataProvider([
                'allModels' => $agency,
                'pagination'=>false,
            ]);
            /*echo "<pre>";
            print_r($agency);
            echo "</pre>";
            exit;*/
        } else {
            $analysisdataprovider = new ActiveDataProvider([
                'query' => $analysisQuery,
                'pagination' =>false,
            ]);
        }
        
        if(\Yii::$app->user->can('view-all-rstl')){
            $model=exRequest::findOne($id);
        }else{
            $model=$this->findRequest($id);
        }

        if($request_type == 2){
            return $this->render('viewreferral', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'analysisdataprovider'=> $analysisdataprovider,
                'agencydataprovider'=> $agencydataprovider,
                'modelref_request'=>$modelref_request,
            ]);

        } else {
            return $this->render('view', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'analysisdataprovider'=> $analysisdataprovider,
            ]);
        }
    }

    /**
     * Creates a new Referral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Referral();

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //    return $this->redirect(['view', 'id' => $model->referral_id]);
        //}

        if ($model->load(Yii::$app->request->post())) {
            /*if(isset($_POST['Sample']['sampling_date'])){
                $model->sampling_date = date('Y-m-d H:i:s', strtotime($_POST['Sample']['sampling_date']));
            } else {
                $model->sampling_date = date('Y-m-d H:i:s');
            }*/
            $model->referral_date = '0000-00-00';
            $model->referral_time = '';

            if($model->save(false)){
                Yii::$app->session->setFlash('success', $model->samplename." Successfully Updated.");
                return $this->redirect(['/lab/request/view', 'id' => $model->request_id]);

            }
        } elseif (Yii::$app->request->isAjax) {
                return $this->renderAjax('_form', [
                    'model' => $model,
                    //'testcategory' => $testcategory,
                    //'sampletype' => $sampletype,
                    //'labId' => $labId,
                    //'sampletemplate' => $this->listSampletemplate(),
                ]);
        } else {
            return $this->render('update', [
                'model' => $model,
                //'testcategory' => $testcategory,
                //'sampletype' => $sampletype,
                //'labId' => $labId,
                //'sampletemplate' => $this->listSampletemplate(),
            ]);
        }

        //return $this->render('create', [
        //    'model' => $model,
        //]);
    }

    /**
     * Updates an existing Referral model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->referral_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Referral model.
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

    /**
     * Finds the Referral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Referral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Referral::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionNotify()
	{
        $sample_data = [];
        $analysis_data = [];
        if(Yii::$app->request->get('request_id')){
            $requestId = (int) Yii::$app->request->get('request_id');
        } else {
            Yii::$app->session->setFlash('error', "Request ID not valid!");
            //delay for 2 seconds, before executing next line of code
            sleep(2);
            return $this->redirect(['/lab/request']);
        }
        $request = exRequestreferral::find()->where(['request_id'=>$requestId,'request_type_id'=>2])->asArray()->one();
       //$request = exRequestreferral::find()->joinWith(['samples.analyses'])->where(['tbl_request.request_id'=>$requestId,'request_type_id'=>2])->asArray()->all();
        $ref_request = Referralrequest::find()->where('request_id =:requestId',[':requestId'=>$requestId])->one();
        //$sample = $this->findSample($requestId);
        $samples = Sample::find()->where(['request_id'=>$requestId])->asArray()->all();
        //$analysis = $this->findAnalysis($requestId);
        //$analysis = Analysis::find()->joinWith('sample')->where(['tbl_sample.request_id'=>$requestId])->asArray()->all();
        $analyses = Analysis::find()->where(['request_id'=>$requestId])->asArray()->all();

        $agency_id = (int) Yii::$app->request->get('agency_id');

        if($agency_id > 0){
            if(count($request) > 0 && count($ref_request) > 0 && count($samples) > 0 && count($analyses) > 0)
            {
                //check if each sample contains at least one analysis
                $checkWithAnalysis = $this->checkWithAnalysis($requestId);
                if(count($samples) != $checkWithAnalysis){
                    return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Notification Fail: Make sure a sample contains at least one analysis.</div>";
                } else {
                    $requestData = [
                        'request_id' => $request['request_id'],
                        //'request_ref_num' => $request->request_ref_num,
                        'request_datetime' => $request['request_datetime'],
                        'rstl_id' => $request['rstl_id'],
                        'lab_id' => $request['lab_id'],
                        'customer_id' => $request['customer_id'],
                        'payment_type_id' => $request['payment_type_id'],
                        'modeofrelease_ids' => $request['modeofrelease_ids'],
                        'discount_id' => $request['discount_id'],
                        'discount' => $request['discount'],
                        'purpose_id' => $request['purpose_id'],
                        'total' => $request['total'],
                        'report_due' => $request['report_due'],
                        'conforme' => $request['conforme'],
                        'receivedBy' => $request['receivedBy'],
                        'status_id' => $request['status_id'],
                        'request_type_id' => $request['request_type_id'],
                        'created_at' => $request['created_at'],
                        'sample_received_date' => $ref_request['sample_received_date'],
                        'user_id' => 1,
                        'bid'=>0
                    ];

                    foreach ($samples as $sample) {
                        $sampleData = [
                            'sample_id' => $sample['sample_id'],
                            'rstl_id' => $sample['rstl_id'],
                            'package_id' => $sample['package_id'],
                            'package_rate' => $sample['package_rate'],
                            'sampletype_id' => $sample['sampletype_id'],
                            'sample_code' => $sample['sample_code'],
                            'samplename' => $sample['samplename'],
                            'description' => $sample['description'],
                            'sampling_date' => $sample['sampling_date'],
                            'remarks' => $sample['remarks'],
                            'request_id' => $sample['request_id'],
                            'sample_month' => $sample['sample_month'],
                            'sample_year' => $sample['sample_year'],
                            'active' => $sample['active'],
                            'completed' => $sample['completed']
                        ];
                        array_push($sample_data, $sampleData);
                    }

                    foreach ($analyses as $analysis) {
                        $analysisData = [
                            'analysis_id' => $analysis['analysis_id'],
                            'date_analysis' => $analysis['date_analysis'],
                            'rstl_id' => $analysis['rstl_id'],
                            'request_id' => $analysis['request_id'],
                            'sample_id' => $analysis['sample_id'],
                            'sample_code' => $analysis['sample_code'],
                            'testname' => $analysis['testname'],
                            'method' => $analysis['method'],
                            'methodref_id' => $analysis['methodref_id'],
                            'references' => $analysis['references'],
                            'fee' => $analysis['fee'],
                            'test_id' => $analysis['test_id'],
                            'cancelled' => $analysis['cancelled'],
                            'is_package' => $analysis['is_package'],
                            'type_fee_id' => $analysis['type_fee_id']
                        ];
                        array_push($analysis_data, $analysisData);
                    }

                    $data = Json::encode(['request_data'=>$requestData,'sample_data'=>$sample_data,'analysis_data'=>$analysis_data,'agency_id'=>$agency_id],JSON_NUMERIC_CHECK);

                    $referralUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/referrals/insertreferraldata';
                   
                    $curl = new curl\Curl();
                    $referralreturn = $curl->setRequestBody($data)
                    ->setHeaders([
                        'Content-Type' => 'application/json',
                        'Content-Length' => strlen($data),
                    ])->post($referralUrl);

                    //print_r($referralreturn);
                    //exit;

                    $referralResponse = Json::decode($referralreturn);
                    switch ($referralResponse['response']) {
                        case 0:
                            return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Fail to save referral details.</div>";
                            break;
                        case 1 :
                            //return "Referral details saved.";
                            goto notify;
                            break;
                        case 2:
                            return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;No data to be saved.</div>";
                            break;
                        case 3:
                            //return "Referral details already existing.";
                            goto notify;
                            break;
                        //function to send notification
                        notify: {

                            $mi = (!empty(Yii::$app->user->identity->profile->firstname)) ? " ".substr(Yii::$app->user->identity->profile->middleinitial, 0, 1).". " : " "; 

                            $senderName = Yii::$app->user->identity->profile->firstname.$mi.Yii::$app->user->identity->profile->lastname;

                            $details = [
                                'referral_id' => $referralResponse['referral_id'],
                                'sender_id' => Yii::$app->user->identity->profile->rstl_id,
                                'recipient_id' => $agency_id,
                                'sender_name' => $senderName,
                                'remarks' => "sample remarks"
                            ];
                            $notificationData = Json::encode(['notice_details'=>$details],JSON_NUMERIC_CHECK);

                            $notificationUrl ='http://localhost/eulimsapi.onelab.ph/api/web/referral/notifications/notify';

                            $curlNoti = new curl\Curl();
                            $notificationResponse = $curlNoti->setRequestBody($notificationData)
                            ->setHeaders([
                                'Content-Type' => 'application/json',
                                'Content-Length' => strlen($notificationData),
                            ])->post($notificationUrl);

                            if($notificationResponse > 0){
                                if($ref_request->notified == 0){
                                    //echo 'Notification sent.';
                                    $modelref_request = Referralrequest::find()->where(['request_id'=>$requestId])->one();
                                    $modelref_request->notified = 1;
                                    if($modelref_request->save()){
                                        Yii::$app->session->setFlash('success', "Notification sent");
                                        //delay for 2 seconds, before executing next line of code
                                        sleep(2);
                                        return $this->redirect(['/lab/request/view', 'id' => $requestId]);
                                        //header("refresh:2;url=/lab/request/view?id=".$requestId);
                                        //echo 'Notification sent.';
                                    } else {
                                       return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Notification Fail: Error occured when saving!</div>";
                                    }
                                } else {
                                    //return 'Notification sent.';
                                    Yii::$app->session->setFlash('success', "Notification sent");
                                    //delay for 2 seconds, before executing next line of code
                                    sleep(2);
                                    return $this->redirect(['/lab/request/view', 'id' => $requestId]);
                                    //echo 'Notification sent.';
                                    //header("refresh:2;url=/lab/request/view?id=".$requestId);
                                }
                            } else {
                                return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;Server Error: Notification fail!</div>";
                            }
                        }
                    }
                }
            } else {
                return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;No data to be posted!</div>";
            }
        } else {
            return "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' style='font-size:18px;'></span>&nbsp;No agency to be notified!</div>";
        }
	}

    //find referral request
    protected function findRequest($id)
    {
        $model = exRequestreferral::find()->where(['request_id'=>$id,'request_type_id'=>2])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested Request its either does not exist or you have no permission to view it.');
        }
    }

    //check if sample has at least one analysis
    protected function checkWithAnalysis($requestId)
    {
        /*SELECT tbl_sample.sample_id, COUNT(tbl_analysis.`analysis_id`) AS 'analysisCount' -- , tbl_sample.`sample_id`
        FROM tbl_sample LEFT JOIN tbl_analysis 
        ON tbl_sample.`sample_id` = tbl_analysis.`sample_id`
        WHERE tbl_sample.`request_id` = 23
        GROUP BY tbl_sample.sample_id
        HAVING analysisCount > 0*/

        /*$analyses = Sample::find()
            ->select('tbl_sample.`sample_id`,count(tbl_analysis.`analysis_id`) as analysiscount')
            ->joinWith('analyses')
            ->where('tbl_sample.`request_id` =:requestId',[':requestId'=>$requestId])
            ->groupBy('tbl_sample.`sample_id`')
            ->all();*/
        /*$connection = Yii::$app->labdb;
        $analyses = $connection->createCommand(
                (new \yii\db\Query())
                    ->select('tbl_sample.`sample_id`,count(tbl_analysis.`analysis_id`) as analysiscount')
                    ->from('tbl_sample')
                    ->join('LEFT JOIN','tbl_analysis', 'tbl_sample.`sample_id` = tbl_analysis.`sample_id`')
                    //->where()
                    ->where(['tbl_sample.`request_id`'=>$requestId])
                    ->groupBy('tbl_sample.`sample_id`')
                )->queryAll();*/
        $analyses = Yii::$app->labdb->createCommand("
                    SELECT tbl_sample.sample_id, COUNT(tbl_analysis.`analysis_id`) AS 'analysisCount'
                    FROM tbl_sample LEFT JOIN tbl_analysis 
                    ON tbl_sample.`sample_id` = tbl_analysis.`sample_id`
                    WHERE tbl_sample.`request_id` =:requestId
                    GROUP BY tbl_sample.sample_id
                    HAVING analysisCount > 0")
                ->bindParam(':requestId', $requestId)->queryAll();
        return count($analyses);
    }

    /*
    //find samples
    protected function findSample($requestId)
    {
        $model = Sample::find()->where(['request_id'=>$requestId])->all();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested Request its either does not exist or you have no permission to view it.');
        }
    }

    //find analysis
    protected function findAnalysis($requestId)
    {
        $model = Analysis::find()->joinWith('sample')->where(['tbl_sample.request_id'=>$requestId])->all();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested Request its either does not exist or you have no permission to view it.');
        }
    }

    //find user details
    protected function findAgenyOffer($referralId)
    {
        $model = Analysis::find()->joinWith('sample')->where(['tbl_sample.request_id'=>$requestId])->all();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested Request its either does not exist or you have no permission to view it.');
        }
    }
    */

}
