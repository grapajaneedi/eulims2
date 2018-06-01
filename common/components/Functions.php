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
    function GenerateStatusLegend($Legend){
        $StatusLegend="<fieldset>";
        $StatusLegend.="<legend>$Legend</legend>";
        $StatusLegend.="<div style='padding: 0 10px'>";
        $Stats= Status::find()->orderBy('status')->all();
        foreach ($Stats as $Stat){
            
            $StatusLegend.="<span class='badge $Stat->class legend-font' ><span class='$Stat->icon'></span> $Stat->status</span>";
        }
        $StatusLegend.="</div>";
        $StatusLegend.="</fieldset>";
        return $StatusLegend;
    }
    
    function CrudAlert($title="Saved Successfully",$type="SUCCESS",$showclose=false,$showcancel=false) {
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
        return  Alert::widget([
            'options' => [
                'showCloseButton' => $showclose,
                'showCancelButton' => $showcancel,
                'title' => $title,
                'type' => $dialog ,
                'timer' => 1000
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
    public function GetLaboratoryList(){
        
    }
}
