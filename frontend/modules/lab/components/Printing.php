<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 08 14, 18 , 10:06:35 AM * 
 * Module: RequestPrinting * 
 */

namespace frontend\modules\lab\components;
use kartik\mpdf\Pdf;
use common\models\system\RstlDetails;
use common\components\Functions;

/**
 * Description of RequestPrinting
 *
 * @author OneLab
 */
class Printing {
    public function PrintRequest($id){
        $mTemplate= $this->RequestTemplate($id);
        $mPDF = new Pdf();
        $mPDF->content=$mTemplate;
        $mPDF->orientation=Pdf::ORIENT_PORTRAIT;
        $mPDF->marginLeft=2.0;
        $mPDF->marginRight=2.0;
        $mPDF->marginTop=2.0;
        $mPDF->marginBottom=0.5;
        $mPDF->defaultFontSize=9;
        $mPDF->defaultFont='Verdana';
        $mPDF->format=Pdf::FORMAT_A4;
        $mPDF->destination= Pdf::DEST_BROWSER;
        $mPDF->render();
        exit;
    }
    private function RequestTemplate($id){
        $Func=new Functions();
        $Proc="spGetRequestServices(:nRequestID)";
        $Params=[':nRequestID'=>$id];
        $Connection= \Yii::$app->labdb;
        $RequestRows=$Func->ExecuteStoredProcedureRows($Proc, $Params, $Connection);
        $RequestHeader=(object)$RequestRows[0];
        $RequestID=$RequestHeader->request_id;
        $RstlDetails=RstlDetails::find()->where(['rstl_id'=>$RequestID])->one();
        if($RstlDetails){
            $RequestTemplate="<table border='0' style='border-collapse: collapse;font-size: 12px' width=100%>";
            $RequestTemplate.="<thead>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='10' style='text-align: center;font-size: 12px'>$RstlDetails->name</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='10' style='text-align: center;font-size: 12px;font-weight: bold'>REGIONAL STANDARDS AND TESTING LABORATORIES</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='10' style='text-align: center;font-size: 12px'>$RstlDetails->address</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='10' style='text-align: center;font-size: 12px'>$RstlDetails->contacts</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='10' style='text-align: center;font-size: 12px'>&nbsp;</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='10' style='text-align: center;font-weight: bold;font-size: 12px'>Request for ".strtoupper($RstlDetails->shortName)." RSTL Services</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='10'>&nbsp;</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td>Req Ref #:</td>";
            $RequestTemplate.="<td colspan='2' style='text-align: left'>$RequestHeader->request_ref_num</td>";
            $RequestTemplate.="<td colspan='7'>&nbsp;</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td>Date:</td>";
            $RequestTemplate.="<td colspan='2' style='text-align: left'>".date('m/d/Y h:i: A', strtotime($RequestHeader->request_datetime))."</td>";
            $RequestTemplate.="<td colspan='7'>&nbsp;</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='10' style='height: 5px'></td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td style='border-top: 1px solid black;border-left: 1px solid black'>Customer:</td>";
            $RequestTemplate.="<td colspan='6' style='border-top: 1px solid black;'>$RequestHeader->customer_name</td>";
            $RequestTemplate.="<td style='border-top: 1px solid black;'>Tel #:</td>";
            $RequestTemplate.="<td colspan='2' style='border-top: 1px solid black;border-right: 1px solid black'>$RequestHeader->tel</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td style='border-bottom: 1px solid black;border-left: 1px solid black'>Address:</td>";
            $RequestTemplate.="<td colspan='6' style='border-bottom: 1px solid black;border-bottom: 1px solid black;'>$RequestHeader->address</td>";
            $RequestTemplate.="<td style='border-bottom: 1px solid black;'>Fax #:</td>";
            $RequestTemplate.="<td colspan='2' style='border-bottom: 1px solid black;border-right: 1px solid black'>$RequestHeader->fax</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<th colspan='10' style='border-bottom: 1px solid black;'>1.0 TESTING OR CALIBRATION SERVICE</th>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='2' style='text-align: center;vertical-align: bottom'>SAMPLE</td>";
            $RequestTemplate.="<td style='text-align: center;vertical-align: bottom'>SAMPLE CODE</td>";
            $RequestTemplate.="<td colspan='2' style='text-align: center;vertical-align: bottom;width: 15%'>TEST/CALIBRATION REQUESTED</td>";
            $RequestTemplate.="<td colspan='2' style='text-align: center;vertical-align: bottom;width: 15%'>TEST METHOD</td>";
            $RequestTemplate.="<td style='text-align: center;width: 7%;vertical-align: bottom'>No of Samples/UNIT</td>";
            $RequestTemplate.="<td style='text-align: right;width: 7%;vertical-align: bottom'>UNIT COST</td>";
            $RequestTemplate.="<td style='text-align: right;width: 7%;vertical-align: bottom'>TOTAL</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="</thead>";
            
            
            $RequestTemplate.="<tbody>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='2'>&nbsp;</td>";
            $RequestTemplate.="<td>&nbsp;</td>";
            $RequestTemplate.="<td colspan='2'>&nbsp;</td>";
            $RequestTemplate.="<td colspan='2'>&nbsp;</td>";
            $RequestTemplate.="<td>&nbsp;</td>";
            $RequestTemplate.="<td>&nbsp;</td>";
            $RequestTemplate.="<td>&nbsp;</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="</tbody>";
            $RequestTemplate.="<tfoot>";
            $RequestTemplate.="<tr>";
            $RequestTemplate.="<td colspan='10'>&nbsp;</td>";
            $RequestTemplate.="</tr>";
            $RequestTemplate.="</tfoot>";
            $RequestTemplate.="</table>";
        }else{
            $RequestTemplate="<table border='0' width=100%>";
            $RequestTemplate.="</table>";
        }
        return $RequestTemplate;
    }
}
