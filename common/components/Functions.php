<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

use yii\base\Component;
use yii2mod\alert\Alert;
use common\models\lab\Status;
use common\models\finance\PaymentStatus;
use common\models\lab\Customer;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\models\system\Profile;
use common\models\lab\Sample;
use common\models\lab\Samplecode;
use common\models\lab\Lab;
use Yii;
/**
 * Description of Functions
 *
 * @author OneLab
 */
class Functions extends Component{
    /**
     * 
     * @param string $Proc
     * @param array $Params
     * @param CDBConnection $Connection
     * @return array
     */
    function ExecuteStoredProcedureRows($Proc,array $Params,$Connection){
        if(!isset($Connection)){
           $Connection=Yii::$app->db;
        }
        $Command=$Connection->createCommand("CALL $Proc");
        //Iterate through arrays of parameters
        foreach($Params as $Key=>$Value){
           $Command->bindValue($Key, $Value); 
        }
        $Rows=$Command->queryAll();
        return $Rows;
    }
    /**
     * 
     * @param string $Proc
     * @param array $Params
     * @param CDBConnection $Connection
     * @return array
     */
    public function ExecuteStoredProcedureOne($Proc,array $Params,$Connection){
        if(!isset($Connection)){
           $Connection=Yii::$app->db;
        }
        $Command=$Connection->createCommand("CALL $Proc");
        //Iterate through arrays of parameters
        foreach($Params as $Key=>$Value){
           $Command->bindValue($Key, $Value); 
        }
        $Row=$Command->queryOne();
        return $Row;
    }
    /**
     * @param description Executes the SQL statement. This method should only be used for executing non-query SQL statement, such as `INSERT`, `DELETE`, `UPDATE` SQLs. No result set will be returned.
     * @param type $Proc
     * @param array $Params the Parameter for Stored Procedure
     * @param type $Connection the Active Connection
     * @return Integer
     */
    function ExecuteStoredProcedure($Proc,array $Params,$Connection){
        if(!isset($Connection)){
           $Connection=Yii::$app->db;
        }
        $Command=$Connection->createCommand("CALL $Proc");
        //Iterate through arrays of parameters
        foreach($Params as $Key=>$Value){
           $Command->bindValue($Key, $Value); 
        }
        $ret=$Command->execute();
        return $ret;
    }
    function GetProfileName($UserID){
        $Profile=Profile::find()->where(['user_id'=>$UserID])->one();
        return $Profile->fullname;      
    }
    /**
     * 
     * @param integer $CustomerID
     * @return array
     */
    function GetPaymentModeList($CustomerID){
        $Connection=Yii::$app->financedb;
        $Proc="CALL spGeneratePaymentModeList(:mCustomerID)";
        $Command=$Connection->createCommand($Proc);
        $Command->bindValue(':mCustomerID',$CustomerID);
        $list = $Command->queryAll();
        return $list;
    }
    function GenerateSampleCode($request_id){
        $request =Request::find()->where(['request_id'=>$request_id])->one();
        $lab = Lab::findOne($request->lab_id);
        $year = date('Y', strtotime($request->request_datetime));
        $connection= Yii::$app->labdb;
        
        foreach ($request->samples as $samp){
            //$transaction = $connection->beginTransaction();
            $return="false";
            try {
                $proc = 'spGetNextGenerateSampleCode(:rstlId,:labId,:requestId)';
                $params = [':rstlId'=>$GLOBALS['rstl_id'],':labId'=>$lab->lab_id,':requestId'=>$request_id];
                $row = $this->ExecuteStoredProcedureOne($proc, $params, $connection);
                $samplecodeGenerated = $row['GeneratedSampleCode'];
                $samplecodeIncrement = $row['SampleIncrement'];

                $sampleId = $samp->sample_id;
                $sample= Sample::find()->where(['sample_id'=>$sampleId])->one();
                
                //insert to tbl_samplecode
                $samplecode = new Samplecode();
                $samplecode->rstl_id = $GLOBALS['rstl_id'];
                $samplecode->reference_num = $request->request_ref_num;
                $samplecode->sample_id = $sampleId;
                $samplecode->lab_id = $lab->lab_id;
                $samplecode->number = $samplecodeIncrement;
                $samplecode->year = $year;
                
                if($samplecode->save())
                {
                    //update samplecode to tbl_sample
                    $sample->sample_code = $samplecodeGenerated;
                    $sample->save();
                    //$transaction->commit();
                    $return=true;
                } else {
                    //error
                    //$transaction->rollBack();
                    $samplecode->getErrors();
                    $return=false;
                }
                
                //$transaction->commit();

            } catch (\Exception $e) {
               //$transaction->rollBack();
                echo $e->getMessage();
               $return=false;
            } catch (\Throwable $e) {
               //$transaction->rollBack();
               $return=false;
               echo $e->getMessage();
            }
            
        }
        return $return;
    }
    function GetCustomerList($form,$model,$disabled=false,$Label=false){
$dataExp = <<< SCRIPT
    function (params, page) {
        return {
            q: params.term, // search term
        };
    }
SCRIPT;

$dataResults = <<< SCRIPT
    function (data, page) {
        return {
          results: data.results
        };
    }
SCRIPT;
        $url = \yii\helpers\Url::to(['/lab/request/customerlist']);
        // Get the initial city description
        $cust_name = empty($model->customer) ? '' : Customer::findOne($model->customer_id)->customer_name;
        return $form->field($model, 'customer_id')->widget(Select2::classname(), [
            'initValueText' => $cust_name, // set the initial display text
            'options' => ['placeholder' => 'Search for a customer ...','disabled'=>$disabled,'class'=>'.input-group.input-group-sm'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression($dataExp),
                    'results' => new JsExpression($dataResults)
                ]
            ],
        ])->label($Label);
    }

    //bergel cutara
    function GetRequestList($form,$model,$disabled=false,$Label=false){
$dataExp = <<< SCRIPT
    function (params, page) {
        return {
            q: params.term, // search term
        };
    }
SCRIPT;

$dataResults = <<< SCRIPT
    function (data, page) {
        return {
          results: data.results
        };
    }
SCRIPT;
        $url = \yii\helpers\Url::to(['/lab/request/requestlist']);
        // Get the initial city description
        $req_name = empty($model->request_id) ? '' : Request::findOne($model->request_id)->request_ref_num;
        return $form->field($model, 'request_id')->widget(Select2::classname(), [
            'initValueText' => $req_name, // set the initial display text
            'options' => ['placeholder' => 'Search for a request ...','disabled'=>$disabled,'class'=>'form-control'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression($dataExp),
                    'results' => new JsExpression($dataResults)
                ]
            ],
        ])->label($Label);
    }



    function GenerateStatusLegend($Legend, $Ispayment){
        $StatusLegend="<fieldset>";
        $StatusLegend.="<legend>$Legend</legend>";
        $StatusLegend.="<div style='padding: 0 10px'>";
        if($Ispayment == true){
            $Stats= PaymentStatus::find()->orderBy('payment_status_id')->all();
        }else{
            $Stats= Status::find()->orderBy('status')->all();
        }
        foreach ($Stats as $Stat){
            if($Ispayment){
                $StatusLegend.="<span class='badge $Stat->class legend-font' ><span class='$Stat->icon'></span> $Stat->payment_status</span>";
            }else{
                $StatusLegend.="<span class='badge $Stat->class legend-font' ><span class='$Stat->icon'></span> $Stat->status</span>";
            }
        }
        $StatusLegend.="</div>";
        $StatusLegend.="</fieldset>";
        return $StatusLegend;
    }
    
    function CrudAlert($title="Saved Successfully",$type="SUCCESS",$showclose=true,$showcancel=false,$callback=true) {
        switch($type) {
            case "SUCCESS":
                $dialog = Alert::TYPE_SUCCESS;
                break;
            case "ERROR":
                $dialog = Alert::TYPE_ERROR;
                break;
            case "INFO":
                $dialog = Alert::TYPE_INFO;
                break;
            case "WARNING":
                $dialog = Alert::TYPE_WARNING;
                break;
            case "INPUT":
                $dialog = Alert::TYPE_INPUT;
                break;
        }
        
        if($callback==true) {
        
        return  Alert::widget([
            'options' => [
                'showCloseButton' => $showclose,
                'showCancelButton' => $showcancel,
                'title' => $title,
                'type' => $dialog ,
                //'timer' => 1000
            ],
            'callback' => new \yii\web\JsExpression("
                        function () {
                        $('.sweet-overlay').css('display','none');
                        $('.sweet-alert').removeClass( \"showSweetAlert \" );
                        $('.sweet-alert').removeClass( \"visible \" );
                        $('.sweet-alert').addClass( \"hideSweetAlert \" );
                        $('.sweet-alert').css('display','none');
                        $('body').removeClass( \"stop-scrolling\" );
                        }"),
        ]);
     }else{
          return  Alert::widget([
            'options' => [
                'showCloseButton' => $showclose,
                'showCancelButton' => $showcancel,
                'title' => $title,
                'type' => $dialog ,
                //'timer' => 1000
            ]
              ]);
     }
    }
    /**
     * 
     * @param type $mString
     * @param type $length
     * @return typeLeft Function
     */
    public function left($mString, $length){
        return substr($mString,0,$length);
    }
}
