<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Analysisextend;
use common\models\lab\AnalysisreferralSearch;
use common\models\lab\Request;
use common\models\lab\Sample;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use linslin\yii2\curl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\ActiveQuery;

/**
 * AnalysisreferralController implements the CRUD actions for Analysis model.
 */
class AnalysisreferralController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all Analysis models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnalysisreferralSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Analysis model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Analysis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Analysisextend();

        if(Yii::$app->request->get('request_id'))
        {
            $requestId = (int) Yii::$app->request->get('request_id');
        }

        $query = Sample::find()->where('request_id = :requestId', [':requestId' => $requestId]);
        
        $sampleDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        //$sampleDataProvider->sort = false;
        //$sampleDataProvider->pagination->pageSize=1;

        $request = $this->findRequest($requestId);
        $labId = $request->lab_id;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        //$sampletype = $this->listSampletypereferral($labId);
        //$samples = $this->listSample($requestId);
        $testname = $this->listsampletypereferrals($requestId);



        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->analysis_id]);

        } elseif (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
                'testname' => $testname,
                'labId' => $labId,
                'sampleDataProvider' => $sampleDataProvider,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'testname' => $testname,
                'labId' => $labId,
                'sampleDataProvider' => $sampleDataProvider,
            ]);
        }
    }

    /**
     * Updates an existing Analysis model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->analysis_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Analysis model.
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
     * Finds the Analysis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Analysis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Analysis::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findRequest($requestId)
    {
        if (($model = Request::findOne($requestId)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    //get referral sample type list
    protected function listSampletypereferral($labId)
    {
        //$apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/labsampletypebylab?lab_id='.$labId;
        $apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/sampletypebylab?lab_id='.$labId;
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);

        $data = ArrayHelper::map(json_decode($list), 'sampletype_id', 'type');
        
        return $data;
    }

    //get referral sample type list
    protected function listsampletypereferrals($requestId)
    {
        $sample = Sample::find()
                    ->select('sampletype_id')
                    //->joinWith('labSampletypes')
                    //->where(['tbl_labsampletype.lab_id' => $labId])
                    ->where('request_id = :requestId', [':requestId' => $requestId])
                    ->groupBy('sampletype_id')
                    ->asArray()->all();


         /*$data = (new \yii\db\Query())
            ->from('eulims_referral_lab.tbl_sampletypetestname')
            ->join('INNER JOIN', 'eulims_referral_lab.tbl_testname', 'tbl_sampletypetestname.testname_id = tbl_testname.testname_id')
            ->where([
                'sampletype_id' => [1,2],
            ])
            //->where('sampletype_id=:sampletypeId', [':sampletype_id' => [1,2]])
            ->orderBy('sampletype_id,tbl_sampletypetestname.testname_id')
            //->asArray()
            ->all();*/


        //$apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/labsampletypebylab?lab_id='.$labId;
        //$apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/sampletypebylab?lab_id='.$labId;
        //$curl = new curl\Curl();
        //$list = $curl->get($apiUrl);

        //$data = ArrayHelper::map(json_decode($list), 'sampletype_id', 'type');
        
        //return $data;

        //$datas = implode(',',$data);

        $sampletypeId = implode(',', array_map(function ($data) {
            return $data['sampletype_id'];
        }, $sample));

        //echo $a;

        $apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/testnamebysampletype?sampletype_id='.$sampletypeId;
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);

        $data = ArrayHelper::map(json_decode($list), 'testname_id', 'test_name');
        
        return $data;

        //echo "<pre>";
        //print_r($list);
        //echo $datas;
        //echo "</pre>";
    }
    
    //get referral sample type list by sampletype_id
    public function actionReferraltestname()
    {

        if(Yii::$app->request->get('sampletype_id'))
        {
            //$sampletypeId = (int) Yii::$app->request->get('sampletype_id');
            //$sampletypeId = json_encode(Yii::$app->request->get('sampletype_id'));
            if(count(Yii::$app->request->get('sampletype_id'))>1){
                //Yii::$app->request->get('sampletype_id')
                $sampletypeId = implode(",",Yii::$app->request->get('sampletype_id'));
            } else {
                $sampletypeId = (int) Yii::$app->request->get('sampletype_id');
            }
        }
        //$apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/labsampletypebylab?lab_id='.$labId;
        $apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/testnamebysampletype?sampletype_id='.$sampletypeId;
        $curl = new curl\Curl();
        $list = $curl->get($apiUrl);

        $data = ArrayHelper::map(json_decode($list), 'testname_id', 'test_name');
        
        return $data;

        //echo "<pre>";
        //print_r(json_decode($list));
        //echo "</pre>";
    }

    public function actionGetreferraltestname() {

        if(Yii::$app->request->get('sample_id'))
        {
            /*if(count(Yii::$app->request->get('sample_id'))>1){
                //Yii::$app->request->get('sampletype_id')
                $sampleId = implode(",",Yii::$app->request->get('sample_id'));

                $sample = Sample::find()
                    ->select('sampletype_id')
                    //->joinWith('labSampletypes')
                    //->where(['tbl_labsampletype.lab_id' => $labId])
                    //->where('request_id = :requestId', [':requestId' => $requestId])
                    ->where('sample_id = :sampleId', [':sampleId' => $sampleId])
                    ->groupBy('sampletype_id')
                    ->asArray()->all();

                $sampletypeId = implode(', ', array_map(function ($data) {
 
                    return $data['sampletype_id'];
                     
                }, $sample));

            } else {
                $sampletypeId = Yii::$app->request->get('sample_id');
            }*/

            //$sampleId = Yii::$app->request->get('sample_id');
            //$sampleId = implode(",",Yii::$app->request->get('sample_id'));
            $sampleId = explode(",",Yii::$app->request->get('sample_id'));
            /*
            //only single record
            $sample = Sample::find()
                ->select('sampletype_id')
                //->joinWith('labSampletypes')
                //->where(['tbl_labsampletype.lab_id' => $labId])
                //->where('request_id = :requestId', [':requestId' => $requestId])
                ->where('sample_id = :sampleId', [':sampleId' => $sampleId])
                //->where(['in',['sample_id'],[['sample_id' => $sampleId],]])
                ->groupBy('sampletype_id')
                ->asArray()
                ->all();
            */
            $sample = (new Query)
                ->select('sampletype_id')
                ->from('eulims_lab.tbl_sample')
                //->join('INNER JOIN', 'eulims_referral_lab.tbl_testname', 'tbl_sampletypetestname.testname_id = tbl_testname.testname_id')
                ->where([
                    //'sampletype_id' => [1,2],
                    'sample_id' => $sampleId,
                ])
                //->where('sampletype_id=:sampletypeId', [':sampletype_id' => [1,2]])
                //->groupBy('tbl_testname.testname_id')
                //->orderBy('sampletype_id,tbl_sampletypetestname.testname_id')
                ->groupBy('sampletype_id')
                //->orderBy('tbl_sampletypetestname.testname_id')
                //->asArray()
                ->all();

            $sampletypeId = implode(',', array_map(function ($data) {
                return $data['sampletype_id'];
            }, $sample));

            $apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/testnamebysampletype?sampletype_id='.$sampletypeId;
            $curl = new curl\Curl();
            $lists = $curl->get($apiUrl);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if(count($lists)>0)
            {
                //$data = json_decode($list);
                //$data = ArrayHelper::map(json_decode($list), 'testname_id', 'test_name');
                //echo "<option value='' selected></option>";
                /*    foreach($data as $value=>$testname){
                        echo CHtml::tag('option', array('value'=>$value),
                            CHtml::encode($testname),true);
                    }*/
               // echo 'gg';
                //$clientCodes = ClientCode::find()->andWhere(['client_id' => $id])->all();
                //$data = [['id' => '', 'text' => '']];
                foreach(json_decode($lists) as $list) {
                    $data[] = ['id' => $list->testname_id, 'text' => $list->test_name];
                }
                //print_r($lists);
            } else {
                //$data = null;
                $data = [['id' => '', 'text' => 'No results found']];
            }
            //$data =  $data;
            //echo "<pre>";
            //print_r($sampletypeId);
            //echo "</pre>";
        } else {
            //$data = Json::encode(["error"=>"No sample selected."]);
            $data = 'No sample selected.';
        }
        //return $data;
        //return json_encode();
        return ['data' => $data];
    }
}
