<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\AnalysisSearch;
use common\models\lab\SampleregisterSearch;
use common\models\lab\SampleregisterUser;
use common\models\lab\Tagging;
use common\models\lab\TaggingSearch;
use common\models\lab\SampleSearch;
use common\models\lab\Sampletype;
use common\models\lab\Testcategory;
use common\models\lab\Request;
use common\models\lab\Lab;
use common\models\lab\Samplecode;
use common\models\lab\SampleName;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Response;
use kartik\mpdf\Pdf;
use yii\db\ActiveQuery;

class SampleregisterController extends Controller
{
    public function actionIndex()
    {
        $model = new Analysis;
        //return $this->render('index');
        //$searchModel = new SampleSearch();

        //$a = new Analysis();
        //$b = Analysis::findOne(37080)->taggings;

        //$searchModel = new AnalysisSearch();
        //$searchModel = new SampleregisterSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /*$dataProvider = new ActiveDataProvider([
            //'query' => $searchModel->search(Yii::$app->request->queryParams),
            'query' =>$searchModel,
            'pagination' => [
                'pagesize' => 10,
            ],
        ]);*/

        //echo "<pre>";
        //print_r($b['start_date']);
        //echo "</pre>";

        $query = Analysis::find();
        $query->joinWith(['sample','sample.request','taggings']);
        //$query->joinWith(['sample','sample.request','taggings'], true, 'INNER JOIN');
        //$query->joinType('INNER JOIN');
        $query->orderBy([
          'tbl_sample.sample_code' => SORT_ASC,
          'tbl_request.request_datetime'=>SORT_DESC,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionUser()
    {
        //$modelTagging = new Tagging;
        $userId = 1;
        $user = SampleregisterUser::find()
            ->joinWith('user')
            ->where('user_id =:userId',[':userId'=>$userId])
            ->one();
    }

}
