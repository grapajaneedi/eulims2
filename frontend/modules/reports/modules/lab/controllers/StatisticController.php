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
    	$model = new Requestextend;
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
			$fromDate = date('Y-m-01'); //first day of the month
			$toDate = date('Y-m-d'); //as of today
		}

		$modelRequest = Requestextend::find()
					->where('rstl_id =:rstlId AND status_id != :statusId AND lab_id = :labId AND DATE_FORMAT(`request_datetime`, "%Y-%m-%d") BETWEEN :fromRequestDate AND :toRequestDate', [':rstlId'=>$GLOBALS['rstl_id'],':statusId'=>2,':labId'=>$labId,':fromRequestDate'=>$fromDate,':toRequestDate'=>$toDate])
					->groupBy(['DATE_FORMAT(request_datetime, "%Y-%m-%d")'])
					->orderBy('request_datetime DESC');

		$dataProvider = new ActiveDataProvider([
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
