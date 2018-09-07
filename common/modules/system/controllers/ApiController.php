<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 09 7, 18 , 10:00:10 AM * 
 * Module: ApiController * 
 */

namespace common\modules\system\controllers;
use yii\web\Controller;
/**
 * Description of ApiController
 *
 * @author OneLab
 */
class ApiController extends Controller{
    public function actionConfig(){
        return $this->render('apiconfig');
    }
}
