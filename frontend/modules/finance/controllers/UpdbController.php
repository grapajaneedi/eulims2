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
use common\models\finance\Restore_op;


use Yii;
use common\models\api\YiiMigration;
use common\models\api\YiiMigrationSearch;
/**
 * Description of UpdbController
 *
 * @author ts-ict5
 */
class UpdbController extends \yii\web\Controller{
    
    public function actionIndex()
    {

        $model = new YiiMigration();
        
        $searchModel = new YiiMigrationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      //  $dataProvider->pagination->pageSize=10;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);

    }
    
    public function actionPostop($url = "http://www.eulims.local/api/api/sync_orderofpayment"){
        $table = "tbl_orderofpayment";
        $model= YiiMigration::find()->where(['tblname'=>$table])->one();
        $id=$model->num;
        $limit=$id+100;
        $data = Yii::$app->financedb->createCommand("SELECT * FROM `tbl_orderofpayment` WHERE is_sync_up=0 AND orderofpayment_id > ".$id." AND orderofpayment_id < ".$limit)->queryAll();
        $Op_details=[];
        foreach($data as $op){
            $detail=[
                    'orderofpayment_id'=>$op['orderofpayment_id'],
                    'rstl_id'=> $op['rstl_id'],
                    'transactionnum'=>$op['transactionnum'],
                    'collectiontype_id'=>$op['collectiontype_id'],
                    'order_date'=>$op['order_date'],
                    'customer_id'=>$op['customer_id'],
                    'purpose'=>$op['purpose'],
                    'total_amount'=>$op['total_amount'],
                    'local_orderofpayment_id'=>$op['orderofpayment_id'],
                    'payment_mode_id'=> $op['payment_mode_id'],
                    'on_account'=> $op['on_account'],
                    'receipt_id'=>$op['receipt_id'],
                    'purpose'=> $op['purpose'],
                    'payment_status_id'=> $op['payment_status_id'],
                    'is_sync_up' => $op['is_sync_up'],
                    'is_updated' => $op['is_updated'],
                    'is_deleted' => $op['is_deleted']
                   
            ];
            array_push($Op_details, $detail);
        }
        
        $curl = new curl\Curl();
        
        $content = json_encode(['data'=>$Op_details]);
        
        $response = $curl->setRequestBody($content)
            ->setHeaders([
              'Content-Type' => 'application/json',
              'Content-Length' => strlen($content),
            ])->post($url);
        
        if($response){
           $data = json_decode($response);
           foreach ($data as $res) {
               //$ids= implode(',',$res->idsave);
               $idsave = $res->idsave;
              // $idfail=$res->idfail;
           }
           $updatemodel = Yii::$app->financedb->createCommand("UPDATE tbl_orderofpayment set is_sync_up=1 WHERE orderofpayment_id > ".$id." AND orderofpayment_id <= ".$idsave)->execute();
       
           if($model){
                $model->num=$idsave;
                $model->save(false);
           }
        }
        
    }

}
