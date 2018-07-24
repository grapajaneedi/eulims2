<?php

namespace frontend\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\system\Profile;
use kartik\mpdf\Pdf;
use yii\helpers\Json;
use common\models\lab\Customer;

class ApiController extends ActiveController
{
    public $modelClass = 'common\models\system\Profile';
    
    public function verbs() {
        parent::verbs();
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }
    public function actions() {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = function($action) {
            return new \yii\data\ActiveDataProvider([
                'query' => Profile::find()->where(['user_id' => Yii::$app->user->id]),
            ]);
        };

        return $actions;
    }

    public function actionSync_customer(){


        $myvar = Json::decode($_POST['data']);
        $ctr = 0; 
        // var_dump($myvar); exit();
            foreach ($myvar as $var) {
                  // var_dump($var); exit();

                $newCustomer = new Customer();
                $newCustomer->rstl_id=$var['rstl_id'];
                $newCustomer->customer_code=$var['customer_code'];
                $newCustomer->customer_name=$var['customer_name'];
                $newCustomer->classification_id=$var['classification_id'];
                $newCustomer->latitude=$var['latitude'];
                $newCustomer->longitude=$var['longitude'];
                $newCustomer->head=$var['head'];
                $newCustomer->barangay_id=$var['barangay_id'];
                $newCustomer->address=$var['address'];
                $newCustomer->tel=$var['tel'];
                $newCustomer->fax=$var['fax'];
                $newCustomer->email=$var['email'];
                $newCustomer->customer_type_id=$var['customer_type_id'];
                $newCustomer->business_nature_id=$var['business_nature_id'];
                $newCustomer->industrytype_id=$var['industrytype_id'];
                $newCustomer->created_at=$var['created_at'];
                $newCustomer->customer_old_id=$var['customer_old_id'];
                if($newCustomer->save()){
                    $ctr++;
                }
            }
            echo $ctr;

    }
}
