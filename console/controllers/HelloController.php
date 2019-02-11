<?php

namespace console\controllers;
// namespace app\commands;

use \yii\console\Controller;
use \common\models\inventory\Products;
use \common\components\Functions;

/**
 * This is an example...


**/

class HelloController extends Controller
{

 	public $message;

    
    public function options($actionID)
    {
        return ['message'];
    }
    
    public function optionAliases()
    {
        return ['m' => 'message'];
    }


 
    public function actionIndex($message = 'hello world')
    {
       
       echo $message . "\n";
       

    }
    public function actionCreate($message = 'hello world')
    {
        echo $message . "\n";
    }

}