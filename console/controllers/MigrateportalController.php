<?php

namespace console\controllers;
// namespace app\commands;

use Yii;
use \yii\console\Controller;
use \common\models\inventory\Products;
use \common\components\Functions;

/**
 * This is an example...


**/

class MigrateportalController extends Controller
{

 	public $message;

    public function actionIndex($rstl="100",$region="100")
    {
        if(php_sapi_name() == "cli")
            echo "cli";
        else
            echo "web";

        echo "\n";
    	echo "starting job \n";
        // $func = new Functions;
        // $Connection= Yii::$app->labdb;
        // $series=$func->ExecuteStoredProcedure("spMigrate_EULIMS_LAB_Final(:param_Rstl_ID,:param_Region_Initial)", [':param_Rstl_ID'=> $rstl,'param_Region_Initial'=>$region], $Connection); 


        
        echo "ending job";
    }
    
    public function actionCreate($message = 'hello world')
    {
        echo $message . "\n";
    }

}