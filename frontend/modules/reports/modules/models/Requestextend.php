<?php

namespace frontend\modules\reports\modules\models;

use Yii;
use common\models\system\Rstl;
use common\components\Functions;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\lab\Request;
/**
 * Extended model from lab Request
 *
**/

class Requestextend extends Request
{
    public $from_date, $to_date, $lab_id;

    public function countSummary($labId,$requestDate,$startDate,$endDate,$summaryType,$requestType)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $query = $function->ExecuteStoredProcedureOne("spSummaryforSamples(:rstlId,:labId,:requestDate,:startDate,:endDate,:summaryType,:requestType)", 
            [':rstlId'=>$GLOBALS['rstl_id'],':labId'=>$labId,':requestDate'=>$requestDate,':startDate'=>$startDate,':endDate'=>$endDate,':summaryType'=>$summaryType,':requestType'=>$requestType], $connection);
        return $query['Counter'];
    }

    public function computeAccomplishment($labId,$requestDate,$startDate,$endDate,$generateType,$requestType)
    {
        $function = new Functions();
        $connection = Yii::$app->labdb;
        $query = $function->ExecuteStoredProcedureOne("spAccomplishmentReport(:rstlId,:labId,:requestDate,:startDate,:endDate,:generateType,:requestType)", 
            [':rstlId'=>$GLOBALS['rstl_id'],':labId'=>$labId,':requestDate'=>$requestDate,':startDate'=>$startDate,':endDate'=>$endDate,':generateType'=>$generateType,':requestType'=>$requestType], $connection);
        return $query['Counter'];
    }
}
