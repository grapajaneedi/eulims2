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
use common\models\lab\RequestcodeTemplate;
use Yii;
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
        $post=Yii::$app->request->post();
        $rstl_id=$post['rstl_id'];
        $requestcode_template=$post['rtemp'];
        $RequestcodeTemplate= RequestcodeTemplate::find()->where(['rstl_id'=>$rstl_id])->one();
        if(!$RequestcodeTemplate){
            $RequestcodeTemplate=new RequestcodeTemplate();
        }
        $RequestcodeTemplate->rstl_id=$rstl_id;
        $RequestcodeTemplate->requestcode_template=$requestcode_template;
        if($RequestcodeTemplate->save()){//OK
            $Return=[
                'Status'=>'Success',
                'rstl_id'=>$rstl_id,
                'requestcode_template'=>$RequestcodeTemplate->requestcode_template
            ];
        }else{//Failed to save
            $Return=[
                'Status'=>'Failed',
                'rstl_id'=>0,
                'requestcode_template'=>''
            ];
        }
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        return $Return;
    }
    public function actionGettemplate(){
        $post=Yii::$app->request->post();
        $rstl_id=$post['rstl_id'];
        $RequestcodeTemplate= RequestcodeTemplate::find()->where(['rstl_id'=>$rstl_id])->one();
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        if(!$RequestcodeTemplate){
           $RequestcodeTemplate=[
               'requestcode_template_id'=>0,
               'rstl_id'=>0,
               'requestcode_template'=>''
           ]; 
        }
        return $RequestcodeTemplate;
    }
}
