<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Cancelledrequest;
use common\models\lab\CancelledrequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\lab\Request;
use common\models\finance\Paymentitem;
use common\models\lab\Sample;
use common\components\Functions;
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
        echo "<pre>";
        var_dump(Yii::$app->request->post());
        echo "</pre>";
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Check if this request is already been cancelled
            $FinanceSuccess=false;
            $Connection= Yii::$app->labdb;
            $Transaction =$Connection->beginTransaction();
            //Update Request
            $Request= Request::find()->where(['request_id'=>$model->request_id])->one();
            $Request->status_id=0;//Cancelled
            $Request->payment_status_id=0;
            $request_id=$model->request_id;
            // Update Receipt
            $SQLReceipt="SELECT GROUP_CONCAT(`receipt_id`) FROM `tbl_paymentitem` WHERE `request_id`=:request_id";
            $FinanceConnection=Yii::$app->financedb;
            $FinanceTransaction =$FinanceConnection->beginTransaction();
            $Command=$FinanceConnection->createCommand($SQLReceipt);
            $Command->bindValue(":request_id", $request_id);
            $recept_ids=$Command->execute();
            //$query = (new \yii\db\Query())->from('tbl_paymentitem')->where(['request_id'=>$model->request_id]);
            //$sum = $query->sum('amount');
            if($Request->save(false)){//Check if there is sample
                $exRequest=new Functions();
                $HasReceipt=$exRequest->IsRequestHasReceipt($Request->request_id);
                if($HasReceipt){
                    //Get the total amount from receipt
                    $TotalAmountSQL="SELECT SUM(`total`) AS TotalSum FROM `tbl_receipt` WHERE `receipt_id` IN($recept_ids)";
                    $Command2=$Connection->createCommand($TotalAmountSQL);
                    $TotalAmountOfReceipt=$Command2->execute();
                    // update Receipt
                    $ReceiptUpdate="UPDATE `tbl_receipt` SET `receipt_status_id`=2 WHERE `receipt_id` IN($recept_ids)";
                    //Execute command
                    $Command3=$Connection->createCommand($ReceiptUpdate);
                    $Command3->execute();
                    // Execute action to save to wallet
                    $func=new Functions();
                    $ISCredit=0;
                    $customer_id=$Request->customer_id;
                    $FinanceSuccess=$func->SetWallet($customer_id,$TotalAmountOfReceipt, $recept_ids, $ISCredit);
                }
                $SampleCount= Sample::find()->where(['request_id'=>$model->request_id])->count();
                if($SampleCount>0){
                    return $this->redirect(['/lab/sample/cancel', 'id' => $model->request_id]);
                }else{
                    Yii::$app->session->setFlash('success', 'Request Successfully Cancelled!');
                    $Transaction->commit();
                    $FinanceTransaction->commit();
                    return $this->redirect(['/lab/request/view', 'id' => $model->request_id]); 
                }
            }else{
                Yii::$app->session->setFlash('danger', 'Request Failed to Cancelled!');
                $Transaction->rollback();
                $FinanceTransaction->rollback();
                return $this->redirect(['/lab/request/view', 'id' => $model->request_id]); 
            }
        } else {
            $Request_id=$get['req'];
            $model->cancel_date=date('Y-m-d H:i:s');
            $HasOP= Paymentitem::find()->where(['request_id'=>$Request_id])->count();
            $exRequest=new Functions();
            $HasReceipt=$exRequest->IsRequestHasReceipt($Request_id);
            if(\Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                    'Req_id'=> $Request_id,
                    'HasOP'=>$HasOP,
                    'HasReceipt'=>$HasReceipt
                ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'Req_id'=> $Request_id,
                    'HasOP'=>$HasOP,
                    'HasReceipt'=>$HasReceipt
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
