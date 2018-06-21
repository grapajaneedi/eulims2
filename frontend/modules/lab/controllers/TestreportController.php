<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Testreport;
use common\models\lab\TestreportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\Sample;
use yii\data\ActiveDataProvider;


/**
 * TestreportController implements the CRUD actions for Testreport model.
 */
class TestreportController extends Controller
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
     * Lists all Testreport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestreportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Testreport model.
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
     * Creates a new Testreport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Testreport();

        if ($model->load(Yii::$app->request->post())) {
            //on form submit the lab_id is used as flag for is_multiple
            //get the request id
            $req_id = $model->request_id;
            //query for the request id info//get labid
            $request = Request::findOne($req_id);

            //check for config if the lab is active
            $tr_config = Testreportconfig::findOne()->where(['lab_id'=>$Request->lab_id]);
            if(!$tr_config){
                //throw error
                throw new \yii\base\Exception( "Lab Configuration is Inactive!" );
                exit();
            }
            //check if multiple
            if($model->lab_id){
                //if multiple //code here
            }else{
                //if not multiple //code here
                //retrieve the lab info using the $tr_config
                $lab = Lab::findOne($tr_config->lab_id);

                //update lab id on model
                $model->lab_id=$request->lab_id;
                //update the testreport number
                $model->report_num= date('mmddY').'-'.$lab->labname.'-'.$tr_config->number;
                if($model->save()){
                    //update the config
                    $tr_config->number = $tr_config->number +1 ; 
                    //save the sample IDS for samples involve
                    $sampleids =$_POST['Sample'];
                    foreach ($sampleids as $key => $value) {
                        $trsample = new TestreportSample();
                        $trsample->testreport_id=$model->testreport_id;
                        $trsample->sample_id=$value['sample_id'];
                        $trsample->save();
                     }
                }
            }

            
            return $this->redirect(['view', 'id' => $model->testreport_id]);
        }

        if(Yii::$app->request->isAjax)
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        else
            return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Testreport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->testreport_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Testreport model.
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
     * Finds the Testreport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testreport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testreport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetlistsamples($id)
    {
        $model= new Sample();
        $query = Sample::find()->where(['request_id' => $id]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       // $dataProvider->pagination->pageSize=3;
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_samples', ['dataProvider'=>$dataProvider]);
        }
        else{
            return $this->render('_samples', ['dataProvider'=>$dataProvider]);
        }

    }
}
