<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Customerwallet;
use common\models\finance\CustomerwalletSearch;
use common\models\finance\Customertransaction;
use common\models\finance\CustomertransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomertransactionController implements the CRUD actions for Customertransaction model.
 */
class CustomertransactionController extends Controller
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
     * Lists all Customertransaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $searchModel = new CustomertransactionSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);

        $searchwallet = new CustomerWalletSearch();
        $walletdataProvider = $searchwallet->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchwallet' => $searchwallet,
            'walletdataProvider' => $walletdataProvider,
        ]);
    }

    /**
     * Displays a single Customertransaction model.
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
     * Creates a new Customertransaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($customerwallet_id)
    {

        $model = new Customertransaction();

         if ($model->load(Yii::$app->request->post())) {
            $model->date= date('Y-m-d h:i:s');
            //0 = credit ,1 = debit
            $model->transactiontype=0;
            $model->updated_by=Yii::$app->user->id;
            // if($model->save(false)){
                $wallet = Customerwallet::find()->where(['customerwallet_id' => $model->customerwallet_id])->one();
                $wallet->balance = $wallet->balance + $model->amount;
                // $wallet->last_update=date('Y-m-d  h:i:s');
                if($wallet->save()){
                    $session = Yii::$app->session;
                    $model->balance= $wallet->balance;
                    $model->save();
                    $session->set('savepopup',"executed");
                    return $this->redirect(['/finance/customerwallet']);
                }
            // }

        }
        
        if(Yii::$app->request->isAjax){
             
            return $this->renderAjax('create', [
                'model' => $model,
                'customerwallet_id'=>$customerwallet_id
            ]);
                
        }else{  
           
            return $this->render('create', [
                'model' => $model,
                'customerwallet_id'=>$customerwallet_id
            ]);
        }
    }

    /**
     * Updates an existing Customertransaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->customertransaction_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customertransaction model.
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
     * Finds the Customertransaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customertransaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customertransaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetwallet($customer_id,$amount,$source,$transactiontype){
        $myvar = setTransaction($customer_id,$amount,$source,$transactiontype);

        return $myvar;
    }

    protected function setTransaction($customer_id,$amount,$source,$transactiontype){
        //$transactiontype 0 = credit, 1= debit ,2= initial
        $transac = new Customertransaction();
        $transac->transactiontype=$transactiontype;
        $transac->updated_by==Yii::$app->user->id;
        $transac->amount=$amount;
        $transac->date=date('Y-m-d');
        $transac->source=$source;
        $wallet = Customerwallet::find()->where(['customerwallet_id' => $customer_id])->one();
        if($wallet){
             switch($transactiontype){
                case 0:
                    //credit transactiontype
                    $wallet->balance = $wallet->balance + $transac->amount;

                break;
                case 1:
                    //debit transaction type
                    $wallet->balance = $wallet->balance - $transac->amount;
                break;
                case 2:
                    //initial transaction
                    //compiler cant go  here
                break;
                default:
                    return false;
             }

             //save the wallet information
             if($wallet->save()){
                $transac->balance=$wallet->balance;
                $transac->customerwallet_id=$wallet->customerwallet_id;
                if($transac->save()){
                    return $transac->balance;
                }else{
                    return false;
                }
             }
        }else{
            //make wallet
            $newwallet = New Customerwallet();
            $newwallet->date = date('Y-m-d h:i:s');
            $newwallet->last_update = date('Y-m-d h:i:s')
            $newwallet->balance=$amount;
            $newwallet->customer_id=$customer_id;
            if($newwallet->save()){
                $transac = new Customertransaction();
                $transac->updated_by=Yii::$app->user->id;
                $transac->date=date('Y-m-d h:i:s')
                $transac->transactiontype=2;
                $transac->amount=$amount;
                $transac->balance=$amount;
                $transac->customerwallet_id=$customer_id
                $transac->source=$source;
                if($transac->save()){
                    $transac->amount;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            return false;
        }

    }
}
