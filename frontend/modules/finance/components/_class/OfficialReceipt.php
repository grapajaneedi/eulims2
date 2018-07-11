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
use common\models\collection\Collection;

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
        $Collection= Collection::find()->where(['or_number'=>$ORNumber])->one();
        $ORHeader="<table border='0' width=100%>";
        $ORHeader.="<thead>";
        $ORHeader.="<tr>";
        $ORHeader.="<th align='center' colspan='2' style='font-size: 13px;font-weight: bold'>Z.C. INTEGRATED PORT SERVICES, INC.</th>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='center' colspan='2' style='font-size: 12px'>PORT AREA, ZAMBOANGA CITY</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='center' colspan='2' style='font-size: 12px'>VAT Reg. TIN 006-282-155-000</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $datetime=DateTime::createFromFormat('Y-m-d H:i:s', $Collection->transaction_date)->format('m/d/Y h:i:s A');
        $ORHeader.="<td align='center' colspan='2' style='font-size: 12px'>".$datetime."</td>";
        $ORHeader.="</tr>";
        $ORHeader.="</thead>";
        $ORHeader.="<tbody>";
        $ORHeader.="<tr><td colspan='2'>&nbsp;</td><tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='center' colspan='2' style='font-size: 12px'>This serves as an Official Receipt</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='center' colspan='2' style='font-size: 14px;font-weight: bold'>". strtoupper($ORTitle)."</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='center' colspan='2' style='font-size: 12px;font-weight: bold'>For ". $Collection->orType->or_type."</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='center' colspan='2' style='font-size: 30px;'>₱".number_format($Collection->amount_tendered,2)."</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='center' colspan='2' style='font-size: 12px'>Valid only per one departing passenger</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='center' colspan='2' style='font-size: 15px;'>PLEASE KEEP TICKET FOR VERIFICATION</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='right' style='font-size: 15px;'>VATable Sales:</td>";
        $ORHeader.="<td align='right' style='font-size: 15px;padding-right: 15px'>".number_format($Collection->vatable_sales,2)."</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='right' style='font-size: 15px;'>VAT:</td>";
        $ORHeader.="<td align='right' style='font-size: 15px;padding-right: 15px'>".number_format($Collection->vat,2)."</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr>";
        $ORHeader.="<td align='right' style='font-size: 15px;'>TOTAL:</td>";
        $ORHeader.="<td align='right' style='font-size: 15px;padding-right: 15px'>₱".number_format($Collection->amount_tendered,2)."</td>";
        $ORHeader.="</tr>";
        $ORHeader.="<tr><td colspan='2'>&nbsp;</td><tr>";
        $ORHeader.="</tfoot>";
        $ORHeader.="</table>";
        
        $footer="<table border='0' width=100%>";
        $footer.="<tr>";
        $footer.="<td colspan='2' style='text-align: center'>";
        $footer.="<barcode code='$ORNumber' type='I25' size='2.0' height='0.8'/>";
        $footer.="</td>";
        $footer.="</tr>";
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
        $mORTemplate= $this->ORTemplate($ORNumber, $ORTitle);
        $mPDF = new Pdf();
        $mPDF->content=$mORTemplate[0];
        $mPDF->orientation=Pdf::ORIENT_PORTRAIT;
        $mPDF->marginLeft=2.0;
        $mPDF->marginRight=2.0;
        $mPDF->marginTop=0.0;
        $mPDF->marginBottom=0.5;
        $mPDF->defaultFontSize=9;
        $mPDF->defaultFont='Verdana';
        $mPDF->format=[70,130]; //Customed Sizes
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
