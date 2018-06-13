<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Analysis;
use common\models\lab\Sample;
use common\models\lab\AnalysisSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\lab\Sampletype;
use common\models\lab\Testcategory;

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
        $model = new Analysis();

        $searchModel = new AnalysisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->analysis_id]);
        }
        
        

            $samplesQuery = Sample::find()->where(['request_id' => 1]);
            $sampleDataProvider = new ActiveDataProvider([
                    'query' => $samplesQuery,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                 
            ]);

            $testcategory = $this->listTestcategory(1);
         
            $sampletype = [];
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'testcategory' => $testcategory,
                'sampletype' => $sampletype,
                // 'labId' => $labId,
                // 'sampletemplate' => $this->listSampletemplate(),
            ]);
        }else{
            return $this->render('_form', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'sampleDataProvider' => $sampleDataProvider,
                'testcategory' => $testcategory,
                'sampletype' => $sampletype,
                // 'labId' => $labId,
                // 'sampletemplate' => $this->listSampletemplate(),
            ]);
        }

        // return $this->render('create', [
        //     'model' => $model,
        // ]);
    }

    // public function actionCreate()
    // {
    //     $model = new Sample();

    //     /*if(isset($_GET['lab_id']))
    //     {
    //         $labId = (int) $_GET['lab_id'];
    //     } else {
    //         $labId = 2;
    //     }*/
    //     $session = Yii::$app->session;
    //     //$req = Yii::$app->request;

    //     if(Yii::$app->request->get('request_id'))
    //     {
    //         $requestId = (int) Yii::$app->request->get('request_id');
    //     }
    //     $request = $this->findRequest($requestId);
    //     $labId = $request->lab_id;

    //     $testcategory = $this->listTestcategory($labId);
    //     //$sampletype = $this->listSampletype();
    //     /*$testcategory = ArrayHelper::map(Testcategory::find()
    //         ->where(['lab_id' => $labId])
    //         ->all(), 'testcategory_id', 'category_name');*/
    //     $sampletype = [];

    //     /*echo "<pre>";
    //     print_r(date('Y-m-d', $request->request_datetime));
    //     echo "</pre>";*/

    //     //if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //     if ($model->load(Yii::$app->request->post())) {
    //         if(isset($_POST['Sample']['sampling_date'])){
    //             $model->sampling_date = date('Y-m-d', strtotime($_POST['Sample']['sampling_date']));
    //         } else {
    //             $model->sampling_date = date('Y-m-d');
    //         }

    //         $model->rstl_id = 11;
    //         //$model->sample_code = 0;
    //         $model->request_id = $request->request_id;
    //         $model->sample_month = date('m', $request->request_datetime);
    //         $model->sample_year = date('Y', $request->request_datetime);
    //         //$model->sampling_date = date('Y-m-d');

    //         if(isset($_POST['qnty'])){
    //             $quantity = (int) $_POST['qnty'];
    //         } else {
    //             $quantity = 1;
    //         }

    //         if(isset($_POST['sample_template']))
    //         {
    //             $this->saveSampleTemplate($_POST['Sample']['samplename'],$_POST['Sample']['description']);
    //         }

    //         if($quantity>1)
    //         {
    //             for ($i=1;$i<=$quantity;$i++)
    //             {
    //                 //foreach ($_POST as $sample) {
    //                     $sample = new Sample();

    //                     if(isset($_POST['Sample']['sampling_date'])){
    //                         $sample->sampling_date = date('Y-m-d', strtotime($_POST['Sample']['sampling_date']));
    //                     } else {
    //                         $sample->sampling_date = date('Y-m-d');
    //                     }
    //                     $sample->rstl_id = 11;
    //                     //$sample->sample_code = 0;
    //                     $sample->testcategory_id = (int) $_POST['Sample']['testcategory_id'];
    //                     $sample->sample_type_id = (int) $_POST['Sample']['sample_type_id'];
    //                     $sample->samplename = $_POST['Sample']['samplename'];
    //                     $sample->description = $_POST['Sample']['description'];
    //                     $sample->request_id = $request->request_id;
    //                     $sample->sample_month = date('m', $request->request_datetime);
    //                     $sample->sample_year = date('Y', $request->request_datetime);
    //                     $sample->save(false);
    //                // }
    //                /* echo "<pre>";
    //                     print_r($_POST);
    //                 echo "</pre>";*/
    //             }
    //             //return $this->redirect('index');
    //             $session->set('savemessage',"executed");
    //             return $this->redirect(['/lab/request/view', 'id' => $requestId]);
    //         } else {
    //             if($model->save(false)){
    //                 //return $this->redirect(['view', 'id' => $model->sample_id]);
    //                 //echo Json::encode('Successfully saved.');
    //                 $session->set('savemessage',"executed");
    //                 return $this->redirect(['/lab/request/view', 'id' => $requestId]);
    //             }
    //         }

    //         //for($i=1;$i<=$quantity;$i++)
    //         //{
    //            // echo $i."<br/>";
    //         //}
    //         //if($model->save(false)){
    //          //   return $this->redirect(['view', 'id' => $model->sample_id]);
    //        // }
    //     } elseif (Yii::$app->request->isAjax) {
    //             return $this->renderAjax('_form', [
    //                 'model' => $model,
    //                 'testcategory' => $testcategory,
    //                 'sampletype' => $sampletype,
    //                 'labId' => $labId,
    //                 'sampletemplate' => $this->listSampletemplate(),
    //             ]);
    //     } else {
    //         return $this->render('create', [
    //             'model' => $model,
    //             'testcategory' => $testcategory,
    //             'sampletype' => $sampletype,
    //             'labId' => $labId,
    //             'sampletemplate' => $this->listSampletemplate(),
    //         ]);
    //     }
    // }

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
}
