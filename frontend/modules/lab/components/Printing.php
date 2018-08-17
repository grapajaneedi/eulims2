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

    public function PrintRequest($id) {
        \Yii::$app->view->registerJsFile("css/pdf.css");
        $mTemplate = $this->RequestTemplate($id);
        $pdfFooter = [
            'L' => [
                'content' => '',
                'font-size' => 0,
                'font-style' => 'B',
                'color' => '#999999',
            ],
            'C' => [
                'content' => '{PAGENO}',
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'serif',
                'color' => '#333333',
            ],
            'R' => [
                'content' => '',
                'font-size' => 0,
                'font-style' => 'B',
                'font-family' => 'serif',
                'color' => '#333333',
            ],
            'line' => false,
        ];
        $mPDF = new Pdf(['cssFile' => 'css/pdf.css']);
        $mPDF->content = $mTemplate;
        $mPDF->orientation = Pdf::ORIENT_PORTRAIT;
//        $mPDF->marginLeft = 2.0;
//        $mPDF->marginRight = 2.0;
//        $mPDF->marginTop = 1.0;
//        $mPDF->marginBottom = 5.5;
        $mPDF->defaultFontSize = 9;
        $mPDF->defaultFont = 'Verdana';
        $mPDF->format = Pdf::FORMAT_A4;
        $mPDF->destination = Pdf::DEST_BROWSER;
        $mPDF->methods =['SetFooter'=>['|{PAGENO}|']];
        $mPDF->render();
        exit;
    }

    private function RequestTemplate($id) {
        $Func = new Functions();
        $Proc = "spGetRequestServices(:nRequestID)";
        $Params = [':nRequestID' => $id];
        $Connection = \Yii::$app->labdb;
        $RequestRows = $Func->ExecuteStoredProcedureRows($Proc, $Params, $Connection);
        $RequestHeader = (object) $RequestRows[0];
        $RequestID = $RequestHeader->request_id;
        $RstlDetails = RstlDetails::find()->where(['rstl_id' => $RequestID])->one();
        if ($RstlDetails) {
            $RequestTemplate = "<table border='0' style='border-collapse: collapse;font-size: 12px' width=100%>";
            $RequestTemplate .= "<thead>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 12px'>$RstlDetails->name</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 12px;font-weight: bold'>REGIONAL STANDARDS AND TESTING LABORATORIES</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='3'  style='width: 30%'></td>";
            $RequestTemplate .= "<td colspan='4' style='text-align: center;font-size: 12px;width: 40%'>$RstlDetails->address</td>";
            $RequestTemplate .= "<td colspan='3'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='3'  style='width: 30%'></td>";
            $RequestTemplate .= "<td colspan='4' style='width: 40%;text-align: center;font-size: 12px'>$RstlDetails->contacts</td>";
            $RequestTemplate .= "<td colspan='3'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 12px'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-weight: bold;font-size: 12px'>Request for " . strtoupper($RstlDetails->shortName) . " RSTL Services</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "</thead>";
            $RequestTemplate .= "<tbody>";
            $RequestTemplate .= "<td>Req Ref #:</td>";
            $RequestTemplate .= "<td colspan='4' style='text-align: left'>$RequestHeader->request_ref_num</td>";
            $RequestTemplate .= "<td colspan='5'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td>Date:</td>";
            $RequestTemplate .= "<td colspan='4' style='text-align: left'>" . date('m/d/Y h:i: A', strtotime($RequestHeader->request_datetime)) . "</td>";
            $RequestTemplate .= "<td colspan='5'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='height: 5px'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='border-top: 1px solid black;border-left: 1px solid black'>Customer:</td>";
            $RequestTemplate .= "<td colspan='6' style='border-top: 1px solid black;'>$RequestHeader->customer_name</td>";
            $RequestTemplate .= "<td style='border-top: 1px solid black;'>Tel #:</td>";
            $RequestTemplate .= "<td colspan='2' style='border-top: 1px solid black;border-right: 1px solid black'>$RequestHeader->tel</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='border-bottom: 1px solid black;border-left: 1px solid black'>Address:</td>";
            $RequestTemplate .= "<td colspan='6' style='border-bottom: 1px solid black;border-bottom: 1px solid black;'>$RequestHeader->address</td>";
            $RequestTemplate .= "<td style='border-bottom: 1px solid black;'>Fax #:</td>";
            $RequestTemplate .= "<td colspan='2' style='border-bottom: 1px solid black;border-right: 1px solid black'>$RequestHeader->fax</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='10' class='text-left border-bottom-line'>1.0 TESTING OR CALIBRATION SERVICE</th>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='2' class='text-left valign-bottom border-bottom-line border-left-line border-right-line padding-left-5' style=''>SAMPLE</th>";
            $RequestTemplate .= "<th class='text-left valign-bottom border-bottom-line border-right-line padding-left-5' style='width: 15%;'>Sample Code</th>";
            $RequestTemplate .= "<th colspan='2' class='text-left valign-bottom border-bottom-line border-right-line padding-left-5' style='width: 15%;'>TEST/CALIBRATION REQUESTED</th>";
            $RequestTemplate .= "<th colspan='2' class='text-left valign-bottom border-bottom-line border-right-line padding-left-5' style='width: 15%;'>TEST METHOD</th>";
            $RequestTemplate .= "<th class='text-center valign-bottom border-bottom-line border-right-line padding-left-5' style='width: 9%;'>No of Samples/ UNIT</th>";
            $RequestTemplate .= "<th class='text-right border-bottom-line border-right-line valign-bottom padding-right-5' style='width: 9%;'>UNIT COST</th>";
            $RequestTemplate .= "<th class='text-right border-bottom-line border-right-line valign-bottom border-right-line padding-right-5' style='width: 9%;'>TOTAL</th>";
            $RequestTemplate .= "</tr>";
            
            $CurSampleCode = "";
            $PrevSampleCode = "";
            foreach ($RequestRows as $RequestRow) {
                $RequestRow = (object) $RequestRow;
                $CurSampleCode = $RequestRow->sample_code;
                $RequestTemplate .= "<tr>";
                if ($CurSampleCode != $PrevSampleCode) {
                    $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-bottom-line padding-left-5' colspan='2'>$RequestRow->samplename</td>";
                    $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-right-line border-bottom-line padding-left-5'>$RequestRow->sample_code</td>";
                } else {
                    $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-bottom-line' colspan='2'></td>";
                    $RequestTemplate .= "<td class='text-left border-right-line border-top-line border-left-line border-bottom-line'></td>";
                }
                $RequestTemplate .= "<td class='text-left border-bottom-line border-top-line border-right-line padding-left-5' colspan='2'>$RequestRow->testcalibration</td>";
                $RequestTemplate .= "<td class='text-left border-bottom-line border-top-line border-right-line padding-left-5 padding-right-5' colspan='2'>$RequestRow->method</td>";
                $RequestTemplate .= "<td class='text-center border-bottom-line border-top-line border-right-line'>$RequestRow->NoSampleUnit</td>";
                $RequestTemplate .= "<td class='text-right border-bottom-line border-top-line border-right-line padding-right-5'>$RequestRow->UnitCost</td>";
                $RequestTemplate .= "<td class='text-right border-bottom-line border-top-line border-right-line padding-right-5'>$RequestRow->TotalAnalysis</td>";
                $RequestTemplate .= "</tr>";
                $PrevSampleCode = $CurSampleCode;
            }
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='8' style='border: 1px solid black' class='border-left-line border-bottom-line'>&nbsp;</td>";
            $RequestTemplate .= "<td class='border-left-line border-bottom-line'></td>";
            $RequestTemplate .= "<td class='border-left-line border-bottom-line border-right-line'></td>";
            $RequestTemplate .= "</tr>";
            // SUB-TOTAL
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line' colspan='8'></td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line padding-right-5'>Sub-Total</td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".number_format($RequestHeader->SubTotal,2)."</td>";
            $RequestTemplate .= "</tr>";
            // Discount
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line' colspan='8'></td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line padding-right-5'>Discount</td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".number_format($RequestHeader->DiscountPrice,2)."</td>";
            $RequestTemplate .= "</tr>";
            // TOTAL
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line' colspan='8'></td>";
            $RequestTemplate .= "<th class='text-right border-left-line border-bottom-line padding-right-5'>TOTAL</th>";
            $RequestTemplate .= "<th class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".number_format($RequestHeader->GrandTotal,2)."</th>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' class='text-left'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='10' class='text-left border-bottom-line'>2. BRIEF DESCRIPTION OF SAMPLE/REMARKS</th>";
            $RequestTemplate .= "</tr>";
            //BRIEF DESCRIPTION
            $CurSampleCode2 = "";
            $PrevSampleCode2 = "";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-right-line padding-right-5 padding-left-5' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            foreach ($RequestRows as $RequestRow) {
                $RequestRow = (object) $RequestRow;
                $CurSampleCode2 = $RequestRow->sample_code;
                if ($CurSampleCode2 != $PrevSampleCode2) {
                    $RequestTemplate .= "<tr>";
                    $RequestTemplate .= "<td class='text-left border-left-line border-right-line padding-left-5' colspan='10'>$RequestRow->Remarks</td>";
                    $RequestTemplate .= "</tr>";
                }
                $PrevSampleCode2 = $CurSampleCode2;
            }
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-bottom-line border-right-line padding-right-5 padding-left-5' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-right padding-right-5 padding-left-5 text-bold' colspan='8'>TOTAL</td>";
            $RequestTemplate .= "<td colspan='2' class='text-right padding-right-5 text-bold border-bottom-line'>₱ ".number_format($RequestHeader->GrandTotal,2)."</td>";
            $RequestTemplate .= "</tr>";
            //Footer
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5'>OR Nos:</td>";
            $RequestTemplate .= "<td class='text-left border-top-line padding-left-5' colspan='4'>234123,56783</td>";
            $RequestTemplate .= "<td class='text-right border-top-line padding-left-5' colspan='3'>Amount Received:</td>";
            $RequestTemplate .= "<td colspan='2' class='text-right border-top-line padding-left-5 border-right-line padding-right-5'>1,234.00</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-left-line padding-left-5'>Date:</td>";
            $RequestTemplate .= "<td class='text-left border-bottom-line padding-left-5' colspan='4'>8/15/2018 11:23 AM</td>";
            $RequestTemplate .= "<td class='text-right border-bottom-line padding-left-5' colspan='3'>Unpaid Balance:</td>";
            $RequestTemplate .= "<td colspan='2' class='text-right border-bottom-line padding-left-5 border-right-line padding-right-5'>0.00</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
             //Report Due
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-left-line border-top-line padding-left-5'>Report Due On:</td>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-top-line padding-left-5' colspan='4'>".date('m/d/Y', strtotime($RequestHeader->report_due))."</td>";
            $RequestTemplate .= "<td class='text-right border-bottom-line border-top-line padding-left-5' colspan='3'>Mode Of Release:</td>";
            $RequestTemplate .= "<td colspan='2' class='text-right border-bottom-line border-top-line padding-left-5 border-right-line padding-right-5'>$RequestHeader->ModeOfRelease</td>";
            $RequestTemplate .= "</tr>";
             //Divider
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
             //
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-bottom-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='10'>Discused with Customer</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='4'>Conforme:</td>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='3'></td>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='3'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-center valign-bottom text-bold border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' colspan='4' style='height: 35px'>".ucwords($RequestHeader->conforme)."</td>";
            $RequestTemplate .= "<td class='text-center valign-bottom text-bold border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' colspan='3'>".ucwords($RequestHeader->receivedBy)."</td>";
            $RequestTemplate .= "<td class='text-center valign-bottom text-bold border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' colspan='3'>".ucwords($RequestHeader->LabManager)."</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='4'>Customer/Authorized Representative</td>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='3'>Sample/s Received By:</td>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='3'>Sample/s Reviewed By:</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-bottom-line border-top-line padding-left-5 border-right-line padding-right-5' colspan='10'>Report No:</td>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "</tbody>";
            $RequestTemplate .= "<tfoot>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</tfoot>";
            $RequestTemplate .= "</table>";
        } else {
            $RequestTemplate = "<table border='0' width=100%>";
            $RequestTemplate .= "</table>";
        }
        return $RequestTemplate;
    }

}
