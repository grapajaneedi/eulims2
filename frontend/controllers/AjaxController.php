<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 06 7, 18 , 4:05:19 PM * 
 * Module: AjaxController * 
 */

namespace frontend\controllers;

use yii\web\Controller;
use common\models\lab\Discount;
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
    public function actionGetdiscount(){
        $post= \Yii::$app->request->post();
        $id=$post['discountid'];
        $discount= Discount::find()->where(['discount_id'=>$id])->one();
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        return $discount;
    }

 
}
