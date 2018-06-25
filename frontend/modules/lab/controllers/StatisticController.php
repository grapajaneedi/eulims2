<?php

namespace frontend\modules\lab\controllers;

use Yii;
use yii\web\Controller;
use common\models\lab\Sample;
use common\models\lab\SampleSearch;
use common\models\lab\Request;
use frontend\modules\lab\models\Requestextend;
use common\models\lab\Lab;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;

class StatisticController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSamples()
    {
    	//$modelSample = new Sample();
    	//$searchModel = new SampleSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /*$dataProvider = new ActiveDataProvider([
            //'query' => $searchModel->search(Yii::$app->request->queryParams),
            'query' =>$modelSample,
            'pagination' => [
                'pagesize' => 10,
            ],
        ]);*/

        //$searchModel = new SampleSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->pagination->pageSize=11;

        /*$dataProvider = new ActiveDataProvider([
            //'query' => $searchModel->search(Yii::$app->request->queryParams),
            'query' =>$searchModel,
            'pagination' => [
                'pagesize' => 10,
            ],
        ]);*/

        /*$dataProvider = new ActiveDataProvider([
		    'query' => Sample::find(),
		    // 'pagination' => [
		    //     'pageSize' => 20,
		    // ],
		]);*/

		//$query = Yii::$app->labdb->createCommand('CALL spSummaryforSamples(11,1,"2018-05-01","2018-06-21",1,1)')
        //   ->queryAll();

        //echo "<pre>";
        //print_r($posts);
        //echo "</pre>";
        //$posts->pagination->pageSize=11;

		//$dataProvider = new SqlDataProvider([
		    //'sql' => 'CALL spSummaryforSamples(11,1,"2018-05-01","2018-06-21",1,1)',
		    //'sql' => 'CALL spSummaryforSamples(:rstlId,:labId,:startRequestDate,:endRequestDate,:type,:requestType)',
		    //'params' => [':rstlId'=>$GLOBALS['rstl_id'],':labId'=>$labId,':startRequestDate'=>$startDate,':endRequestDate'=>$endDate,':type'=>$summaryType,':requestType'=>$requestType],
		    //'totalCount' => $count,
		    //'sql' => $posts,
		   // 'pagination' => [
		   //     'pageSize' => 10,
		    //],
		    /*'sort' => [
		        'attributes' => [
		            'title',
		            'view_count',
		            'created_at',
		        ],
		    ],*/
		//]);

		// return $this->render('samplestat', [
  //           //'searchModel' => $searchModel,
  //           'dataProvider' => $posts,
  //           'laboratories' => $this->listLaboratory(),
  //       ]);

        //return $this->render('samplestat', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            //'sampletypes' => $this->listSampletype(),
        //]);
        //$count = Yii::$app->labdb->createCommand('CALL spSummaryforSamples(11,1,"2018-05-01","2018-06-21",1,1)')->queryScalar();

	    //$provider = new SqlDataProvider([
		    //'sql' => 'CALL spSummaryforSamples(11,1,"2018-05-01","2018-06-21",1,1)',
		    //'params' => [':status' => 1],
		    //'totalCount' => count($count),
		    //'pagination' => [
		      //  'pageSize' => 10,
		    //],
		    /*'sort' => [
		        'attributes' => [
		              ......
		        ],
		    ],*/
		//]);
	    //$query = new Query;
		// $query = Yii::$app->labdb->createCommand('CALL spSummaryforSamples(11,1,"2018-05-01","2018-06-21",1,1)')
	 //    ->queryAll();
		// $dataProvider = new ArrayDataProvider([
		//     //'allModels' => $query->from('post')->all(),
		//     'allModels' => $query,
		//     // 'sort' => [
		//     //     'attributes' => ['id', 'username', 'email'],
		//     // ],
		//     'pagination' => [
		//         'pageSize' => 10,
		//     ],
		// ]);

		//$modelRequest = new Request();
		//$modelRequest = Requestextend::find();
		$modelRequest = Requestextend::find()
						->with('samples')
						->where('status_id != :statusId', [':statusId'=>2])
						->addParams([':statusId'=>2])
						->groupBy(['DATE_FORMAT(request_datetime, "%Y-%m-%d")'])
						->orderBy('request_datetime DESC');
						//->all();
		//$query = Post::find()->where(['status' => 1]);
		//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$modelRequest1 = Requestextend::find()->where('status_id =:statusId', [':statusId'=>2]);
		$dataProvider = new ActiveDataProvider([
            //'query' => $searchModel->search(Yii::$app->request->queryParams),
            'query' =>$modelRequest,
            'pagination' => [
                'pagesize' => 10,
            ],
        ]);

		return $this->render('samplestat', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'laboratories' => $this->listLaboratory(),
        ]);

    	//return $this->render('index');
    }

    public function actionAccomplishment()
    {
    	return $this->render('index');
    }

    protected function listLaboratory()
    {
        $laboratory = ArrayHelper::map(Lab::find()->all(), 'lab_id', 
            function($laboratory, $defaultValue) {
                return $laboratory->labname;
        });

        return $laboratory;
    }

    /*public function countSample($labId,$startDate,$endDate,$summaryType,$requestType)
    {
    	$query = Yii::$app->labdb->createCommand('CALL spSummaryforSamples(11,1,"2018-05-01","2018-06-21",1,1)')
	    ->queryAll();

	    return $query;
    }

    protected static function countAnalysis($labId,$startDate,$endDate,$summaryType,$requestType)
    {
    	$query = Yii::$app->labdb->createCommand('CALL spSummaryforSamples(11,1,"2018-05-01","2018-06-21",2,1)')
	    ->queryAll();

	    return $query;
    }*/
}
