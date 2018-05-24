<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Sample;
use common\models\lab\SampleSearch;
use common\models\lab\Sampletype;
use common\models\lab\Testcategory;
use common\models\lab\Request;
use common\models\lab\Lab;
use common\models\lab\Samplecode;
use common\models\lab\SampleName;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Response;
use kartik\mpdf\Pdf;
use yii\db\ActiveQuery;

/**
 * SampleController implements the CRUD actions for Sample model.
 */
class SampleController extends Controller
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

    public function actionPrintlabel(){

            $mPDF = new Pdf();
            $mPDF->content=$this->renderPartial('printlabel/_form');
            $mPDF->orientation=Pdf::ORIENT_PORTRAIT;
            $mPDF->marginLeft=1.0;
            $mPDF->marginRight=1.0;
            $mPDF->marginTop=0;
            $mPDF->marginBottom=0.5;
            $mPDF->format=[66,35]; //Customed Sizes
            $mPDF->destination= Pdf::DEST_BROWSER;
            //$Footer="<barcode code='$ORNumber' type='C39' size='1.5' height='0.5'/>";
          
            $mPDF->render();
            exit;
       
    }

    /**
     * Lists all Sample models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SampleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /*$dataProvider = new ActiveDataProvider([
            //'query' => $searchModel->search(Yii::$app->request->queryParams),
            'query' =>$searchModel,
            'pagination' => [
                'pagesize' => 10,
            ],
        ]);*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sample model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new SampleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->sort->sortParam = false;

        return $this->render('view', [
            'model' => $this->findModel($id),
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Creates a new Sample model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sample();

        /*if(isset($_GET['lab_id']))
        {
            $labId = (int) $_GET['lab_id'];
        } else {
            $labId = 2;
        }*/
        $session = Yii::$app->session;
        //$req = Yii::$app->request;

        if(Yii::$app->request->get('request_id'))
        {
            $requestId = (int) Yii::$app->request->get('request_id');
        }
        $request = $this->findRequest($requestId);
        $labId = $request->lab_id;

        $testcategory = $this->listTestcategory($labId);
        //$sampletype = $this->listSampletype();
        /*$testcategory = ArrayHelper::map(Testcategory::find()
            ->where(['lab_id' => $labId])
            ->all(), 'testcategory_id', 'category_name');*/
        $sampletype = [];

        /*echo "<pre>";
        print_r(date('Y-m-d', $request->request_datetime));
        echo "</pre>";*/

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {
            if(isset($_POST['Sample']['sampling_date'])){
                $model->sampling_date = date('Y-m-d', strtotime($_POST['Sample']['sampling_date']));
            } else {
                $model->sampling_date = date('Y-m-d');
            }

            $model->rstl_id = 11;
            //$model->sample_code = 0;
            $model->request_id = $request->request_id;
            $model->sample_month = date('m', $request->request_datetime);
            $model->sample_year = date('Y', $request->request_datetime);
            //$model->sampling_date = date('Y-m-d');

            if(isset($_POST['qnty'])){
                $quantity = (int) $_POST['qnty'];
            } else {
                $quantity = 1;
            }

            if(isset($_POST['sample_template']))
            {
                $this->saveSampleTemplate($_POST['Sample']['samplename'],$_POST['Sample']['description']);
            }

            if($quantity>1)
            {
                for ($i=1;$i<=$quantity;$i++)
                {
                    //foreach ($_POST as $sample) {
                        $sample = new Sample();

                        if(isset($_POST['Sample']['sampling_date'])){
                            $sample->sampling_date = date('Y-m-d', strtotime($_POST['Sample']['sampling_date']));
                        } else {
                            $sample->sampling_date = date('Y-m-d');
                        }
                        $sample->rstl_id = 11;
                        $sample->sample_code = 0;
                        $sample->testcategory_id = (int) $_POST['Sample']['testcategory_id'];
                        $sample->sample_type_id = (int) $_POST['Sample']['sample_type_id'];
                        $sample->samplename = $_POST['Sample']['samplename'];
                        $sample->description = $_POST['Sample']['description'];
                        $sample->request_id = $request->request_id;
                        $sample->sample_month = date('m', $request->request_datetime);
                        $sample->sample_year = date('Y', $request->request_datetime);
                        $sample->save(false);
                   // }
                   /* echo "<pre>";
                        print_r($_POST);
                    echo "</pre>";*/
                }
                //return $this->redirect('index');
                return $this->redirect(['/lab/request/view', 'id' => $requestId]);
            } else {
                if($model->save(false)){
                    //return $this->redirect(['view', 'id' => $model->sample_id]);
                    //echo Json::encode('Successfully saved.');
                    $session->set('savepopup',"executed");
                    return $this->redirect(['/lab/request/view', 'id' => $requestId]);
                }
            }

            //for($i=1;$i<=$quantity;$i++)
            //{
               // echo $i."<br/>";
            //}
            //if($model->save(false)){
             //   return $this->redirect(['view', 'id' => $model->sample_id]);
           // }
        } elseif (Yii::$app->request->isAjax) {
                return $this->renderAjax('_form', [
                    'model' => $model,
                    'testcategory' => $testcategory,
                    'sampletype' => $sampletype,
                    'labId' => $labId,
                    'sampletemplate' => $this->listSampletemplate(),
                ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'testcategory' => $testcategory,
                'sampletype' => $sampletype,
                'labId' => $labId,
                'sampletemplate' => $this->listSampletemplate(),
            ]);
        }
    }

    /**
     * Updates an existing Sample model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //\Yii::$app->response->format = Response:: FORMAT_JSON;
        $model = $this->findModel($id);

        /*if(isset($_GET['request_id']))
        {
            $requestId = (int) $_GET['request_id'];
        }*/

        $session = Yii::$app->session;

        $request = $this->findRequest($model->request_id);
        $labId = $request->lab_id;

        $testcategory = $this->listTestcategory($labId);
        //$sampletype = $this->listSampletype();

        $sampletype = ArrayHelper::map(Sampletype::find()
                ->where(['testcategory_id' => $model->testcategory_id])
                ->all(), 'sample_type_id', 'sample_type');

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sample_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/

        if ($model->load(Yii::$app->request->post())) {
            if(isset($_POST['Sample']['sampling_date'])){
                $model->sampling_date = date('Y-m-d', strtotime($_POST['Sample']['sampling_date']));
            } else {
                $model->sampling_date = date('Y-m-d');
            }

            //$model->rstl_id = 11;
            //$model->sample_code = 0;
            //$model->request_id = $request->request_id;
            //$model->sample_month = date('m', $request->request_datetime);
            //$model->sample_year = date('Y', $request->request_datetime);
            //$model->sampling_date = date('Y-m-d');

            if($model->save(false)){
                //if(Yii::$app->request->isAjax){
                  //  echo Json::encode('Successfully saved.');
                    //return;
                //} //else {
                    //return $this->redirect(['view', 'id' => $model->sample_id]);
                //}
                //Yii::$app->session->setFlash('formSave');
                //\Yii::$app->response->format = Response::FORMAT_JSON;
                //return['id'=>$id, 'someOtherData'=>true];
                //return;

                //Yii::$app->response->format = Response::FORMAT_JSON;
                //return json_encode(["test"=> 1]);
               // return array('status' => true, 'data'=> 'Student record is successfully updated');
                //Yii::info('Model was not saved');
                //Yii::$app->session->setFlash('formError');
                //echo Json::encode('Successfully saved.');
                $session->set('updatepopup',"executed");
                return $this->redirect(['/lab/request/view', 'id' => $model->request_id]);

            }
        } elseif (Yii::$app->request->isAjax) {
                return $this->renderAjax('_form', [
                    'model' => $model,
                    'testcategory' => $testcategory,
                    'sampletype' => $sampletype,
                    'labId' => $labId,
                    'sampletemplate' => $this->listSampletemplate(),
                ]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'testcategory' => $testcategory,
                'sampletype' => $sampletype,
                'labId' => $labId,
                'sampletemplate' => $this->listSampletemplate(),
            ]);
        }
    }

    /**
     * Deletes an existing Sample model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        //return $this->redirect(['index']);
        //return Json::encode(['result' => 'Successfully deleted.']);;
        //throw ('Successfully deleted.');
        //echo "Sample successfully deleted.";
        //throw "Error";
        return;
    }

    /**
     * Finds the Sample model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sample the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sample::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function listSampletype()
    {
        $sampletype = ArrayHelper::map(Sampletype::find()->all(), 'sample_type_id', 
            function($sampletype, $defaultValue) {
                return $sampletype->sample_type;
        });

        return $sampletype;
    }

    protected function listTestcategory($labId)
    {
        $testcategory = ArrayHelper::map(Testcategory::find()->andWhere(['lab_id'=>$labId])->all(), 'testcategory_id', 
           function($testcategory, $defaultValue) {
               return $testcategory->category_name;
        });

        /*$testcategory = ArrayHelper::map(Testcategory::find()
            ->where(['lab_id' => $labId])
            ->all(), 'testcategory_id', 'category_name');*/

        return $testcategory;
    }

    public function actionListsampletype() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Sampletype::find()->andWhere(['testcategory_id'=>$id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $sampletype) {
                    $out[] = ['id' => $sampletype['sample_type_id'], 'name' => $sampletype['sample_type']];
                    if ($i == 0) {
                        $selected = $sampletype['sample_type_id'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    /*protected function find()
    {
        $sampletype = ArrayHelper::map(Sampletype::find()->all(), 'sample_type_id', 
            function($sampletype, $defaultValue) {
                return $sampletype->sample_type;
        });

        return $sampletype;
    }*/

    protected function findRequest($requestId)
    {
        if (($model = Request::findOne($requestId)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*public function actionGeneratesamplecode($requestId)
    {
        $samples = Sample::find()
                ->where(['request_id = :requestId'])
                ->params([':requestId'] => $requestId)
                ->all();
        $html = "";
        $request = $this->findRequest($requestId);

        if(count($samples->analysis) > 0){
            foreach ($samples as $sample) {
                if(count($sample->analysis) > 0){
                    $labCode = Lab::model()->findOne($request->lab_id);
                    $year = date('Y', strtotime($request->request_datetime));

                    $samplecode = new Samplecode();
                    $code = $samplecode->
                } else {
                    echo CJSON::encode(array(
                        'status'=>'failure', 
                        'div'=>'No analysis for this sample.'
                        ));
                    exit; 
                }
            }
        } else {
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>'No analysis.'
                ));
            exit; 
        }


        if($modelRequest->sampleCount && $modelRequest->anals){
            foreach($modelRequest->samps as $sample)
            {
                $labCode = Lab::model()->findByPk($modelRequest->labId);
                
                $year = date('Y', strtotime($modelRequest->requestDate));
                
                $code=new Samplecode;
                $sampleCode = $this->generateSampleCode($labCode, $year);
                $number = explode('-', $sampleCode);
                $this->appendSampleCode($modelRequest, $number[1]);
                
                Sample::model()->updateByPk($sample->id, array('sampleCode'=>$sampleCode));
                
                
                foreach($sample->analysesForGeneration as $analysis)
                {
                    Analysis::model()->updateByPk($analysis->id, array('sampleCode'=>$sampleCode));
                }
                
                $sampleNew = Sample::model()->findByPk($sample->id);
                $html .= '<p>'.$sampleNew->sampleName.' : '.$sampleNew->sampleCode.'</p><br/>';
            }
            $this->updateGeneratedRequest($modelRequest);
            echo CJSON::encode(array(
                    'status'=>'success', 
                    'div'=>$html.'<br \> Successfully Generated.'
                    ));
            exit; 
        }else{
            echo CJSON::encode(array(
                    'status'=>'failure', 
                    'div'=>'<div style="text-align:center;" class="alert alert-error"><i class="icon icon-warning-sign"></i><font style="font-size:14px;"> System Warning. </font><br \><br \><div>Cannot generate sample code. <br \>Please add at least one(1) sample and analysis.</div></div>'
                    ));
            exit;           
        }
    }*/

    public function actionGeneratesamplecode(){
        //echo "dkaklajlkdja";
        //exit;

        $requestId = (int) Yii::$app->request->get('request_id');

        $request = $this->findRequest($requestId);
        $lab = Lab::findOne($request->lab_id);

        //$year = date('Y', strtotime($request->request_datetime));
        $year = date('Y', $request->request_datetime);

        /*$samplecode = Samplecode::find([
            'select' => 'MAX(number) as lastnumber',
            'condition' => 'rstl_id =:rstlId AND lab_id =:labId AND year =:year',
            'params' => [':rstlId'=>11,':labId'=>$lab->lab_id,':year'=>$year],
        ])->all();*/

       /* $samplecode = (new Query)
            ->select(['MAX(number) AS lastnumber'])
            ->from('eulims_lab.tbl_samplecode')
            ->where('rstl_id =:rstlId AND lab_id =:labId AND year =:year', [':rstlId'=>11,':labId'=>$lab->lab_id,':year'=>$year])
            ->all();*/

        /*$samplecode = Samplecode::find()
        ->select('MAX(number) as lastnumber')
        ->where('rstl_id =:rstlId AND lab_id =:labId AND year =:year', [':rstlId'=>11,':labId'=>$lab->lab_id,':year'=>$year])
        ->all();*/

        //$sample = Sample::model()->find(['request_id'=>$request_id])->all();
        //$sample = $this->findModel($sampleId);


       /* $sampleCode = Samplecode::model()->find(array(
                'select'=>'*',
                'order'=>'number DESC, id DESC',
                'condition'=>'rstl_id = :rstl_id AND labId = :labId AND year = :year AND cancelled = 0',
                'params'=>array(':rstl_id' => Yii::app()->Controller->getRstlId(), ':labId' => $modelLab->id, ':year' => $year)
            ));*/

        //$nextnumber = $samplecode['lastnumber'] + 1;

        //print_r($samplecode);
        //$year = date('Y',strtotime($request->request_datetime));

       /* if(count($samplecode) > 0)
        {
            $number = $samplecode[0]['lastnumber'];
            //echo $number;
            //$nextnumber = 1;
            //print_r($samplecode);
            // echo "<pre>";
            // print_r($samplecode);
            // echo "</pre>";
        } else {
            $number = 0;
            //print_r($samplecode);
        }*/
        
        //$modelSamplecode->save();
       // foreach ($request->samples as $samp) {
            //$sampleId = $samp['sample']['id'];
            //$sampleId = $samp->sample->id;
            //print_r($samp);

            //$sampleId = 3;
            /*$sample = $this->findModel($sampleId);

            $modelSamplecode = new Samplecode();
            $modelSamplecode->rstl_id = 11;
            $modelSamplecode->reference_num = $request->request_ref_num;
            $modelSamplecode->sample_id = $sample->sample_id;
            $modelSamplecode->lab_id = $lab->lab_id;
            $modelSamplecode->number = $nextnumber;
            $modelSamplecode->year = $year;*/

            /*if($modelSamplecode->save())
            {
                //update samplecode to tbl_sample
                $sample->sample_code = $lab->labcode."-".$nextnumber;
                $sample->save();
            } else {
                //error
                $modelSamplecode->error();
                exit;
            }*/
        //}

        //print_r(count($request->samples));

        foreach ($request->samples as $samp) {

            $samplecode = (new Query)
            ->select(['MAX(number) AS lastnumber'])
            ->from('eulims_lab.tbl_samplecode')
            ->where('rstl_id =:rstlId AND lab_id =:labId AND year =:year', [':rstlId'=>11,':labId'=>$lab->lab_id,':year'=>$year])
            ->all();

            if(count($samplecode) > 0)
            {
                $number = $samplecode[0]['lastnumber'];
                //echo $number;
                //$nextnumber = 1;
                //print_r($samplecode);
                // echo "<pre>";
                // print_r($samplecode);
                // echo "</pre>";
            } else {
                $number = 0;
                //print_r($samplecode);
            }

            //for ($i=1;$i<=count($request->samples);$i++)
            //{
                //$nextnumber = $number + 1;
            //}

                //$nextnumber = $number + 1;

                //$count = 1;
                //if(count($request->samples) >= $count)
               // {
                    //$count = 1;
                //for($count=1;count($request->samples) >=$count;$count++)
                //{
                    $nextnumber = $number + 1;
                    $appendNextnumber = str_pad($nextnumber, 4, "0", STR_PAD_LEFT);
                //}
                    //echo $samp['sample_id']."<br>";
                    //echo "-".$nextnumber."<br>";
                    $sampleId = $samp->sample_id;
                    $sample = $this->findModel($sampleId);
                    //$toinsert = $nextnumber + $i;

                    $modelSamplecode = new Samplecode();
                    $modelSamplecode->rstl_id = 11;
                    $modelSamplecode->reference_num = $request->request_ref_num;
                    $modelSamplecode->sample_id = $sampleId;
                    $modelSamplecode->lab_id = $lab->lab_id;
                    $modelSamplecode->number = $nextnumber;
                    $modelSamplecode->year = $year;

                    if($modelSamplecode->save())
                    {
                        //update samplecode to tbl_sample
                        $sample->sample_code = $lab->labcode."-".$appendNextnumber;
                        $sample->save();
                    } else {
                        //error
                        $modelSamplecode->error();
                        exit;
                    }
                    //$count = $count + 1;
                //}
            //}
           /* echo "<pre>";
                print_r($_POST);
            echo "</pre>";*/
        }

        //echo "<pre>";
        //print_r($request->samples->sample_id);
        //echo "</pre>";


        /*if(isset($sampleCode)){
            return $modelLab->labCode.'-'.Yii::app()->Controller->addZeros($sampleCode->number + 1);
        }else{
            $initializeCode = Initializecode::model()->find(array(
                'select'=>'*',
                'condition'=>'rstl_id = :rstl_id AND lab_id = :lab_id AND codeType = :codeType',
                'params'=>array(':rstl_id' => Yii::app()->Controller->getRstlId(), ':lab_id' => $modelLab->id, ':codeType' => 2)
            ));
            $startCode = Yii::app()->Controller->addZeros($initializeCode->startCode + 1);
            return $modelLab->labCode.'-'.$startCode;
        }*/

        //return $modelSamplecode;
        //return $samplecode;
    }

    protected function listSampletemplate()
    {
        $sampleTemplate = ArrayHelper::map(SampleName::find()->all(), 'sample_name_id', 
            function($sampleTemplate, $defaultValue) {
                return $sampleTemplate->sample_name;
        });

        return $sampleTemplate;
    }

    public function actionGetlisttemplate() {
        if(isset($_GET['template_id'])){
            $id = (int) $_GET['template_id'];
            $modelSampletemplate =  SampleName::findOne(['sample_name_id'=>$id]);
            if(count($modelSampletemplate)>0){
                $sampleName = $modelSampletemplate->sample_name;
                $sampleDescription = $modelSampletemplate->description;
            } else {
                $sampleName = "";
                $sampleDescription = "";
            }
        } else {
            $sampleName = "Error getting sample name";
            $sampleDescription = "Error getting description";
        }
        return Json::encode([
            'name'=>$sampleName,
            'description'=>$sampleDescription,
        ]);
    }

    protected function saveSampleTemplate($sampleName,$description)
    {
        $modelSampletemplate = new SampleName();

        $modelSampletemplate->sample_name = $sampleName;
        $modelSampletemplate->description = $description;
        $modelSampletemplate->save();

        return $modelSampletemplate;
    }
}
