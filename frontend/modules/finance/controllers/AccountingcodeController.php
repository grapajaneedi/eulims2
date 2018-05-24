<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Accountingcode;
use common\models\finance\AccountingcodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccountingcodeController implements the CRUD actions for Accountingcode model.
 */
class AccountingcodeController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all Accountingcode models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AccountingcodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);




        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Accountingcode model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        if (Yii::$app->request->isAjax)
        {
           return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
        ]); 
        }
        else
        {
           return $this->render('view', [
                    'model' => $this->findModel($id),
        ]); 
        }
        
    }

    /**
     * Creates a new Accountingcode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Accountingcode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->accountingcode_id]);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                        'model' => $model,
            ]);
        } else {

            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Accountingcode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->accountingcode_id]);
        }
        
        
         if (Yii::$app->request->isAjax)
         {
         return $this->renderAjax('update', [
                        'model' => $model,
            ]);
         }
         else
         {
            return $this->render('update', [
                        'model' => $model,
            ]);
         }
    }

    /**
     * Deletes an existing Accountingcode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    
    public function actionMapping() {
        if (Yii::$app->request->isAjax)
        {
           return $this->renderAjax('mapping'); 
        }
        else
        {
           return $this->render('mapping'); 
       
        }
        
    }

    /**
     * Finds the Accountingcode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Accountingcode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Accountingcode::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    

}
