<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 07 2, 18 , 1:39:22 PM * 
 * Module: BillingController * 
 */

namespace frontend\modules\reports\modules\lab\controllers;
use yii\web\Controller;
use Yii;
/**
 * Description of BillingController
 *
 * @author OneLab
 */
class BillingController extends Controller{
     /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
