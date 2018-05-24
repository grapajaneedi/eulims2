<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Accountingcodemapping;
use common\models\finance\AccountingcodemappingSearch;
use common\models\finance\AccountcodeWithoutMapping;
use common\models\finance\AccountcodeCollection;
use common\models\finance\Collectiontype;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;



/**
 * AccountingcodemappingController implements the CRUD actions for Accountingcodemapping model.
 */
class AccountingcodemappingController extends Controller
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
     * Lists all Accountingcodemapping models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new AccountingcodemappingSearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //return $this->render('index', [
        //    'searchModel' => $searchModel,
        //    'dataProvider' => $dataProvider,
       // ]);
        
      $model = new Accountingcodemapping();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->mapping_id]);
        }
        
        $sql = "Call spGetAccountCodeWithoutMapping()";
        
        $modelAccountCode = new AccountcodeWithoutMapping();
        $dataProviderAccountCode = ArrayHelper::map(Yii::$app->financedb->createCommand($sql)->queryAll(),'accountingcode_id','accountcode');

        $modelCollectionType = new Collectiontype();
        $dataProviderCollectionType= ArrayHelper::map(Collectiontype::find()->all(),'collectiontype_id','natureofcollection');
        
        $sqlGrid = "Call spGetAccountMapping()";
        $modelAccountCollection = new AccountcodeCollection();
       // $dataProviderAccountCollection =  Yii::$app->financedb->createCommand($sqlGrid)->queryAll();
        
      //  $dataProviderAccountCollection = new SqlDataProvider([
    //'sql' => 'Call spGetAccountMapping()']);
        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM eulims_finance.tbl_accountingcodemapping')->queryScalar();

        $dataProviderAccountCollection = new SqlDataProvider([
            'sql' => 'Call eulims_finance.spGetAccountMapping();',
            
            'totalCount' => $count,
           
           
        ]);
        
     
        
        if (Yii::$app->request->isAjax)
        {
        return $this->renderAjax('index', [
            'model' => $model,
            'modelAccountCode' =>  $modelAccountCode,
            'dataProviderAccountCode' => $dataProviderAccountCode,
            'modelCollectionType' =>$modelCollectionType,
            'dataProviderCollectionType' =>$dataProviderCollectionType,
            'modelAccountCollection' => $modelAccountCollection,
            'dataProviderAccountCollection' => $dataProviderAccountCollection
        ]);
        }
        
        else
            
        {
            return $this->redirect(['accountingcode/index']);
            /*
            return $this->render('create', [
            'model' => $model,
            'modelAccountCode' =>  $modelAccountCode,
            'dataProviderAccountCode' => $dataProviderAccountCode,
            'modelCollectionType' =>$modelCollectionType,
            'dataProviderCollectionType' =>$dataProviderCollectionType,
            'modelAccountCollection' => $modelAccountCollection,
            'dataProviderAccountCollection' => $dataProviderAccountCollection
             *
             
         ]);*/
        }
    }

    /**
     * Displays a single Accountingcodemapping model.
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
     * Creates a new Accountingcodemapping model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model = new Accountingcodemapping();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->mapping_id]);
        }
        
        $sql = "Call spGetAccountCodeWithoutMapping()";
        
        $modelAccountCode = new AccountcodeWithoutMapping();
        $dataProviderAccountCode = ArrayHelper::map(Yii::$app->financedb->createCommand($sql)->queryAll(),'accountingcode_id','accountcode');

        $modelCollectionType = new Collectiontype();
        $dataProviderCollectionType= ArrayHelper::map(Collectiontype::find()->all(),'collectiontype_id','natureofcollection');
        
        $sqlGrid = "Call spGetAccountMapping()";
        $modelAccountCollection = new AccountcodeCollection();
       // $dataProviderAccountCollection =  Yii::$app->financedb->createCommand($sqlGrid)->queryAll();
        
      //  $dataProviderAccountCollection = new SqlDataProvider([
    //'sql' => 'Call spGetAccountMapping()']);
        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM eulims_finance.tbl_accountingcodemapping')->queryScalar();

        $dataProviderAccountCollection = new SqlDataProvider([
            'sql' => 'Call eulims_finance.spGetAccountMapping();',
            
            'totalCount' => $count,
         
          
        ]);
        
        $dataProviderAccountCollection->setTotalCount($count);
        
        if (Yii::$app->request->isAjax)
        {
        return $this->renderAjax('create', [
            'model' => $model,
            'modelAccountCode' =>  $modelAccountCode,
            'dataProviderAccountCode' => $dataProviderAccountCode,
            'modelCollectionType' =>$modelCollectionType,
            'dataProviderCollectionType' =>$dataProviderCollectionType,
            'modelAccountCollection' => $modelAccountCollection,
            'dataProviderAccountCollection' => $dataProviderAccountCollection
        ]);
        }
        
        else
            
        {
            return $this->render('create', [
            'model' => $model,
            'modelAccountCode' =>  $modelAccountCode,
            'dataProviderAccountCode' => $dataProviderAccountCode,
            'modelCollectionType' =>$modelCollectionType,
            'dataProviderCollectionType' =>$dataProviderCollectionType,
            'modelAccountCollection' => $modelAccountCollection,
            'dataProviderAccountCollection' => $dataProviderAccountCollection
        ]);
        }
        
        
    }
    
     public function actionDropdown()
    {
    //$db = 'financedb';
    //     $searchModel = new PackageDetailsSearch();
    //    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $sql = "Call spGetAccountCodeWithoutMapping()";
        $modelAccountCode = new AccountcodeWithoutMapping();
        $dataProviderAccountCode = ArrayHelper::map(Yii::$app->financedb->createCommand($sql)->queryAll(),'accountingcode_id','accountcode');

        $modelCollectionType = new Collectiontype();
        $dataProviderCollectionType= ArrayHelper::map(Collectiontype::find()->all(),'collectiontype_id','natureofcollection');
        
      //   $model= $searchModel->loadsp();
                 //new AccountcodeWithoutMapping();
         
         
       
    // passing the params into to the sql query
    
    // execute the sql command
       
        
        return $this->render('dropdown', [
            'modelAccountCode' =>  $modelAccountCode,
            'dataProviderAccountCode' => $dataProviderAccountCode,
            'modelCollectionType' =>$modelCollectionType,
           'dataProviderCollectionType' =>$dataProviderCollectionType
        ]);
    }

    /**
     * Updates an existing Accountingcodemapping model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->mapping_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Accountingcodemapping model.
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
     * Finds the Accountingcodemapping model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Accountingcodemapping the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Accountingcodemapping::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
