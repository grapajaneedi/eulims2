<?php

namespace frontend\modules\inventory\controllers;

use Yii;
use common\models\inventory\Products;
use common\models\inventory\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\system\Profile;
use yii\web\UploadedFile;
use common\models\inventory\Suppliers;
use common\models\inventory\SuppliersSearch;
use yii\data\ActiveDataProvider;
use common\models\inventory\Equipmentservice;
use frontend\modules\inventory\components\_class\Equipmentevent;
/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerInventoryEntries = new \yii\data\ArrayDataProvider([
            'allModels' => $model->inventoryEntries,
        ]);
        $providerInventoryWithdrawaldetails = new \yii\data\ArrayDataProvider([
            'allModels' => $model->inventoryWithdrawaldetails,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerInventoryEntries' => $providerInventoryEntries,
            'providerInventoryWithdrawaldetails' => $providerInventoryWithdrawaldetails,
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();

        $user_id=Yii::$app->user->identity->profile->user_id;
        $model->created_by=$user_id;
        $model->qty_onhand=0;
        if ($model->load(Yii::$app->request->post())) {
            $ids= implode(',',$model->suppliers_ids);
            $model->suppliers_ids=$ids;
            $filename=$model->product_name;
            $filename2=$model->product_name."2";
            if(!empty($model->Image1))
            {
                $model->Image1 = UploadedFile::getInstance($model,'Image1');
                $model->Image1->saveAs('uploads/products/'.$filename.'.'.$model->Image1->extension);
                $model->Image1='uploads/products/'.$filename.'.'.$model->Image1->extension;
            }
            if(!empty($model->Image2))
            {
                $model->Image2 = UploadedFile::getInstance($model,'Image2');
                $model->Image2->saveAs('uploads/products/'.$filename2.'.'.$model->Image2->extension);
                $model->Image2='uploads/products/'.$filename2.'.'.$model->Image2->extension;
            }
            $model->save();
            
            Yii::$app->session->setFlash('success', 'Product Successfully Added!');
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           // return $this->redirect(['view', 'id' => $model->product_id]);
            Yii::$app->session->setFlash('success', 'Product Successfully Updated!');
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }
    
    /**
     * 
     * Export Products information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerInventoryEntries = new \yii\data\ArrayDataProvider([
            'allModels' => $model->inventoryEntries,
        ]);
        $providerInventoryWithdrawaldetails = new \yii\data\ArrayDataProvider([
            'allModels' => $model->inventoryWithdrawaldetails,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerInventoryEntries' => $providerInventoryEntries,
            'providerInventoryWithdrawaldetails' => $providerInventoryWithdrawaldetails,
        ]);

        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_CORE,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => \Yii::$app->name],
            'methods' => [ 
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    
    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for InventoryEntries
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddInventoryEntries()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('InventoryEntries');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formInventoryEntries', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for InventoryWithdrawaldetails
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddInventoryWithdrawaldetails()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('InventoryWithdrawaldetails');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formInventoryWithdrawaldetails', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionSupplier($ids) {
        $str= explode(',', $ids);
        $searchModel = new SuppliersSearch();
        $query = Suppliers::find()->where(['IN', 'suppliers_id', $str]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 10,
            ],
        ]);
        
        return $this->renderAjax('_supplier', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEquipment($varsearch=""){
        $dataProvider = new ActiveDataProvider([
            'query' =>Products::find()->where(['producttype_id'=>2]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if($varsearch){
             $dataProvider = new ActiveDataProvider([
            'query' =>Products::find()->where(['like', 'product_name', $varsearch],['producttype_id'=>2]),
            'pagination' => [
                'pageSize' => 10,
            ],
             ]);

        }

          return $this->render('equipment',['dataProvider'=>$dataProvider,'searchkey'=>$varsearch]);
    }

    public function actionOpensched($id){

        //retrieve the schedules using the $id

         if(Yii::$app->request->isAjax){
            return $this->renderAjax('_schedule', [
                
            ]);
        }
        else {
            return $this->render('_schedule', [
              
            ]);
        }
    }

    public function actionJsoncalendar($start=NULL,$end=NULL,$_=NULL){

    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


    $events = array();

    $Event= new Equipmentevent();
    $Event->id = 1;
    $Event->title = 'Equipmentevent Testing';
    $Event->start = date('Y-m-d\TH:i:s\Z');
    // $event->nonstandard = [
    //     'field1' => 'Something I want to be included in object #1',
    //     'field2' => 'Something I want to be included in object #2',
    //   ];
    $events[] = $Event;
    

  
    // foreach ($times AS $time){
    //   //Testing
    //   $Event = new \yii2fullcalendar\models\Event();
    //   $Event->id = $time->id;
    //   $Event->title = $time->categoryAsString;
    //   $Event->start = date('Y-m-d\TH:i:s\Z',strtotime($time->date_start.' '.$time->time_start));
    //   $Event->end = date('Y-m-d\TH:i:s\Z',strtotime($time->date_end.' '.$time->time_end));
    //   $events[] = $Event;
    // }


    // $Event= new bergevent();
    // $Event->id = 1;
    // $Event->title = 'Testing';
    // $Event->start = date('Y-m-d\TH:i:s\Z');
    // $event->nonstandard = [
    //     'field1' => 'Something I want to be included in object #1',
    //     'field2' => 'Something I want to be included in object #2',
    //   ];
    // $events[] = $Event;

    return $events;
  }

  public function actionDayClickCalendarEvent()
{
 //save date
    echo "wow"; exit;
}

}

 