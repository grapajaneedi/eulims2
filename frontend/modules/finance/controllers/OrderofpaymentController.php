<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Orderofpayment;
use common\models\finance\Paymentitem;
use common\models\finance\Collection;
use common\models\finance\OrderofpaymentSearch;
use common\models\lab\Request;
use common\models\finance\Collectiontype;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use common\components\Functions;
use kartik\editable\Editable;
use yii\helpers\Json;
/**
 * OrderofpaymentController implements the CRUD actions for Orderofpayment model.
 */
class OrderofpaymentController extends Controller
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
     * Lists all Orderofpayment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Orderofpayment();
        $searchModel = new OrderofpaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Orderofpayment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    { 
         $paymentitem_Query = Paymentitem::find()->where(['orderofpayment_id' => $id]);
         $paymentitemDataProvider = new ActiveDataProvider([
                'query' => $paymentitem_Query,
                'pagination' => [
                    'pageSize' => 10,
                ],
        ]);
         
         return $this->render('view', [
            'model' => $this->findModel($id),
            'paymentitemDataProvider' => $paymentitemDataProvider,
        ]);

    }

    /**
     * Creates a new Orderofpayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orderofpayment();
        $searchModel = new OrderofpaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=5;
        
        //echo "<pre>";
        //print_r($this->Gettransactionnum());
        //echo "</pre>";
        
         if ($model->load(Yii::$app->request->post())) {
                $session = Yii::$app->session;
                $request_ids=$model->RequestIds;
                $str_request = explode(',', $request_ids);
                $model->rstl_id=$GLOBALS['rstl_id'];
                $model->transactionnum= $this->Gettransactionnum();
               
                $model->save();
               //Saving for Paymentitem
                $arr_length = count($str_request); 
                $total_amount=0;
                for($i=0;$i<$arr_length;$i++){
                     $request =$this->findRequest($str_request[$i]);
                     $paymentitem = new Paymentitem();
                     $paymentitem->rstl_id =$GLOBALS['rstl_id'];
                     $paymentitem->request_id = $str_request[$i];
                     $paymentitem->orderofpayment_id = $model->orderofpayment_id;
                     $paymentitem->details =$request->request_ref_num;
                     $paymentitem->amount = $request->total;
                     $total_amount+=$request->total;
                     $paymentitem->save(); 
                }
                //----------------------//
                //---Saving for Collection-------
                $collection= new Collection();
                $collection_name= getCollectionname($model->collectiontype_id);
                var_dump($collection_name);
                exit;
                $collection->rstl_id=$GLOBALS['rstl_id'];
                $collection->orderofpayment_id=$model->orderofpayment_id;
                $collection->referral_id=0;
                $collection->nature=$collection_name;
                $collection->amount=$total_amount;
                $collection->save();
              //  var_dump($total_amount);
              //  exit;
                //-------------------------------------------------------------//
                $session->set('savepopup',"executed");
                return $this->redirect(['/finance/orderofpayment']);
          
        } 
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->render('create', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        
    }

    /**
     * Updates an existing Orderofpayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->orderofpayment_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

     public function actionGetlistrequest($id)
    {
         $model= new Request();
        $query = Request::find()->where(['customer_id' => $id]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination->pageSize=3;
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_request', ['dataProvider'=>$dataProvider,'model'=>$model]);
        }
        else{
            return $this->render('_request', ['dataProvider'=>$dataProvider,'model'=>$model]);
        }

    }
    /**
     * Deletes an existing Orderofpayment model.
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
     * Finds the Orderofpayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orderofpayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orderofpayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findRequest($requestId)
    {
        if (($model = Request::findOne($requestId)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
     public function Gettransactionnum(){
        /*$year=date('Y');
        $terminal_id=1;
        $rstl_id=11;
        $result = \Yii::$app->financedb->createCommand("CALL spGenerateTransactionNumber(:mYear, :mTerminalID, :mRSTLID)",[
            ':mYear'=>$year,
            ':mTerminalID'=>$terminal_id,
            ':mRSTLID'=>$rstl_id
            ])
            ->queryAll();
        $transnumber=$result[0]['transaction_number'];
        return $transnumber;*/
          $year_month = date('Y-m');
          $last_trans_num=(new Query)
            ->select(['count(transactionnum)+ 1 AS lastnumber'])
            ->from('eulims_finance.tbl_orderofpayment')
            ->one();
          $str_trans_num=0;
          if($last_trans_num != ''){
              $str_trans_num=str_pad($last_trans_num["lastnumber"], 4, "0", STR_PAD_LEFT);
          }
          else{
               $str_trans_num='0000';
          }
         
         $next_transnumber=$year_month."-".$str_trans_num;
         return $next_transnumber;
        
     }
     
     public function actionCalculateTotal() {
    // if (isset($_POST['keylist'])) {
        $post = Yii::$app->request->post();
        $total = 0;
      // var_dump($post);
     //   exit;
        
        $str_total = explode(',', $post['keylist']);
        $arr_length = count($str_total); 
        for($i=0;$i<$arr_length;$i++){
             $request =$this->findRequest($str_total[$i]);
             $total+=$request->total;
        }
        echo $total;
       /* echo Json::encode([
            'status' => 'success',
            'total' => $total
        ]);*/
        
   // }
     }
     
     public function getCollectionname($collectionid) {
         $collection_name=(new Query)
            ->select(['natureofcollection'])
            ->from('eulims_finance.tbl_collectiontype')
            ->where(['collectiontype_id' => $collectionid]);
         return $collection_name;
     }
}
