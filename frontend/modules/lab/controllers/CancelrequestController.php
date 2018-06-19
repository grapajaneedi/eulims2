<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Cancelledrequest;
use common\models\lab\CancelledrequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\Request;
/**
 * CancelrequestController implements the CRUD actions for Cancelledrequest model.
 */
class CancelrequestController extends Controller
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
     * Lists all Cancelledrequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CancelledrequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cancelledrequest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cancelledrequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $get= \Yii::$app->request->get();
        $model = new Cancelledrequest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Update Request
            $Request= Request::find()->where(['request_id'=>$model->request_id])->one();
            $Request->status_id=2;
            $Request->save();
            return $this->redirect(['/lab/request/view', 'id' => $model->request_id]);
        } else {
            $Request_id=$get['req'];
            $model->cancel_date=date('Y-m-d H:i:s');
            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                    'Req_id'=> $Request_id
                ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'Req_id'=> $Request_id
                ]);
            }
        }
    }

    /**
     * Updates an existing Cancelledrequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->canceledrequest_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cancelledrequest model.
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
     * Finds the Cancelledrequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cancelledrequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cancelledrequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
