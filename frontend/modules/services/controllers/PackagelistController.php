<?php

namespace frontend\modules\services\controllers;

use Yii;
use common\models\lab\Packagelist;
use common\models\lab\PackagelistSearch;
use common\models\lab\Analysis;
use common\models\lab\AnalysisSearch;
use common\models\lab\Test;
use common\models\lab\TestSearch;
use common\models\lab\Request;
use common\models\lab\RequestSearch;
use common\models\lab\Sample;
use common\models\lab\SampleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\services\Testcategory;
use common\models\services\TestcategorySearch;
use yii\helpers\Json;

/**
 * PackagelistController implements the CRUD actions for Packagelist model.
 */
class PackagelistController extends Controller
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
     * Lists all Packagelist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackagelistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Packagelist model.
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
        }
    }

    /**
     * Creates a new Packagelist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
     $model = new Packagelist();

    //  $request_id = $_GET['id'];

    //   $request = $this->findRequest($request_id);
    //   $labId = $request->lab_id;

      $testcategory = $this->listTestcategory(1);
      $sampletype = [];

                 if ($model->load(Yii::$app->request->post())) {

                         $post= Yii::$app->request->post();
                        $packagelist = new Packagelist();
                        $packagelist->rstl_id = (int) $post['Packagelist']['rstl_id'];
                        $packagelist->lab_id = (int) $post['Packagelist']['testcategory_id'];
                        $packagelist->testcategory_id = $post['Packagelist']['testcategory_id'];
                        $packagelist->sample_type_id = $post['Packagelist']['sample_type_id'];
                        $packagelist->name = $post['Packagelist']['name'];
                        $packagelist->rate = $post['Packagelist']['rate'];  
                        $packagelist->tests = $post['Packagelist']['tests']; 
                        $packagelist->save();
                        Yii::$app->session->setFlash('success', 'Package Successfully Added');
                        return $this->runAction('index');
               
                    }      
                                
                     
                if(Yii::$app->request->isAjax){
                         return $this->renderAjax('_form', [
                                 'model' => $model,
                                 'testcategory'=>$testcategory,
                                 'sampletype'=>$sampletype,
                             ]);
                     }
    }

  
    public function actionCreatepackage($id)
    {
        $model = new Packagelist();
        $request_id = $_GET['id'];
        $searchModel = new PackageListSearch();
        $session = Yii::$app->session;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->analysis_id]);
        // }

        if ($model->load(Yii::$app->request->post())) {
            $sample_ids= $_POST['sample_ids'];
            $ids = explode(',', $sample_ids);  
            $post= Yii::$app->request->post();
               //iloop yung mga tests dito (1,2,3,4,5)
               //separate loop ang tests

           
   }
        
            $samplesQuery = Sample::find()->where(['request_id' => $id]);
            $sampleDataProvider = new ActiveDataProvider([
                    'query' => $samplesQuery,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                 
            ]);

            $request = $this->findRequest($request_id);
            $labId = $request->lab_id;
    
            $testcategory = $this->listTestcategory($labId);
         
            $sampletype = [];
            $test = [];

         if ($model->load(Yii::$app->request->post())) {
                 $sample_ids= $_POST['sample_ids'];
                 $ids = explode(',', $sample_ids);  
                 $post= Yii::$app->request->post();
                    //iloop yung mga tests dito (1,2,3,4,5)
                    //separate loop ang tests

                 foreach ($ids as $sample_id){
                     $analysis = new Analysis();

                     //yung package name mo na ituuu
                     //test
                     $modelpackage =  Packagelist::findOne(['package_id'=>$post['Packagelist']['name']]);
                     $analysis->sample_id = $sample_id;
                     $analysis->cancelled = 0;
                     $analysis->pstcanalysis_id = $GLOBALS['rstl_id'];
                     $analysis->request_id = $request_id;
                     $analysis->rstl_id = $GLOBALS['rstl_id'];
                     $analysis->test_id = 1;
                     $analysis->user_id = 1;
                     $analysis->sample_type_id = (int) $post['Packagelist']['sample_type_id'];
                     $analysis->testcategory_id = (int) $post['Packagelist']['testcategory_id'];
                     $analysis->is_package = 1;
                     $analysis->method = "-";
                     $analysis->fee = $post['Packagelist']['rate'];
                     $analysis->testname = $modelpackage->name;
                     $analysis->references = "references";
                     $analysis->quantity = 1;
                     $analysis->sample_code = "sample";
                     $analysis->date_analysis = '2018-06-14 7:35:0';   
                     $analysis->save();
                 }      
                 
              
                 Yii::$app->session->setFlash('success', 'Package Successfully Created');
                 return $this->redirect(['/lab/request/view', 'id' =>$request_id]);
        } 
        if (Yii::$app->request->isAjax) {

            $analysismodel = new Analysis();

            $analysismodel->rstl_id = $GLOBALS['rstl_id'];
            $analysismodel->pstcanalysis_id = $GLOBALS['rstl_id'];
            $analysismodel->request_id = $GLOBALS['rstl_id'];
            $analysismodel->testname = $GLOBALS['rstl_id'];
            $analysismodel->cancelled = 0;
            $analysismodel->is_package = 1;
            $analysismodel->sample_id = $GLOBALS['rstl_id'];
            $analysismodel->sample_code = $GLOBALS['rstl_id'];
            $analysismodel->date_analysis = '2018-06-14 7:35:0';

            return $this->renderAjax('_packageform', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'testcategory' => $testcategory,
                'test' => $test,
                'sampletype'=>$sampletype
            ]);
        }else{
            $model->rstl_id = $GLOBALS['rstl_id'];
            return $this->render('_packageform', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'testcategory' => $testcategory,
                'test' => $test,
                'sampletype'=>$sampletype
            ]);
        }
    }

    public function actionListpackage()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Packagelist::find()->andWhere(['sample_type_id'=>$id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $package) {
                    $out[] = ['id' => $package['package_id'], 'name' => $package['name']];
                    if ($i == 0) {
                        $selected = $package['package_id'];
                    }
                }
                
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    protected function findRequest($requestId)
    {
        if (($model = Request::findOne($requestId)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetpackage() {
        if(isset($_GET['packagelist_id'])){
            $id = (int) $_GET['packagelist_id'];
            $modelpackagelist =  Packagelist::findOne(['package_id'=>$id]);
            if(count($modelpackagelist)>0){
                $rate = $modelpackagelist->rate;

                $tet = $modelpackagelist->tests;

                $t = explode(',', $tet);
               

                foreach ($t as $test_id){
                    $test_id =  Test::findOne(['test_id'=>$id]);

                    $testname = $test_id->testname;
                    $newline = "\n";
                    $tests = $testname.$newline.$testname;
                } 
                      
            } else {
                $rate = "";
                $tests = "";
            }
        } else {
            $rate = "Error getting rate";
            $tests = "Error getting tests";
        }
        return Json::encode([
            'rate'=>$rate,
            'tests'=>$tests,
        ]);
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
    /**
     * Updates an existing Packagelist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $testcategory = $this->listTestcategory(1);
        $sampletype = [];

          if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Package Successfully Updated');
                    return $this->runAction('index');
                } else if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('_form', [
                        'model' => $model,
                        'testcategory'=>$testcategory,
                        'sampletype'=>$sampletype,
                    ]);
                }
    }

    /**
     * Deletes an existing Packagelist model.
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
     * Finds the Packagelist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Packagelist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Packagelist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
