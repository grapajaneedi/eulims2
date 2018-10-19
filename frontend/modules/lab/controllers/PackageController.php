<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Package;
use common\models\lab\PackageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PackageController implements the CRUD actions for Package model.
 */
class PackageController extends Controller
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
     * Lists all Package models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Package model.
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
     * Creates a new Package model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Package();
        $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
        $post= Yii::$app->request->post();
        $sampletype = [];
        if ($model->load(Yii::$app->request->post())) {
                   $model = new Package();
                    $model->rstl_id= $GLOBALS['rstl_id'];
                    $model->testcategory_id=11;
                    $model->sampletype_id= $post['Package']['sampletype_id'];
                    $model->name= $post['Package']['name'];
                    $model->rate= $post['Package']['rate'];
                    $model->tests= $post['Package']['tests'];
                    $model->save(); 
                    Yii::$app->session->setFlash('success', 'Package Successfully Created'); 
                    return $this->runAction('index');
                }
        
                
               
                if(Yii::$app->request->isAjax){
                    $model->rstl_id= 11;
                    
                    $model->testcategory_id=1;
                    return $this->renderAjax('_form', [
                        'model' => $model,
                        'sampletype'=>$sampletype
                    ]);
               }

    }

    /**
     * Updates an existing Package model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Package model.
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
     * Finds the Package model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Package::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
