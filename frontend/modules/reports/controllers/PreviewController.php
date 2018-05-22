<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 23 May, 2018 , 12:29:24 AM * 
 * Module: PreviewController * 
 */

namespace frontend\modules\reports\controllers;
use yii\web\Controller;
/**
 * Description of PreviewController
 *
 * @author Programmer
 */
class PreviewController extends Controller{
    public function actionIndex(){
        $purl= \Yii::$app->request->url;
        $url= substr($purl,21);  
        return $this->render('preview',['url'=>$url]);
    }
}
