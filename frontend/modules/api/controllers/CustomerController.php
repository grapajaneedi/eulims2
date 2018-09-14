<?php 

namespace frontend\modules\api\controllers;

use yii\web\Controller;
use Yii;
use linslin\yii2\curl;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Customer;
use yii\helpers\Json;

/**
 * Default controller for the `Lab` module
 */
class CustomerController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('backup_restore');

    }

    public function actionRestore(){
         $model = new Customer();
        $rstl_id=$model->rstl_id=Yii::$app->user->identity->profile->rstl_id;
        
        $apiUrl="https://api3.onelab.ph/get/customer/view?rstl_id=11&page=1&per-page=1000";
        $curl = new curl\Curl();
        $res = $curl->get($apiUrl);

         $decode=Json::decode($res);
        $exist=0;
        $not_exist=0;
        foreach ($decode as $customer){
            $cust=Customer::find()->where(['customer_code'=>$customer['customer_code']])->all();
            if($cust){
               $exist++; 
            }
            else{
                $model_customer = new Customer();
                $model_customer->rstl_id=$rstl_id;
                $model_customer->customer_code=$customer['customer_code'];
                $model_customer->customer_name=$customer['customer_name'];
                $model_customer->classification_id=$customer['classification_id'];
                $model_customer->latitude=$customer['latitude'];
                $model_customer->longitude=$customer['longitude'];
                $model_customer->head=$customer['head'];
                $model_customer->barangay_id=$customer['barangay_id'];
                $model_customer->address=$customer['address'];
                $model_customer->tel=$customer['tel'];
                $model_customer->fax=$customer['fax'];
                $model_customer->email=$customer['email'];
                $model_customer->customer_type_id=$customer['customer_type_id'];
                $model_customer->business_nature_id=$customer['business_nature_id'];
                $model_customer->industrytype_id=$customer['industrytype_id'];
                $model_customer->created_at=$customer['created_at'];
                $model_customer->customer_old_id=$customer['customer_old_id'];
                $model_customer->Oldcolumn_municipalitycity_id=$customer['Oldcolumn_municipalitycity_id'];
                $model_customer->Oldcolumn_district=$customer['Oldcolumn_district'];
                $model_customer->save();
                $not_exist++;
            }
           
        }

        Yii::$app->session->setFlash('success', $not_exist.' Records Successfully Restored'); 
        return $this->redirect(['index']);
    }


    public function actionCustomer()
    {
        return $this->render('customers');
    }
}