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
            foreach ($myvar as $var) {

                $newCustomer = new Customer();
                $newCustomer->rstl_id=$var['rstl_id'];
                $newCustomer->customer_name=$var['customerName'];
                $newCustomer->classification_id=$var['classification_id'];
                $newCustomer->latitude=$var['latitude'];
                $newCustomer->longitude=$var['longitude'];
                $newCustomer->head=$var['head'];
                $newCustomer->barangay_id=$var['barangay_id'];
                $newCustomer->address=$var['address'];
                $newCustomer->tel=$var['tel'];
                $newCustomer->fax=$var['fax'];
                $newCustomer->email=$var['email'];
                $newCustomer->customer_type_id=$var['typeId'];
                $newCustomer->business_nature_id=$var['natureId'];
                $newCustomer->industrytype_id=$var['industryId'];
                $newCustomer->created_at=strtotime($var['created']);
                $newCustomer->customer_old_id=$var['id'];
                $newCustomer->Oldcolumn_municipalitycity_id=$var['municipalitycity_id'];
                $newCustomer->Oldcolumn_district=$var['district'];
                if($newCustomer->save()){
                    $ctr++;
                }
            }
            echo $ctr;

    }
}
