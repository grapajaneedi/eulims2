<?php

namespace frontend\modules\reports\modules\lab\controllers;

use Yii;
use yii\web\Controller;
use common\models\lab\Sample;
use common\models\lab\SampleSearch;
use common\models\lab\Request;
use frontend\modules\reports\modules\models\Requestextend;
use common\models\lab\Lab;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;

class StatisticController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSamples()
    {
    	//$session = Yii::$app->session;

    	$model = new Requestextend;

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
		if (Yii::$app->request->get())
		{
			$labId = (int) Yii::$app->request->get('lab_id');
			
			if($this->checkValidDate(Yii::$app->request->get('from_date')) == true)
			{
		        //$valid = true;
		        $fromDate = Yii::$app->request->get('from_date');
			} else {
				//$fromDate = date('Y-m-01'); //first day of the month
				//$valid = false;
				// echo Json::encode([
    //         		'status'=>'failure',
    //     		]);
				$fromDate = date('Y-m-d');
				Yii::$app->session->setFlash('error', "Not a valid date!");
			}

			if($this->checkValidDate(Yii::$app->request->get('to_date')) == true){
				//$valid = true;
				$toDate = Yii::$app->request->get('to_date');
			} else {
				//$toDate = date('Y-m-d'); //as of today
				// echo Json::encode([
    //         		'status'=>'failure',
    //     		]);
				$toDate = date('Y-m-d');
				Yii::$app->session->setFlash('error', "Not a valid date!");
			}

		} else {
			$labId = 1;
			$fromDate = date('Y-m-01'); //first day of the month
			$toDate = date('Y-m-d'); //as of today
		}

		$modelRequest = Requestextend::find()
						//->with('samples')
						->where('rstl_id =:rstlId AND status_id != :statusId AND lab_id = :labId AND DATE_FORMAT(`request_datetime`, "%Y-%m-%d") BETWEEN :fromRequestDate AND :toRequestDate', [':rstlId'=>$GLOBALS['rstl_id'],':statusId'=>2,':labId'=>$labId,':fromRequestDate'=>$fromDate,':toRequestDate'=>$toDate])
						//->addParams([':statusId'=>2])
						->groupBy(['DATE_FORMAT(request_datetime, "%Y-%m-%d")'])
						->orderBy('request_datetime DESC');

		$dataProvider = new ActiveDataProvider([
            //'query' => $searchModel->search(Yii::$app->request->queryParams),
            'query' =>$modelRequest,
            'pagination' => [
                'pagesize' => 10,
            ],
        ]);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('samplestat', [
                'dataProvider' => $dataProvider,
                'lab_id' => $labId,
                'from_date' => $fromDate,
                'to_date' => $toDate,
                'model'=>$modelRequest,
	            'laboratories' => $this->listLaboratory(),
            ]);
        } else {
			return $this->render('samplestat', [
	            //'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
	            'lab_id' => $labId,
	            'model'=>$modelRequest,
                'from_date' => $fromDate,
                'to_date' => $toDate,
	            'laboratories' => $this->listLaboratory(),
	        ]);
		}

		/*if(Yii::$app->request->get('request_id'))
        {
            $requestId = (int) Yii::$app->request->get('request_id');
        }*/

		// $modelRequest = Requestextend::find()
		// 				->with('samples')
		// 				->where('status_id != :statusId', [':statusId'=>2])
		// 				->addParams([':statusId'=>2])
		// 				->groupBy(['DATE_FORMAT(request_datetime, "%Y-%m-%d")'])
		// 				->orderBy('request_datetime DESC');
						//->all();
		//$query = Post::find()->where(['status' => 1]);
		//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$modelRequest1 = Requestextend::find()->where('status_id =:statusId', [':statusId'=>2]);

    	//return $this->render('index');
    }

    public function actionGetlisttemplate() {
        if(isset($_GET['template_id'])){
            $id = (int) $_GET['template_id'];
            $modelSampletemplate =  SampleName::findOne(['sample_name_id'=>$id]);
            if(count($modelSampletemplate)>0){
                $sampleName = $modelSampletemplate->sample_name;
                $sampleDescription = $modelSampletemplate->description;
            } else {
                $sampleName = "";
                $sampleDescription = "";
            }
        } else {
            $sampleName = "Error getting sample name";
            $sampleDescription = "Error getting description";
        }
        return Json::encode([
            'name'=>$sampleName,
            'description'=>$sampleDescription,
        ]);
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

    function checkmydate($date){
		$tempDate = explode('-', $date);
		// checkdate(month, day, year)

		if(count($tempDate) < 3)
		{
			return "Not valid";
		} else {
			return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
		}
	}

	function checkValidDate($date){
		$tempdate = explode('-', $date);

		if(count($tempdate) < 3 || count($tempdate) > 3)
		{
			return false;
		} else {
			$month = (int) $tempdate[1];
			$year = (int) $tempdate[0];
			$day = (int) $tempdate[2];
			//var_dump(checkdate($month,$day,$year));
			if(checkdate($month,$day,$year) == true){
				return true;
			} else {
				return false;
			}
		}
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
