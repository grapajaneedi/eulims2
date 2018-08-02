<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 06 7, 18 , 4:05:19 PM * 
 * Module: AjaxController * 
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\lab\Discount;
use common\models\finance\Client;
use common\models\lab\Customer;

/**
 * Description of AjaxController
 *
 * @author OneLab
 */
class AjaxController extends Controller{
    public function behaviors(){
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index'  => ['GET'],
                    'view'   => ['GET'],
                    'create' => ['GET', 'POST'],
                    'update' => ['GET', 'PUT', 'POST'],
                    'delete' => ['POST', 'DELETE'],
                ],
            ],
        ];
    }
     public function actionSetwallet($customer_id,$amount,$source,$transactiontype){
        //$myvar = setTransaction($customer_id,$amount,$source,$transactiontype);
        return 200;
    }
    public function actionGetdiscount(){
        $post= \Yii::$app->request->post();
        $id=$post['discountid'];
        $discount= Discount::find()->where(['discount_id'=>$id])->one();
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        return $discount;
    }
    public function actionGetcustomerhead($id){
        \Yii::$app->response->format =\yii\web\Response::FORMAT_JSON;
        $Customers=Customer::find()->where(['customer_id'=>$id])->one();
        return $Customers;
    }
    public function actionTogglemenu(){
        $session = Yii::$app->session;
        $hideMenu= $session->get("hideMenu");
        if(!isset($hideMenu)){
           $hideMenu=false; 
        }
        $b=!$hideMenu;
        $session->set('hideMenu',$b);
        //return $hideMenu;
        echo $session->get("hideMenu");
    }
    public function actionGetaccountnumber(){
        $post= Yii::$app->request->post();
        $id=(int)$post['customer_id'];
        $AccNumber="<no accountnumber>";
        $Client= Client::find()->where(['customer_id'=>$id])->one();
        if($Client){
            $AccNumber=$Client->account_number;
        }else{
            $AccNumber="<no account number>";
        }
        return $AccNumber;
    }
    public function actionGetsoabalance(){
        $Connection=Yii::$app->financedb;
        $post= Yii::$app->request->post();
        $id=(int)$post['customer_id'];
        $Proc="CALL spGetSoaPreviousAccount(:mCustomerID)";
        $Command=$Connection->createCommand($Proc);
        $Command->bindValue(':mCustomerID',$id);
        $Row=$Command->queryOne();
        $Balance=(float)$Row['Balance'];
        return $Balance;
    }
}
