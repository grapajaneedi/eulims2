<?php

/*
 * Project Name: eulims * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 01 18, 18 , 3:42:06 PM * 
 * Module: MyPDF * 
 */

namespace frontend\modules\finance\components\_class;
use Yii;
use yii\helpers\ReplaceArrayValue;
use kartik\mpdf\Pdf;
use frontend\modules\finance\components\models\Ext_Receipt as Receipt;
use yii\db\Query;
use common\models\finance\Accountingcode;
use common\models\finance\Paymentitem;
interface PDFEnum{
    const PDF_Browser="I";
    const PDF_Download="D";
    const PDF_File="F";
    const PDF_String="S";
}
/**
 * This PDF Class will generate PDF from YII2 Views
 * and can choose to where will the PDF be send[Browser, Download, File, String
 *
 * @author OneLab
 */
class OfficialReceipt implements PDFEnum{
    
    static $pdf;
    /**
     * 
     * @param string $content The generated Views that to be converted to PDF 
     */
    public function __construct($opt=null) {
       
    }
    private function ORTemplate($ORNumber,$ORTitle){
        $Collection= Receipt::find()->where(['or_number'=>$ORNumber])->one();
       // $modeofpayment=$Collection->mode
        $ORHeader="<table border='1' width=100% cellpadding='0' cellspacing='0'>";
        $ORHeader.="<thead>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='8' style='height:167px'>&nbsp;</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='3'></td>";
        $datetime=$Collection->receiptDate;
        $ORHeader.="<td colspan='5' style='text-align:left;'>&nbsp;&nbsp;&nbsp;".date("m/d/Y h:i:s A", strtotime($datetime))."</td>";
        $ORHeader.="</tr>";
        $ORHeader.="</thead>";
        $ORHeader.="<tbody>";
       
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='8'>&nbsp;</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td width=30>&nbsp;</td>";
        $ORHeader.="<td colspan='5'>DOST-IX</td>";
        $ORHeader.="<td>&nbsp;</td>";
        $ORHeader.="<td>&nbsp;</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td>&nbsp;</td>";
        $ORHeader.="<td colspan='7'>Jollibee Food Corporation</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='8' style='height:34px'>&nbsp;</td>";
        $ORHeader.="</tr>";
       // echo $Collection->receipt_id;
      //  exit;
        $paymentitem_Query = Paymentitem::find()->where(['receipt_id' => $Collection->receipt_id])->all();
        //$count = $paymentitem_Query->count();
        //echo $count;
       // exit;
        $count=0;
        
        $accountcodeid=$Collection->accountingcodemap->accountingcode_id;
        $accountcode=Accountingcode::find()->where(['accountingcode_id' => $accountcodeid])->one();
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='4'>&nbsp;&nbsp;&nbsp;".$Collection->collectiontype->natureofcollection."</td>";
        $ORHeader.="<td colspan='2'>&nbsp;".$accountcode->accountcode."</td>";
        $ORHeader.="<td colspan='2'>&nbsp;</td>";
        $ORHeader.="</tr>";
        
        $paymentmode=$Collection->paymentMode->payment_mode;
        $cash='';
        $check='';
        $mo='';
        if($paymentmode == 'Cash'){
            $cash='/';
        }
        else if($paymentmode == 'Check'){
            $check='/';
        }
        else if($paymentmode == 'Money Order'){
            $mo='/';
        }
       // echo $accountcode->accountcode;
       // exit;
        foreach ($paymentitem_Query as $i => $or) {
           // echo $Collection->receipt_id;
            $ORHeader.="<tr>";
            $ORHeader.="<td colspan='4'>&nbsp;".$or['details']."</td>";
            $ORHeader.="<td colspan='2'>&nbsp;</td>";
            $ORHeader.="<td colspan='2' style='text-align:right;padding-right: 10px'>&nbsp;".number_format($or['amount'],2)."</td>";
            $ORHeader.="</tr>";
            $count++;
        }
        $num= 7-$count;
        
       // exit;
        for($i=0;$i<$num;$i++){
            $ORHeader.="<tr>";
            $ORHeader.="<td colspan='4'>&nbsp;</td>";
            $ORHeader.="<td colspan='2'>&nbsp;</td>";
            $ORHeader.="<td colspan='2'>&nbsp;</td>";
            $ORHeader.="</tr>";
        }
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='6'>&nbsp;</td>";
        $ORHeader.="<td colspan='2' style='text-align:right;padding-right: 10px'>&nbsp;".number_format($Collection->total,2)."</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='8' style='height:5px'></td>";
        $ORHeader.="</tr>";
        $space="";
        for($x=1;$x<30;$x++){
            $space.="&nbsp;";
        }
        $ORHeader.="<tr>";
        $ORHeader.="<td colspan='8' style='word-wrap':break-word;height:34px;>".$space."One Million one thousand one hundred fifty two and 00/100</td>";
        $ORHeader.="</tr>";
        
        
        $ORHeader.="<tr>";//Cash
        $ORHeader.="<td colspan='8' style='word-wrap':break-word;height:34px;>&nbsp;&nbsp;".$cash."</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";//Check
        $ORHeader.="<td colspan='8' style='word-wrap':break-word;height:34px;>&nbsp;&nbsp;".$check."</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="<tr>";//Money Order
        $ORHeader.="<td colspan='8' style='word-wrap':break-word;height:34px;>&nbsp;&nbsp;".$mo."</td>";
        $ORHeader.="</tr>";
        
        $ORHeader.="</tbody>";
        $ORHeader.="</table>";
      
        $footer="<table border='0' width=100%>";
       
        $footer.="<tr>";
        $footer.="<td colspan='2' style='font-size: 30px;text-align: center'>"."".strval($ORNumber)."</td>";
        $footer.="</tr>";
        $footer.="<tr><td colspan='2'>&nbsp;</td><tr>";
        $footer.="<tr>";
        $footer.="<td colspan='2' style='font-size: 25px;text-align: center'>Thank you have a nice day!</td>";
        $footer.="</tr>";
        $footer.="</table>";
        $ORTemplate=[
           0=> $ORHeader,
           1=> $footer
        ];
        return $ORTemplate;
    }
    /**
     * 
     * @param type $dest
     */
    public function PrintPDF($ORNumber, $ORTitle){
        $ORNumber='2437937';
        $mORTemplate= $this->ORTemplate($ORNumber, $ORTitle);
        $mPDF = new Pdf();
        $mPDF->content=$mORTemplate[0];
        $mPDF->orientation=Pdf::ORIENT_PORTRAIT;
        $mPDF->marginLeft=2.0;
        $mPDF->marginRight=2.0;
        $mPDF->marginTop=0.0;
        $mPDF->marginBottom=0.5;
        $mPDF->defaultFontSize=9;
       // $mPDF->cssFile="/assets/251be39e/css/bootstrap.min.css";
        $mPDF->defaultFont='Verdana';
        $mPDF->format=[102,203]; //Customed Sizes
        $mPDF->destination= Pdf::DEST_BROWSER;
        //$Footer="<barcode code='$ORNumber' type='C39' size='1.5' height='0.5'/>";
        $mPDF->methods=[ 
            //'SetHeader'=>['Z.C. INTEGRATED PORT SERVICES, INC.'], 
            'SetFooter'=>[$mORTemplate[1]]
        ];
        $mPDF->render();
        exit;
    } 
}
