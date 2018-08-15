<?php

namespace frontend\modules\lab\models;

use Yii;
use common\models\system\Rstl;
use common\components\Functions;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\lab\Sample;
use common\models\lab\SampleregisterUser;
//use yii\helpers\Json;
/**
 * Extended model from lab Sample
 *
**/

class Sampleextend extends Sample
{
	const SCENARIO_CANCEL_SAMPLE = 'cancelsample';

	public function rules()
    {
        return [
            [['remarks'], 'required', 'on' => self::SCENARIO_CANCEL_SAMPLE],
        ];
    }

    public function showParameter($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        //$array = [];
        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);

        $testname = "";
        //if(count($data) > 0){
        	foreach($data as $test){
				$testname .= $test['testname']."<br />";
			}
        //}

        /*if (is_array($data) || is_object($data)){
			$testname = "";
			foreach($data as $test){
				$testname .= $test['testname']."<br />";
			}
		} else {
			$testname "";
		}*/


		return $testname;



   //      $message = 'Method reference successfully added.';
			// $testmethod_item = $_SESSION['testmethods'];
			// $testmethod_item[$testmethodrefId] = $testmethodrefId;
			// $_SESSION['testmethods'] = $testmethod_item;

       /*$gg =  json_encode($data);
        $listTests = array();
        if (is_array($gg) || is_object($gg))
		{
			foreach($gg as $test){
				$raw = array(
					'testname'=>$test['testname']
				);
				
				array_push($listTests, $raw);
			}
		}

		print_r($listTests);*/

        /*foreach ($data as $key => $value) {
        	# code...
        	$array .= $value['testname']."<br />";
        }

        return $array;*/

        //foreach ($data as $test) {
        //    echo $test['testname'];
        //}

        //return $data;


        //$samples = Sample::model()->findAll(array('select'=>'sampleName','condition'=>'referral_id=:referralId', 'params'=>array(':referralId'=>$data->id)));
		//$lfcr = chr(10) . chr(13);
		
		//foreach ($data as $key => $test){
			//echo '<td>'.$sample->sampleName.' </td><td>'.$sample->sampleCode.'</td>';
			//echo '<td>'.$sample->sampleName.' '.$sample->sampleCode.'</td>';
		//	$testname .= $test['testname'].$lfcr;
		//}

		//$test = json_encode($data);

		//echo "<pre>";
		//print_r(json_encode($data));
		//echo "</pre>";

		//return $data['testname'];
		//return $rstlId." ".$sampleId;
        //return $query['testname'];

        //print_r($query['testname']);
        /*if(count($query) > 0)
        {
        	foreach ($query as $data) {
        		# code...
        		echo $data['testname']."<br>";
        	}
        } else {

        }*/
        //return count($query);
        //if(count($query) > 0)
        //{
        	//foreach ($query as $test) {
        		# code...
        	//	return $test['testname']."<br />";
        	//}
        //} else {

        //}
    }

    public function showStartDate($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);

        $startDate = "";
        if(count($data) > 0){
        	foreach($data as $date){
				$startDate .= $date['start_date']."<br />";
			}
        }
        return $startDate;
    }

    public function showEndDate($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);

        $endDate = "";
        if(count($data) > 0){
        	foreach($data as $date){
				$endDate .= $date['end_date']."<br />";
			}
        }
        return $endDate;
    }

    public function showDisposedDate($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);
        
        $disposedDate = "";
        if(count($data) > 0){
        	foreach($data as $date){
				$disposedDate .= $date['disposed_date']."<br />";
			}
        }
        return $disposedDate;
    }

    public function showMannerDisposal($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);

        $mannerDisposal = "";
        if(count($data) > 0){
        	foreach($data as $manner){
				$mannerDisposal .= $manner['manner_disposal']."<br />";
			}
        }

        /*$i=0;
		    while($i<count($data)){
		    	$mannerDisposal .= $data[$i]['manner_disposal'];
		    	$mannerDisposal .= "<br />";
		    $i++;
		}*/
        return $mannerDisposal;
    }

    public function showAnalyst($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $data = $function->ExecuteStoredProcedureRows("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);

        $analyst = "";
        if(count($data) > 0){
        	foreach($data as $user){
				$analyst .= SampleregisterUser::getUser($user['user_id'])."<br />";
			}
        }
        return $analyst;
    }
}
