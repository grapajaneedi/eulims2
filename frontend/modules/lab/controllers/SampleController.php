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
use common\models\lab\Sampletemplate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\db\Query;

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
            $model->sample_code = 0;
            $model->request_id = $request->request_id;
            $model->sample_month = date('m', $request->request_datetime);
            $model->sample_year = date('Y', $request->request_datetime);
            //$model->sampling_date = date('Y-m-d');

            if(isset($_POST['qnty'])){
                $quantity = (int) $_POST['qnty'];
            } else {
                $quantity = 1;
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
                        $sample->test_category_id = (int) $_POST['Sample']['test_category_id'];
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
                return $this->redirect('index');
            } else {
                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->sample_id]);
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
        $model = $this->findModel($id);

        if(isset($_GET['request_id']))
        {
            $requestId = (int) $_GET['request_id'];
        }
        $request = $this->findRequest($requestId);
        $labId = $request->lab_id;

        $testcategory = $this->listTestcategory($labId);
        //$sampletype = $this->listSampletype();

        $sampletype = ArrayHelper::map(Sampletype::find()
                ->where(['test_category_id' => $model->test_category_id])
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
                return $this->redirect(['view', 'id' => $model->sample_id]);
            }
        } elseif (Yii::$app->request->isAjax) {
                return $this->renderAjax('_form', [
                    'model' => $model,
                    'testcategory' => $testcategory,
                    'sampletype' => $sampletype,
                    'labId' => $labId,
                ]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'testcategory' => $testcategory,
                'sampletype' => $sampletype,
                'labId' => $labId,
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

        return $this->redirect(['index']);
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
            $list = Sampletype::find()->andWhere(['test_category_id'=>$id])->asArray()->all();
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

    protected function generateSampleCode($lab, $year){
        $samplecode = Samplecode::mdodel()->find([
            'select' => '*',
            'order' => 'number DESC',
            'condition' => ''
        ]);
        $sampleCode = Samplecode::model()->find(array(
                'select'=>'*',
                'order'=>'number DESC, id DESC',
                'condition'=>'rstl_id = :rstl_id AND labId = :labId AND year = :year AND cancelled = 0',
                'params'=>array(':rstl_id' => Yii::app()->Controller->getRstlId(), ':labId' => $modelLab->id, ':year' => $year )
            ));
            
        if(isset($sampleCode)){
            return $modelLab->labCode.'-'.Yii::app()->Controller->addZeros($sampleCode->number + 1);
        }else{
            $initializeCode = Initializecode::model()->find(array(
                'select'=>'*',
                'condition'=>'rstl_id = :rstl_id AND lab_id = :lab_id AND codeType = :codeType',
                'params'=>array(':rstl_id' => Yii::app()->Controller->getRstlId(), ':lab_id' => $modelLab->id, ':codeType' => 2)
            ));
            $startCode = Yii::app()->Controller->addZeros($initializeCode->startCode + 1);
            return $modelLab->labCode.'-'.$startCode;
        }
    }

    protected function listSampletemplate()
    {
        $sampleTemplate = ArrayHelper::map(Sampletemplate::find()->all(), 'sampletemplate_id', 
            function($sampleTemplate, $defaultValue) {
                return $sampleTemplate->name;
        });

        return $sampleTemplate;
    }

    public function actionGetlisttemplate() {
        if(isset($_GET['template_id'])){
            $id = (int) $_GET['template_id'];
            $modelSampletemplate =  Sampletemplate::findOne(['sampletemplate_id'=>$id]);
            if(count($modelSampletemplate)>0){
                $sampleName = $modelSampletemplate->name;
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

    protected function saveSampleTemplate()
    {
        
    }

    public function actionListtemplate($q = null)
    {
        $query = new Query;
        
        $query->select('name')
            ->from('eulims_lab.tbl_sampletemplate')
            ->where('name LIKE "%' . $q .'%"')
            ->orderBy('name');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['name']];
        }
        echo Json::encode($out);
    }
}
