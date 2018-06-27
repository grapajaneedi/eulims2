<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Op;
use common\models\finance\Paymentitem;
use common\models\finance\Collection;
use common\models\finance\OpSearch;
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
use yii2mod\alert\Alert;
/**
 * OrderofpaymentController implements the CRUD actions for Op model.
 */
class OpController extends Controller
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
     * Lists all Op models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Op();
        $searchModel = new OpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Op model.
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
     * Creates a new Op model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Op();
        $paymentitem = new Paymentitem();
        $collection= new Collection();
        $searchModel = new OpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=5;
        
        //echo "<pre>";
        //print_r($this->Gettransactionnum());
        //echo "</pre>";
        
         if ($model->load(Yii::$app->request->post())) {
             $transaction = Yii::$app->financedb->beginTransaction();
             $session = Yii::$app->session;
             try  {
                     $request_ids=$model->RequestIds;
                     $str_request = explode(',', $request_ids);
                  //   $wallet=$this->checkCustomerWallet($model->customer_id); 
                     $arr_length = count($str_request); 
                     $total_amount=0;
                        $model->rstl_id=$GLOBALS['rstl_id'];
                        $model->transactionnum= $this->Gettransactionnum();
                        if ($model->payment_mode_id == 6){
                            $model->on_account=1;
                        }else{
                            $model->on_account=0;
                        }
                        $model->save();
                       //Saving for Paymentitem
                        
                        for($i=0;$i<$arr_length;$i++){
                             $request =$this->findRequest($str_request[$i]);
                             $paymentitem = new Paymentitem();
                             $paymentitem->rstl_id =$GLOBALS['rstl_id'];
                             $paymentitem->request_id = $str_request[$i];
                             $paymentitem->orderofpayment_id = $model->orderofpayment_id;
                             $paymentitem->details =$request->request_ref_num;
                             $paymentitem->amount = $request->total;
                             $paymentitem->request_type_id =$request->request_type_id;
                             $total_amount+=$request->total;
                             $paymentitem->save(); 
                        }
                        //----------------------//
                        //---Saving for Collection-------

                        $collection_name= $this->getCollectionname($model->collectiontype_id);
                        $collection->nature=$collection_name['natureofcollection'];
                        $collection->rstl_id=$GLOBALS['rstl_id'];
                        $collection->orderofpayment_id=$model->orderofpayment_id;
                        $collection->referral_id=0;
                        $collection->save(false);
                        //
                        $transaction->commit();
                        $this->postRequest($request_ids);
                        $this->updateTotalOP($model->orderofpayment_id, $total_amount);
                        $session->set('savepopup',"executed");
                         return $this->redirect(['/finance/op']); 
                    
                        
                    
                } catch (Exception $e) {
                    $transaction->rollBack();
                   $session->set('errorpopup',"executed");
                   return $this->redirect(['/finance/op']);
                }
                
              //  var_dump($total_amount);
              //  exit;
                //-------------------------------------------------------------//
               
          
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
        $query = Request::find()->where(['customer_id' => $id,'posted' => 0])->andWhere(['not', ['request_ref_num' => null]]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       // $dataProvider->pagination->pageSize=3;
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_request', ['dataProvider'=>$dataProvider,'model'=>$model]);
        }
        else{
            return $this->render('_request', ['dataProvider'=>$dataProvider,'model'=>$model]);
        }

    }
    /**
     * Deletes an existing Op model.
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
     * Finds the Op model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Op the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Op::findOne($id)) !== null) {
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
          $lastyear=(new Query)
            ->select('MAX(transactionnum) AS lastnumber')
            ->from('eulims_finance.tbl_orderofpayment')
            ->one();
          $lastyear=substr($lastyear["lastnumber"],0,4);
          $year=date('Y');
          $year_month = date('Y-m');
          $last_trans_num=(new Query)
            ->select(['count(transactionnum)+ 1 AS lastnumber'])
            ->from('eulims_finance.tbl_orderofpayment')
            ->one();
          $str_trans_num=0;
          if($last_trans_num != ''){
              if($lastyear < $year){
                 $str_trans_num='0001'; 
              }
              else if($lastyear == $year){
                  $str_trans_num=str_pad($last_trans_num["lastnumber"], 4, "0", STR_PAD_LEFT);
              }
              
          }
          else{
               $str_trans_num='0001';
          }
        
         $next_transnumber=$year_month."-".$str_trans_num;
         return $next_transnumber;
        
     }
     
     public function actionCalculateTotal($id) {
        $total = 0;
        if($id == '' ){
            echo $total;
        }
        else{
            $str_total = explode(',', $id);
            $arr_length = count($str_total); 
            for($i=0;$i<$arr_length;$i++){
                 $request =$this->findRequest($str_total[$i]);
                 $total+=$request->total;
            }
            echo $total;
        }
     }
     
     public function getCollectionname($collectionid) {
         $collection_name=(new Query)
            ->select('natureofcollection')
            ->from('eulims_finance.tbl_collectiontype')
            ->where(['collectiontype_id' => $collectionid])
            ->one();
         return $collection_name;
     }
     
       // updating request as posted upon saving order of payment
     public function postRequest($reqID){
         $str_total = explode(',', $reqID);
          $arr_length = count($str_total); 
            for($i=0;$i<$arr_length;$i++){
               Yii::$app->labdb->createCommand()
             ->update('tbl_request', ['posted' => 1], 'request_id= '.$str_total[$i])
             ->execute(); 
            }
     }
     
     public function updateTotalOP($id,$total){
        
        Yii::$app->financedb->createCommand()
      ->update('tbl_orderofpayment', ['total_amount' => $total], 'orderofpayment_id= '.$id)
      ->execute(); 
            
     }
     
      public function actionCheckCustomerWallet($customerid) {
         $wallet=(new Query)
            ->select('balance')
            ->from('eulims_finance.tbl_customerwallet')
            ->where(['customer_id' => $customerid])
            ->one();
         echo $wallet["balance"];
     }
     /*public function actionListpaymentmode($customerid){
         $func=new Functions();
         $paymentlist=$func->GetPaymentModeList($customerid);
         return $paymentlist;
     }*/
    
      public function actionListpaymentmode() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $func=new Functions();
            $list = $func->GetPaymentModeList($id);
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $paymentlist) {
                    $out[] = ['id' => $paymentlist['payment_mode_id'], 'name' => $paymentlist['payment_mode']];
                    if ($i == 0) {
                        $selected = $paymentlist['payment_mode_id'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }
}
