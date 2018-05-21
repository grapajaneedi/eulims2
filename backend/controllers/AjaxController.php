<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 05 18, 18 , 4:57:19 PM * 
 * Module: AjaxController * 
 */

namespace backend\controllers;
use yii\filters\VerbFilter;
/**
 * Description of AjaxController
 *
 * @author OneLab
 */
class AjaxController extends \yii\web\Controller{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                   // 'saverequesttemplate'=>['POST']
                ],
            ],
        ];
    }
    public function actionSaverequesttemplate(){
        if(\Yii::$app->request->isAjax){
        echo "THIS IS A TEST";
        }
    }
}
