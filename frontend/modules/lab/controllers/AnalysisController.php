<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Analysis;
use common\models\lab\Sample;
use common\models\lab\Request;
use common\models\lab\RequestSearch;
use common\models\lab\Discount;
use common\models\lab\AnalysisSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\lab\Sampletype;
use common\models\lab\Testcategory;
use common\models\lab\Test;
use common\models\lab\SampleSearch;
use yii\helpers\Json;
use common\models\finance\Paymentitem;
use DateTime;

/**
 * AnalysisController implements the CRUD actions for Analysis model.
 */
class AnalysisController extends Controller
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
        $searchModel = new AnalysisSearch();
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

     protected function findRequest($requestId)
     {
         if (($model = Request::findOne($requestId)) !== null) {
             return $model;
         } else {
             throw new NotFoundHttpException('The requested page does not exist.');
         }
     }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionGettest() {
        if(isset($_GET['test_id'])){
            $id = (int) $_GET['test_id'];
            $modeltest=  Test::findOne(['test_id'=>$id]);
            if(count($modeltest)>0){
                $method = $modeltest->method;
                $references = $modeltest->payment_references;
                $fee = $modeltest->fee;
            } else {
                $method = "";
                $references = "";
                $fee = "";
            }
        } else {
            $method = "Error getting method";
            $references = "Error getting reference";
            $fee = "Error getting fee";
        }
        return Json::encode([
            'method'=>$method,
            'references'=>$references,
            'fee'=>$fee,
        ]);
    }


    public function actionListtest()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Test::find()->andWhere(['sample_type_id'=>$id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $test) {
                    $out[] = ['id' => $test['test_id'], 'name' => $test['testname']];
                    if ($i == 0) {
                        $selected = $test['test_id'];
                    }
                }
                
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    protected function listSampletype()
    {
        $sampletype = ArrayHelper::map(Sampletype::find()->all(), 'sample_type_id', 
            function($sampletype, $defaultValue) {
                return $sampletype->sample_type;
        });

        return $sampletype;
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
                
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    /**
     * Creates a new Analysis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        //  Yii::$app->session->setFlash('success', 'Janeedi Maganda'); 
        //  exit;

        $model = new Analysis; 
        $session = Yii::$app->session;
        $searchModel = new AnalysisSearch();
        $samplesearchmodel = new SampleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $samplesQuery = Sample::find()->where(['request_id' => $id]);
        $sampleDataProvider = new ActiveDataProvider([
                'query' => $samplesQuery,   
        ]);

        $sample_count = $sampleDataProvider->getTotalCount();
        
       
       
        
        
        $request_id = $_GET['id'];
        $request = $this->findRequest($request_id);
        $labId = $request->lab_id;

        $testcategory = $this->listTestcategory($labId);

        $sampletype = [];
        $test = [];
        
        // if ($sample_count==0){  
        // //    Yii::$app->session->setFlash('success', 'Please add atleast 1 sample'); 
        // //    return $this->redirect(['/lab/request/view', 'id' =>$request_id]);
        //     echo "Please add atleast one sample";
        //     exit;
      //  } else 
        
        if ($model->load(Yii::$app->request->post())) {
           $requestId = (int) Yii::$app->request->get('request_id');
            
           
                 $sample_ids= $_POST['selection'];

                
                 $post= Yii::$app->request->post();

                foreach ($sample_ids as $sample_id){

                   

                    $modeltest=  Test::findOne(['test_id'=>$post['Analysis']['test_id']]);
                    $analysis = new Analysis();
                    $date = new DateTime();
                    date_add($date,date_interval_create_from_date_string("1 day"));
                    $analysis->sample_id = $sample_id;
                    $analysis->cancelled = 0;
                    $analysis->pstcanalysis_id = (int) $post['Analysis']['pstcanalysis_id'];
                    $analysis->request_id = $request_id;
                    $analysis->rstl_id = $GLOBALS['rstl_id'];
                    $analysis->test_id = (int) $post['Analysis']['test_id'];
                    $analysis->sample_type_id = (int) $post['Analysis']['sample_type_id'];
                    $analysis->testcategory_id = (int) $post['Analysis']['testcategory_id'];
                    $analysis->is_package = (int) $post['Analysis']['is_package'];
                    $analysis->method = $post['Analysis']['method'];
                    $analysis->fee = $post['Analysis']['fee'];
                    $analysis->testname = $modeltest->testname;
                    $analysis->references = $post['Analysis']['references'];
                    $analysis->quantity = 1;
                    $analysis->sample_code = $post['Analysis']['sample_code'];
                    $analysis->date_analysis = date("Y-m-d h:i:s");
                    $analysis->save(); 
                    
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
                }     
                Yii::$app->session->setFlash('success', 'Analysis Successfully Added'); 
                return $this->redirect(['/lab/request/view', 'id' =>$request_id]);
       } else if (Yii::$app->request->isAjax) {

            //please check on this
                $model->rstl_id = $GLOBALS['rstl_id'];
                $model->pstcanalysis_id = $GLOBALS['rstl_id'];
                $model->request_id = $request_id;
                $model->testname = $GLOBALS['rstl_id'];
                $model->cancelled = 0;
                $model->sample_id = $GLOBALS['rstl_id'];
                $model->sample_code = $GLOBALS['rstl_id'];
                $model->date_analysis = date("Y-m-d h:i:s");;

            return $this->renderAjax('_form', [
                'model' => $model,
                'searchModel' => $searchModel,
                'samplesearchmodel'=>$samplesearchmodel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'testcategory' => $testcategory,
                'test' => $test,
                'sampletype'=>$sampletype
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $analysisquery = Analysis::find()->where(['analysis_id' => $id])->one();
        $samplesQuery = Sample::find()->where(['sample_id' => $analysisquery->sample_id]);
        $requestquery = Request::find()->where([ 'request_id'=> $analysisquery->request_id])->one();

        $paymentitem = Paymentitem::find()->where([ 'request_id'=> $analysisquery->request_id])->one();

      
            $sampleDataProvider = new ActiveDataProvider([
                'query' => $samplesQuery,
                'pagination' => [
                 'pageSize' => 10,
                        ],        
                ]);
        
                $url = \Yii::$app->request->url;
                $rid = substr($url, 24);
                $labId =  $requestquery->lab_id;

                $testcategory = $this->listTestcategory($labId);

                $sampletype = [];
                $test = [];

            if ($model->load(Yii::$app->request->post())) {            
                    if($model->save(false)){
                        $requestquery = Request::find()->where(['request_id' =>$analysisquery->request_id])->one();
                        $discountquery = Discount::find()->where(['discount_id' => $requestquery->discount_id])->one();
                        $rate =  $discountquery->rate;       
                        $sql = "SELECT SUM(fee) as subtotal FROM tbl_analysis WHERE request_id=$analysisquery->request_id";
                        $Connection = Yii::$app->labdb;
                        $command = $Connection->createCommand($sql);
                        $row = $command->queryOne();
                        $subtotal = $row['subtotal'];
                        $total = $subtotal - ($subtotal * ($rate/100));

                        $Connection= Yii::$app->labdb;
                        $sql="UPDATE `tbl_request` SET `total`='$total' WHERE `request_id`=".$analysisquery->request_id;
                        $Command=$Connection->createCommand($sql);
                        $Command->execute();

                        Yii::$app->session->setFlash('success', 'Analysis Successfully Update'); 
                        return $this->redirect(['/lab/request/view', 'id' =>$requestquery->request_id]);
                    }
                } elseif (Yii::$app->request->isAjax) {
        return $this->renderAjax('_form', [
            'model' => $model,
             'sampleDataProvider' => $sampleDataProvider,
             'testcategory' => $testcategory,
            'test' => $test,
            'sampletype'=>$sampletype
        ]);
    }else{
        return $this->render('_form', [
            'model' => $model,
             'sampleDataProvider' => $sampleDataProvider,
             'testcategory' => $testcategory,
            'sampletype' => $sampletype,
            'test' => $test,
        ]);
    }

      

                // $model = $this->findModel($id);
        
                // $session = Yii::$app->session;
        
                // $request = $this->findRequest($model->request_id);
                // $labId = $request->lab_id;
        
                // $testcategory = $this->listTestcategory($labId);
        
                // $sampletype = ArrayHelper::map(Sampletype::find()
                //         ->where(['testcategory_id' => $model->testcategory_id])
                //         ->all(), 'sample_type_id', 'sample_type');
        
                // if ($model->load(Yii::$app->request->post())) {
                //     if(isset($_POST['Sample']['sampling_date'])){
                //         $model->sampling_date = date('Y-m-d', strtotime($_POST['Sample']['sampling_date']));
                //     } else {
                //         $model->sampling_date = date('Y-m-d');
                //     }
        
                //     if($model->save(false)){
                //         $session->set('updatemessage',"executed");
                //         return $this->redirect(['/lab/request/view', 'id' => $model->request_id]);
        
                //     }
                // } elseif (Yii::$app->request->isAjax) {
                //         return $this->renderAjax('_form', [
                //             'model' => $model,
                //             'testcategory' => $testcategory,
                //             'sampletype' => $sampletype,
                //             'labId' => $labId,
                //             'sampletemplate' => $this->listSampletemplate(),
                //         ]);
                // } else {
                //     return $this->render('update', [
                //         'model' => $model,
                //         'testcategory' => $testcategory,
                //         'sampletype' => $sampletype,
                //         'labId' => $labId,
                //         'sampletemplate' => $this->listSampletemplate(),
                //     ]);
                // }
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
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);

        $model = $this->findModel($id);

        $session = Yii::$app->session;
       
          
            if($model->delete()) {
                $analysisquery = Analysis::find()->where(['analysis_id' => $id])->one();
                $requestquery = Request::find()->where(['request_id' =>$model->request_id])->one();
                $discountquery = Discount::find()->where(['discount_id' => $requestquery->discount_id])->one();
                $rate =  $discountquery->rate;       
                $sql = "SELECT SUM(fee) as subtotal FROM tbl_analysis WHERE request_id=$model->request_id";
                $Connection = Yii::$app->labdb;
                $command = $Connection->createCommand($sql);
                $row = $command->queryOne();
                $subtotal = $row['subtotal'];
                $total = $subtotal - ($subtotal * ($rate/100));
        
                $Connection= Yii::$app->labdb;
                $sql="UPDATE `tbl_request` SET `total`='$total' WHERE `request_id`=".$model->request_id;
                $Command=$Connection->createCommand($sql);
                $Command->execute();
                Yii::$app->session->setFlash('success', 'Analysis Successfully Deleted'); 
                return $this->redirect(['/lab/request/view', 'id' => $model->request_id]);
            } else {
                return $model->error();
            }
        
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

   
}
