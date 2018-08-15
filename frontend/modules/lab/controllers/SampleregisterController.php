<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Sample;
use frontend\modules\lab\models\Sampleextend;
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
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\web\Response;
use kartik\mpdf\Pdf;
use yii\db\ActiveQuery;
use common\components\Functions;

class SampleregisterController extends Controller
{
    public function actionIndex2()
    {
        $model = new Analysis;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        if (Yii::$app->request->get())
        {
            $labId = (int) Yii::$app->request->get('lab_id');
            
            if($this->checkValidDate(Yii::$app->request->get('from_date')) == true)
            {
                $fromDate = Yii::$app->request->get('from_date');
            } else {
                $fromDate = date('Y-m-d');
                Yii::$app->session->setFlash('error', "Not a valid date!");
            }

            if($this->checkValidDate(Yii::$app->request->get('to_date')) == true){
                $toDate = Yii::$app->request->get('to_date');
            } else {
                $toDate = date('Y-m-d');
                Yii::$app->session->setFlash('error', "Not a valid date!");
            }
        } else {
            $labId = 1;
            $fromDate = date('Y-01-01'); //first day of the year
            $toDate = date('Y-m-d'); //as of today
        }

        $query = Analysis::find();
        $query->joinWith(['sample','sample.request','tagging']);
        //$query->joinWith(['sample','sample.request','taggings'], true, 'INNER JOIN');
        //$query->joinType('INNER JOIN');
		$query->andWhere('tbl_analysis.rstl_id =:rstlId AND status_id > :statusId AND lab_id = :labId AND DATE_FORMAT(`request_datetime`, "%Y-%m-%d") BETWEEN :fromRequestDate AND :toRequestDate', [':rstlId'=>$rstlId,':statusId'=>0,':labId'=>$labId,':fromRequestDate'=>$fromDate,':toRequestDate'=>$toDate]);
        $query->orderBy([
          'tbl_sample.sample_code' => SORT_ASC,
          'tbl_request.request_datetime'=>SORT_DESC,
        ])->groupBy(['tbl_analysis.analysis_id']);
		
		/* $analysis = Analysis::find()
					->joinWith(['sample','sample.request','tagging'])
					->where('rstl_id =:rstlId AND status_id > :statusId AND lab_id = :labId AND DATE_FORMAT(`request_datetime`, "%Y-%m-%d") BETWEEN :fromRequestDate AND :toRequestDate', [':rstlId'=>$rstlId,':statusId'=>0,':labId'=>$labId,':fromRequestDate'=>$fromDate,':toRequestDate'=>$toDate]); */
					//->groupBy(['DATE_FORMAT(request_datetime, "%Y-%m")'])
					//->orderBy('request_datetime DESC');
		
		//echo json_encode($query);
		//exit;
        //$dataProvider = new ActiveDataProvider([
            //'query' => $query,
        //    'query' => $query,
		//	'pagination' => [
        //        'pagesize' => 5,
        //    ],
        //]);
		
		// $dataProvider = new ArrayDataProvider([
			// 'allModels' => $query,
			// 'pagination' => [
				// 'pageSize' => 10,
			// ],
		// ]);
		// echo "<pre>";
		// print_r($dataProvider->getModels());
		// echo "</pre>";
		// exit;
		
		/*$query = new Query;
		$provider = new ArrayDataProvider([
			'allModels' => $query->from('eulims_db.tbl_analysis')->all(),
			//'sort' => $sort, // HERE is your $sort
			'pagination' => [
				'pageSize' => 10,
			],
		]);*/
		// get the posts in the current page
		//$posts = $provider->getModels();

        $count = Yii::$app->labdb->createCommand('
    SELECT * FROM tbl_analysis WHERE cancelled=:cancel
', [':cancel' => 0])->queryScalar();

$dataProvider = new SqlDataProvider([
    'sql' => 'SELECT * FROM eulims_lab.tbl_analysis WHERE cancelled=:cancel',
    'params' => [':cancel' => 0],
    'totalCount' => $count,
    /*'sort' => [
        'attributes' => [
            'age',
            'name' => [
                'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                'default' => SORT_DESC,
                'label' => 'Name',
            ],
        ],
    ],*/
    'pagination' => [
        'pageSize' => 10,
    ],
]);

// get the user records in the current page
//$model = $dataProvider->getModels();

		//echo "<pre>";
		//print_r($model->sample);
		//echo "</pre>";
		//exit;
        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'laboratories' => $this->listLaboratory(),
        ]);
    }

    public function actionIndex()
    {
        //$model = new Requestextend;
        $model = new Sampleextend;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;
        
        if (Yii::$app->request->get())
        {
            $labId = (int) Yii::$app->request->get('lab_id');
            
            if($this->checkValidDate(Yii::$app->request->get('from_date')) == true)
            {
                $fromDate = Yii::$app->request->get('from_date');
            } else {
                $fromDate = date('Y-m-d');
                Yii::$app->session->setFlash('error', "Not a valid date!");
            }

            if($this->checkValidDate(Yii::$app->request->get('to_date')) == true){
                $toDate = Yii::$app->request->get('to_date');
            } else {
                $toDate = date('Y-m-d');
                Yii::$app->session->setFlash('error', "Not a valid date!");
            }
        } else {
            $labId = 1;
            $fromDate = date('Y-01-01'); //first day of the year
            $toDate = date('Y-m-d'); //as of today
        }

        $query = Sampleextend::find();
        $query->joinWith(['request']);
        //$query->where([]);
        $query->where('tbl_request.rstl_id =:rstlId1 AND tbl_sample.rstl_id =:rstlId2 AND status_id < :statusId AND lab_id = :labId AND active =:active AND DATE_FORMAT(`request_datetime`, "%Y-%m-%d") BETWEEN :fromRequestDate AND :toRequestDate AND request_ref_num != ""', [':rstlId1'=>$rstlId,':rstlId2'=>$rstlId,':statusId'=>2,':labId'=>$labId,':active'=>1,':fromRequestDate'=>$fromDate,':toRequestDate'=>$toDate]);
        //$query->joinWith(['sample','sample.request','taggings'], true, 'INNER JOIN');
        //$query->joinType('INNER JOIN');
        //$query->groupBy(['sample_id']);
        $query->orderBy([
          //'tbl_sample.sample_code' => SORT_ASC,
          //'tbl_request.request_datetime'=>SORT_DESC,
            'tbl_sample.request_id' => SORT_ASC,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'laboratories' => $this->listLaboratory(),
        ]);
    }

    public function actionGg()
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        //$array = [];
        //$data = $function->ExecuteStoredProcedureOne("spSampleRegister(:rstlId,:sampleId)", 
        //    [':rstlId'=>11,':sampleId'=>1], $connection);
        $data = $connection->createCommand('SELECT testname, start_date, end_date, disposed_date, manner_disposal, tbl_tagging.`user_id`
    FROM tbl_analysis LEFT JOIN tbl_tagging
    ON tbl_tagging.`analysis_id` = tbl_analysis.`analysis_id`
    WHERE tbl_analysis.`sample_id` = 1 AND tbl_analysis.`cancelled` = 0 
    AND tbl_analysis.`rstl_id` = 11 AND tbl_analysis.`type_fee_id` < 2')
            ->queryAll();

        echo "<pre>";
        print_r($data);
        echo "</pre>";
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

    protected function listLaboratory()
    {
        $laboratory = ArrayHelper::map(Lab::find()->all(), 'lab_id', 
            function($laboratory, $defaultValue) {
                return $laboratory->labname;
        });

        return $laboratory;
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
            // checkdate(month, day, year)
            if(checkdate($month,$day,$year) == true){
                return true;
            } else {
                return false;
            }
        }
    }

}
