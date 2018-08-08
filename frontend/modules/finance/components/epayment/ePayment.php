<?php
namespace frontend\modules\finance\components\epayment;
use common\models\lab\Request;
use common\components\Functions;
use common\models\finance\Op;
use common\models\system\Rstl;
use common\models\lab\Customer;
use linslin\yii2\curl\Curl;
/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 08 6, 18 , 4:04:23 PM * 
 * Module: ePayment * 
 */

/**
 * Description of ePayment
 *
 * @author OneLab
 */
class ePayment {
    /**
     * This class function Post 
     */
    public function PostOnlinePayment($id){
        $Func=new Functions();
        $Proc="spGetPaymentForOnline(:op_id)";
        $Connection= \Yii::$app->financedb;
        $param=[
            'op_id'=>$id
        ];
        $requests=$Func->ExecuteStoredProcedureRows($Proc, $param, $Connection);
        $Payment_details=[];
        foreach($requests as $request){
            $payment_detail=[
                'request_ref_num'=>$request['request_ref_num'],
                'rrn_date_time'=>$request['request_datetime'],
                'amount'=>$request['amount']
            ];
            array_push($Payment_details, $payment_detail);
        }
        //Query order of payment
        $Op= Op::findOne($id);
        $Rstl= Rstl::findOne($Op->rstl_id);
        $Customer= Customer::findOne($Op->customer_id);
        $TransactDetails=[
            'transaction_num'=>$Op->transactionnum,
            'customer_code'=>$Customer->customer_code,
            'collection_type'=>$Op->collectiontype->natureofcollection,
            'collection_code'=>'collection-code',
            'order_date'=>$Op->order_date,
            'agency_code'=>$Rstl->code,
            'total_amount'=>$Op->total_amount,
            'payment_details'=>$Payment_details
        ];
        $content = json_encode($TransactDetails);
        //echo $json;
        //exit;
        //return $TransactDetails;
        $curl=new Curl();
        //$EpaymentURI="https://yii2customer.onelab.ph/web/api/op";
        $EpaymentURI="http://www.eulims.local/capi/op";
        
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setOption(CURLOPT_POSTFIELDS, $content);
        $curl->setOption(CURLOPT_HTTPHEADER,[
            'Content-Type: application/json', 
            'Content-Length: ' . strlen($content)
        ]);
        $response = $curl->post($EpaymentURI);
        
        //$EpaymentURI="http://www.eulims.local/lab/request/testpayment";
        //$response = $Curl->setRawPostData(['json'=>$json])->post($EpaymentURI);
        /*$response = $Curl->setRequestBody($json)
            ->setHeaders([
               'Content-Type' => 'application/json',
               'Content-Length' => strlen($json)
            ])->post($EpaymentURI);
         * 
         */
        //$response = $Curl->setRawPostData(
        //    json_encode($TransactDetails))->post($EpaymentURI);
        return $response;
        
    }
}
