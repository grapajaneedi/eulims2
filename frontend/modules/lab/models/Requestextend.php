<?php

namespace frontend\modules\lab\models;

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

    public function countSample($labId,$requestDate,$startDate,$endDate,$summaryType,$requestType)
    {
        /*$query = Yii::$app->labdb->createCommand('CALL spSummaryforSamples(11,1,"2018-05-01","2018-06-21",1,1)')
        ->queryAll();
        return $query;*/

        $function = new Functions();
        $connection = Yii::$app->labdb;
        $query = $function->ExecuteStoredProcedureOne("spSummaryforSamples(:rstlId,:labId,:requestDate,:startDate,:endDate,:summaryType,:requestType)", 
            [':rstlId'=>$GLOBALS['rstl_id'],':labId'=>$labId,':requestDate'=>$requestDate,':startDate'=>$startDate,':endDate'=>$endDate,':summaryType'=>$summaryType,':requestType'=>$requestType], $connection);
        return $query['Counter'];

        //return $GLOBALS['rstl_id'].' '.$labId.' '.$requestDate.' '.$startDate.' '.$endDate.' '.$summaryType.' '.$requestType;
    }

    public function countAnalysis($labId,$requestDate,$startDate,$endDate,$summaryType,$requestType)
    {
        /*$query = Yii::$app->labdb->createCommand('CALL spSummaryforSamples(11,1,"2018-05-01","2018-06-21",2,1)')
        ->queryAll();
        return $query;*/

        $function = new Functions();
        $connection = Yii::$app->labdb;
        $query = $function->ExecuteStoredProcedureOne("spSummaryforSamples(:rstlId,:labId,:requestDate,:startDate,:endDate,:summaryType,:requestType)", 
            [':rstlId'=>$GLOBALS['rstl_id'],':labId'=>$labId,':requestDate'=>$requestDate,':startDate'=>$startDate,':endDate'=>$endDate,':summaryType'=>$summaryType,':requestType'=>$requestType], $connection);
        return $query['Counter'];

        //return $GLOBALS['rstl_id'].' labid-'.$labId.'- '.$requestDate.' '.$startDate.' '.$endDate.' '.$summaryType.' '.$requestType;
    }
}
