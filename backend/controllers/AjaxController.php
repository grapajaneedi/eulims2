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
use common\models\lab\CodeTemplate;
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
        $samplecode_template=$post['stemp'];
        $CodeTemplate= CodeTemplate::find()->where(['rstl_id'=>$rstl_id])->one();
        if(!$CodeTemplate){
            $CodeTemplate=new CodeTemplate();
        }
        $CodeTemplate->rstl_id=$rstl_id;
        $CodeTemplate->request_code_template=$requestcode_template;
        $CodeTemplate->sample_code_template=$samplecode_template;
        if($CodeTemplate->save()){//OK
            $Return=[
                'Status'=>'Success',
                'rstl_id'=>$rstl_id,
                'request_code_template'=>$CodeTemplate->request_code_template,
                'sample_code_template'=>$CodeTemplate->sample_code_template,
            ];
        }else{//Failed to save
            $Return=[
                'Status'=>'Failed',
                'rstl_id'=>0,
                'request_code_template'=>'',
                'sample_code_template'=>''
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
