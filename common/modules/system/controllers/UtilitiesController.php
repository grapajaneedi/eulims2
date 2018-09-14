<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 09 7, 18 , 4:38:40 PM * 
 * Module: BackupController * 
 */

namespace common\modules\system\controllers;

use Yii;
use yii\web\Controller;
use common\models\finance\Op;
use common\models\finance\Paymentitem;
use common\models\finance\SubsidiaryCustomer;
use common\models\finance\Receipt;
/**
 * Description of BackupController
 *
 * @author OneLab
 */
class UtilitiesController extends Controller {
    public function actionBackupRestore()
    {
        return $this->render('backup_restore');
    }
    public function actionBackupLab(){
        return "Lab";
    }
    public function actionBackupFinance(){
        $op=Op::find()->where(['between','orderofpayment_id',1,10])->all();
        $paymentitem=Paymentitem::find()->where(['between','orderofpayment_id',1,10])->all();
        $sc= SubsidiaryCustomer::find()->where(['between','orderofpayment_id',1,10])->all();
        $receipt= Receipt::find()->where(['between','orderofpayment_id',1,10])->all();
        $sync=[
            'sync_log'=>[
                'date_sync'=>'09/11/2018 10:01:12',
                'rstl_id'=>11,
                'local_user_id'=>1,
                'sync_details'=>[
                   [
                     'table_name'=>'tbl_request',
                     'start_id'=>'1',
                     'last_id'=>10
                   ],
                   [
                     'table_name'=>'tbl_sample',
                     'start_id'=>'1',
                     'last_id'=>10
                   ]
                ]
            ],
            'op'=>$op,
            'paymentitem'=>$paymentitem,
            'subsidiary_customer'=>$sc,
            'receipt'=>$receipt,
            
        ];
       // $content = json_encode($sync);
        Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        return $sync;
       //return $this->render('backup_finance');
    }
    public function actionBackupInventory(){
        return "Inventory";
    }
}
