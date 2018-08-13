<?php

namespace frontend\modules\lab\models;

use Yii;
use common\models\system\Rstl;
use common\components\Functions;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\lab\Sample;
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

        $query = $function->ExecuteStoredProcedureOne("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);
        return $query['testname'];
    }

    public function showStartDate($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $query = $function->ExecuteStoredProcedureOne("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);
        return $query['start_date'];
    }

    public function showEndDate($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $query = $function->ExecuteStoredProcedureOne("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);
        return $query['end_date'];
    }

    public function showDisposedDate($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $query = $function->ExecuteStoredProcedureOne("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);
        return $query['disposed_date'];
    }

    public function showMannerDisposal($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $query = $function->ExecuteStoredProcedureOne("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);
        return $query['manner_disposal'];
    }

    public function showAnalyst($sampleId)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $rstlId = Yii::$app->user->identity->profile->rstl_id;

        $query = $function->ExecuteStoredProcedureOne("spSampleRegister(:rstlId,:sampleId)", 
            [':rstlId'=>$rstlId,':sampleId'=>$sampleId], $connection);
        return $query['user_id'];
    }
}
