<?php

namespace common\models\lab;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Response;
use yii\db\ActiveQuery;
use common\components\Functions;
use linslin\yii2\curl;

/**
 * This is the model class for table "tbl_analysis".
 *
 * @property int $analysis_id
 * @property string $date_analysis
 * @property int $rstl_id
 * @property int $pstcanalysis_id
 * @property int $request_id
 * @property int $sample_id
 * @property string $sample_code
 * @property string $testname
 * @property string $method
 * @property string $references
 * @property int $quantity
 * @property string $fee
 * @property int $test_id
 * @property int $cancelled
 * @property int $user_id
 * @property int $testcategory_id
  * @property int $sample_type_id
 *
 * @property Test $test
 * @property Sample $sample
 * @property Request $request
 * @property Test $test0
 * @property Tagging[] $tagging
 */
class Analysisextend extends Analysis
{

  public $sampletype_id;

  //get referral sample type list by sampletype_id
  protected function listSampletypereferral($sampletypeId)
  {
      //$apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/labsampletypebylab?lab_id='.$labId;
      $apiUrl='http://localhost/eulimsapi.onelab.ph/api/web/referral/listdatas/sampletypebylab?lab_id='.$labId;
      $curl = new curl\Curl();
      $list = $curl->get($apiUrl);

      $data = ArrayHelper::map(json_decode($list), 'sampletype_id', 'type');
      
      return $data;
      //echo "<pre>";
      //print_r($data);
      //echo "</pre>";
      //exit;
     
      //echo "<pre>";
      //print_r(json_decode($list['sampletype']));
      //echo "</pre>";
  }
}
