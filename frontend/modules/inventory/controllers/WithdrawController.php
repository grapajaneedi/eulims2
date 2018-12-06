<?php

namespace frontend\modules\inventory\controllers;

use Yii;
use common\models\inventory\InventoryWithdrawal;
use common\models\inventory\InventoryWithdrawalSearch;
use common\models\inventory\InventoryEntries;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\inventory\Products;
use common\models\inventory\InventoryWithdrawaldetails;

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
             $dataProvider = new ActiveDataProvider([
            'query' =>Products::find()->where(['like', 'product_name', $varsearch]),
            'pagination' => [
                'pageSize' => 10,
            ],
             ]);

        }

        $session = Yii::$app->session;

          return $this->render('withdraw',['dataProvider'=>$dataProvider,'searchkey'=>$varsearch,'session'=>$session]);
    }

    public function actionIncart($id){
        $product = Products::findOne($id);
        $entries = InventoryEntries::find()->with('suppliers')->where(['product_id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $entries,
        ]);

        $var = Yii::$app->request->post();
         if ($var) {
            $ctr=0;
            //use session to add to cart
            //refer to the code written on the old ulims inventory

            foreach ($var as $key => $value) {
                if($ctr>0){
                    
                     $var2 = explode("_", $key);
                    
                     
                     if($value){
                        $this->customsave($var2[0],$value);
                     }
                }
                $ctr++;
            }
            
            return $this->redirect(['out']);
         }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('cartin', [
                'dataProvider'=>$dataProvider,
                'product'=>$product
            ]);
        }
        else {
            return $this->render('cartin', [
               'dataProvider'=>$dataProvider,
               'product'=>$product
            ]);
        }
    }

    protected function customsave($id,$value){
        $session = Yii::$app->session;
        $unserialize = [];
        if($session->has('cart')){
            $unserialize = unserialize($session['cart']);
        }
        //get the inventory entry along with the product profile
        $entry = InventoryEntries::find()->with('product')->where(['inventory_transactions_id' => $id])->one();
        
        $mthrarry = array();
        $myarry = array(
            'ID'=>$id,
            'Item'=> $entry->product->product_code, //code
            'Name'=>$entry->product->product_name, //oroduct name
            'Quantity'=> $value, //qty to order
            'Cost'=> $entry->amount, //price per product
            'Subtotal'=>$entry->amount * $value, //qty x price
            );
        
        $key = $this->find_order_with_item($unserialize,$myarry['ID']);
        // echo $key; exit();
        if($key!==false){
            $unserialize[$key]['Quantity'] = $unserialize[$key]['Quantity'] + $myarry['Quantity'];
            $unserialize[$key]['Subtotal'] = $unserialize[$key]['Subtotal'] + $myarry['Subtotal'];
            $session['cart'] = serialize($unserialize);
        }else if($unserialize==""){

            array_push($mthrarry, $myarry);
            $session['cart'] = serialize($mthrarry);
        }else{
            array_push($unserialize, $myarry);
            $session['cart'] = serialize($unserialize);
        }
    }

    protected function find_order_with_item($orders, $item) {
        foreach($orders as $index => $order) {
            if($order['ID'] == $item) return $index;
        }
        return FALSE;
    }

    public function actionDestroyitem($itemid){

        $session = Yii::$app->session;
        $unserialize = unserialize($session['cart']);

        //find the item in the array and stored it in #key variable
        $key = $this->find_order_with_item($unserialize,$itemid);

        //delete the array of that item
        if($key!==false){
            
            array_splice($unserialize,$key,1);
            $session['cart'] = serialize($unserialize);
        }

        //redirect to the withdraw/out
        return $this->redirect(['out']);
    }

    public function actionDestroyall(){
        $session = Yii::$app->session;
        $session['cart']=serialize([]);
        return $this->redirect(['out']);
    }

    public function actionOutcart(){
        //gather data from cart
        $session = Yii::$app->session;
        

        //try
        try {
            //begin transaction
            $connection = Yii::$app->inventorydb;
            $transaction = $connection->beginTransaction();

            if($session->has('cart')){
                $cart = unserialize($session['cart']);
                $begin = 0;
                //while{
                foreach ($cart as $key) {

                    //check avaialbility of withdrawal product ~> else proceed to A. [collect info for system visibility]

                    //query for the inventoryentries
                    // $entry = InventoryEntries::find(['inventory_transactions_id'=>$key['ID']])->with('product')->one();
                    $entry = InventoryEntries::findOne($key['ID']);

                    // var_dump($entry);exit;

                    //query for the withdrawaldetails and sum up all the qty withdrawn
                    $withdrawn = InventoryWithdrawaldetails::find()->where(['inventory_transactions_id'=>$key['ID']])->sum('quantity');

                    $qty = (int)$entry->quantity - (int)$withdrawn; //we get the quantity that is withdrawable

                    //compare else throw ERR
                    // cart qty > withdrawable ~> throw ERR
                    if($key['Quantity']>$qty){
                        throw new Exception("Withdrawable Quantity is less than the desired Quantity!", 1);
                    }

                    //execute calculations
                    //subtract qty in Product tbl
                    $product = Products::find()->where(['product_code'=>$key['Item']])->one();
                    $product->qty_onhand = $product->qty_onhand - $key['Quantity'];
                    if($product->save()){
                        $header="";
                        if($begin==0){


                            //create record in withdrawal and details table
                            $header = new InventoryWithdrawal();
                            $header->created_by=Yii::$app->user->id;
                            $header->withdrawal_datetime=date('Y-m-d');
                            if(Yii::$app->user->identity->profile){
                                $header->lab_id= Yii::$app->user->identity->profile->lab_id;
                            }else{
                                // $header->lab_id= 0;
                                throw new Exception("User has no Lab_id!", 1);
                            }
                            $header->total_qty=$key['Quantity'];
                            $header->total_cost=$key['Subtotal'];
                            $header->remarks="N/A";
                            if($header->save()){
                                $begin=$header->inventory_withdrawal_id;
                            }
                            else{
                                throw new Exception("Cannot save header of Withdrawal Items!", 1);
                            }
                        }else{

                            //update record in withdrawal and details table
                            $header = InventoryWithdrawal::findOne($begin);
                            $header->total_qty=$header->total_qty+$key['Quantity'];
                            $header->total_cost=$header->total_cost+$key['Subtotal'];
                           if(!$header->save()){
                                throw new Exception("Cannot update header of Withdrawal Items!", 1);
                            }
                        }

                        //create record of withdrawal item
                        $item = new InventoryWithdrawaldetails();
                        $item->inventory_withdrawal_id =$begin;
                        $item->inventory_transactions_id=$key['ID'];
                        $item->quantity=$key['Quantity'];
                        $item->price=$key['Subtotal'];
                        $item->withdarawal_status_id=2;
                        if($item->save()){
                            $session['cart']=serialize([]);
                            $transaction->commit();
                        }
                        
                    }else{
                        throw new Exception("Can't update Product Quantity!", 1);
                    }

                   
                }
            }      

            //end transaction 
        } catch (Exception $e) {
             $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
        

        
         return $this->redirect(['out']);
    }
}
