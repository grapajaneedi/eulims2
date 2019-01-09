<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2019 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 01 9, 19 , 3:07:12 PM * 
 * Module: UpdbController * 
 */

namespace frontend\modules\finance\controllers;


use linslin\yii2\curl;
use common\models\finance\Op;
/**
 * Description of UpdbController
 *
 * @author ts-ict5
 */
class UpdbController extends \yii\web\Controller{
    
    public function actionIndex()
    {

        if(isset($_POST['Tblform'])){

                $yiimig = new Yiimigration();
                $yiimig->tblname=$_POST['Tblform']['name'];
                $yiimig->num=0;
                $yiimig->ids="";
                $yiimig->save();
        }

        $this->render('index');

    }
    
    public function actionPostop($start,$url = "http://ulimsportal.onelab.ph/api/api/sync_orderofpayment"){
        $data = Yii::app()->financedb->createCommand("SELECT * FROM `tbl_orderofpayment` ORDER BY orderofpayment_id ASC LIMIT ".$start.",500")->queryAll();
        $Op_details=[];
        foreach($data as $op){
            $detail=[
                'request_ref_num'=>$request['request_ref_num'],
                

                    'rstl_id'=> $op['rstl_id'],
                    'transactionnum'=>$op['transactionnum'],
                    'collectiontype_id'=>$op['collectiontype_id'],
                    'order_date'=>$op['order_date'],
                    'customer_id'=>$op['customer_id'],
                    'purpose'=>$op['purpose'],
                    'total_amount'=>$op['total_amount'],
                    'local_orderofpayment_id'=>$op['orderofpayment_id'],
                    
                   
            ];
            array_push($Op_details, $detail);
        }
        
        $content = json_encode($Op_details);
        //Get the epayment config
        $compo=Yii::$app->components['epayment_config'];
        $curl = new curl\Curl();
        
        $response = $curl->setRequestBody($content)
            ->setHeaders([
               'Content-Type' => 'application/json',
               'Content-Length' => strlen($content)
            ])->post($url);
        return $response;
        
    }

}
