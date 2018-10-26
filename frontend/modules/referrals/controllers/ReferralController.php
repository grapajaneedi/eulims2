<?php

namespace frontend\modules\referrals\controllers;

use Yii;
use common\models\referral\Referral;
use common\models\referral\ReferralSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReferralController implements the CRUD actions for Referral model.
 */
class ReferralController extends Controller
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
     * Lists all Referral models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReferralSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Referral model.
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
     * Creates a new Referral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Referral();

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //    return $this->redirect(['view', 'id' => $model->referral_id]);
        //}

        if ($model->load(Yii::$app->request->post())) {
            /*if(isset($_POST['Sample']['sampling_date'])){
                $model->sampling_date = date('Y-m-d H:i:s', strtotime($_POST['Sample']['sampling_date']));
            } else {
                $model->sampling_date = date('Y-m-d H:i:s');
            }*/
            $model->referral_date = '0000-00-00';
            $model->referral_time = '';

            if($model->save(false)){
                Yii::$app->session->setFlash('success', $model->samplename." Successfully Updated.");
                return $this->redirect(['/lab/request/view', 'id' => $model->request_id]);

            }
        } elseif (Yii::$app->request->isAjax) {
                return $this->renderAjax('_form', [
                    'model' => $model,
                    //'testcategory' => $testcategory,
                    //'sampletype' => $sampletype,
                    //'labId' => $labId,
                    //'sampletemplate' => $this->listSampletemplate(),
                ]);
        } else {
            return $this->render('update', [
                'model' => $model,
                //'testcategory' => $testcategory,
                //'sampletype' => $sampletype,
                //'labId' => $labId,
                //'sampletemplate' => $this->listSampletemplate(),
            ]);
        }

        //return $this->render('create', [
        //    'model' => $model,
        //]);
    }

    /**
     * Updates an existing Referral model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->referral_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Referral model.
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
     * Finds the Referral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Referral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Referral::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
