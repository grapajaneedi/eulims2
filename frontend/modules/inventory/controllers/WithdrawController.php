<?php

namespace frontend\modules\inventory\controllers;

use Yii;
use common\models\inventory\InventoryWithdrawal;
use common\models\inventory\InventoryWithdrawalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\inventory\Products;

/**
 * WithdrawController implements the CRUD actions for InventoryWithdrawal model.
 */
class WithdrawController extends Controller
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
     * Lists all InventoryWithdrawal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventoryWithdrawalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InventoryWithdrawal model.
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
     * Creates a new InventoryWithdrawal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InventoryWithdrawal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->inventory_withdrawal_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing InventoryWithdrawal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->inventory_withdrawal_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing InventoryWithdrawal model.
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
     * Finds the InventoryWithdrawal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InventoryWithdrawal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventoryWithdrawal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

     public function actionOut($varsearch=""){
        // $product=Products::find()->limit(20)->all();
        $dataProvider = new ActiveDataProvider([
            'query' =>Products::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if($varsearch){
              // $inventory=InventoryEntries::find('product')->where('like','product_name',$_GET['varsearch']);
              
              // var_dump($product); exit;
        }

          return $this->render('withdraw',['dataProvider'=>$dataProvider,'searchkey'=>$varsearch]);
    }

    public function actionIncart(){
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('cartin', [
                
            ]);
        }
        else {
            return $this->render('cartin', [
               
            ]);
        }
    }
}
