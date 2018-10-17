<?php 

namespace frontend\modules\api\controllers;
set_time_limit(600);
use yii\web\Controller;
use Yii;
use linslin\yii2\curl;
use common\models\lab\Restore_request;
use common\models\lab\Restore_sample;
use common\models\lab\Restore_analysis;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Customer;
use common\models\lab\BackuprestoreSearch;
use common\models\lab\Backuprestore;
use yii\helpers\Json;

/**
 * Default controller for the `Lab` module
 */
class LabController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
     public function actionIndex()
     {
         $searchModel = new BackuprestoreSearch();
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Backuprestore();
         return $this->render('backup_restore', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
             'model'=>$model,
         ]);
     }
     public function actionRes(){
        $month = $_POST['month'];
        $year =  $_POST['year'];
            
         if ($month=="January"){
            $month_value = "01";
        }elseif ($month=="February"){
            $month_value = "02";
        }elseif ($month=="March"){
            $month_value = "03";
        }elseif ($month=="April"){
            $month_value = "04";
        }elseif ($month=="May"){
            $month_value = "05";
        }elseif ($month=="June"){
            $month_value = "06";
        }elseif ($month=="July"){
            $month_value = "07";
        }elseif ($month=="August"){
            $month_value = "08";
        }elseif($month=="September"){
            $month_value = "09";
        }elseif($month=="October"){
            $month_value = "10";
        }elseif ($month=="November"){
            $month_value = "11";
        }elseif ($month=="December"){
            $month_value = "12";
        }

        $start = date('Y-m-d',strtotime($year."-".$month_value."-01"));
        $end = date('Y-m-d',strtotime($year."-".$month_value."-31"));

        $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

          //$apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restore?rstl_id=".$GLOBALS['rstl_id']."&reqds=".$year."-".$month_value."-01&reqde=".$year."-".$month_value."-31&pp=5&page=1";
  
          $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&reqds=".$start."&reqde=".$end;

          $curl = new curl\Curl();

          $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
     
          $responselab = $curl->get($apiUrl);
          
          $lab = Json::decode($responselab);
       
          $sql = "SET FOREIGN_KEY_CHECKS = 0;";
          $Connection = Yii::$app->labdb;
        
          $request_count = 0;
          $sample_count = 0;
          $analysis_count = 0;

         Yii::$app->labdb->createCommand('set foreign_key_checks=0')->execute();

          foreach ($lab as $var)
          {    
                      $newRequest = new Restore_request();    
                      $newRequest->request_id = $var['request_old_id'];
                      $newRequest->request_ref_num = $var['request_ref_num'];
                      $newRequest->request_datetime= $var['request_datetime'];
                      $newRequest->rstl_id= $var['rstl_id'];
                      $newRequest->lab_id= $var['lab_id'];
                      $newRequest->customer_id= $var['customer_id'];
                      $newRequest->payment_type_id= $var['payment_type_id'];
                      $newRequest->modeofrelease_ids= $var['modeofrelease_ids'];
                      $newRequest->discount = $var['discount'];
                      $newRequest->purpose_id= $var['purpose_id'];
                      $newRequest->conforme= $var['conforme'];
                      $newRequest->report_due= $var['report_due'];
                      $newRequest->total = $var['total'];
                      $newRequest->receivedBy = $var['receivedBy'];
                      $newRequest->recommended_due_date = $var['recommended_due_date'];
                      $newRequest->est_date_completion = $var['est_date_completion'];
                      $newRequest->items_receive_by = $var['items_receive_by'];
                      $newRequest->equipment_release_date = $var['equipment_release_date'];
                      $newRequest->certificate_release_date = $var['certificate_release_date'];
                      $newRequest->released_by = $var['released_by'];
                      $newRequest->posted = $var['posted'];
                      $newRequest->status_id = $var['status_id'];
                      $newRequest->selected = $var['selected'];
                      $newRequest->other_fees_id = $var['other_fees_id'];
                      $newRequest->request_type_id = $var['request_type_id'];
                      $newRequest->position = $var['position'];
                      $newRequest->completed = $var['completed'];
                      $newRequest->received_by = $var['received_by'];
                      $newRequest->payment_status_id = $var['payment_status_id'];
                      $newRequest->oldColumn_requestId= $var['oldColumn_requestId'];
                      $newRequest->oldColumn_sublabId= $var['oldColumn_sublabId'];
                      $newRequest->oldColumn_orId = $var['oldColumn_orId'];
                      $newRequest->oldColumn_completed= $var['oldColumn_completed'];
                      $newRequest->oldColumn_cancelled= $var['oldColumn_cancelled'];
                      $newRequest->oldColumn_create_time= $var['oldColumn_create_time'];
                      $newRequest->request_old_id= $var['request_old_id'];
                      $newRequest->created_at= $var['created_at'];
                      $newRequest->discount_id= $var['discount_id'];
                      $newRequest->customer_old_id= $var['customer_old_id'];
                      $newRequest->tmpCustomerID= $var['tmpCustomerID'];
                      $newRequest->save();
                      $request_count++;
          

                      $sample = $var['sample'];
                     
                      foreach ($sample as $samp){
                          $sample_count++;          
                          $newSample = new Restore_sample();
                          $newSample->rstl_id=$samp['rstl_id'];
                          $newSample->sample_id=$samp['sample_old_id'];
                          $newSample->pstcsample_id=$samp['pstcsample_id'];
                          $newSample->sampletype_id=$samp['sampletype_id'];
                          $newSample->package_id=$samp['package_id'];
                          $newSample->package_rate=$samp['package_rate'];
                          $newSample->sample_code=$samp['sample_code'];
                          $newSample->samplename=$samp['samplename'];
                          $newSample->description=$samp['description'];
                          $newSample->sampling_date=$samp['sampling_date'];
                          $newSample->remarks=$samp['remarks'];
                          $newSample->request_id=$samp['old_request_id'];
                          $newSample->sample_month=$samp['sample_month'];
                          $newSample->sample_year=$samp['sample_year'];
                          $newSample->active=$samp['active'];
                          $newSample->sample_old_id=$samp['sample_old_id'];
                          $newSample->oldColumn_requestId=$samp['oldColumn_requestId'];
                          $newSample->oldColumn_completed=$samp['oldColumn_completed'];
                          $newSample->oldColumn_datedisposal=$samp['oldColumn_datedisposal'];
                          $newSample->oldColumn_mannerofdisposal=$samp['oldColumn_mannerofdisposal'];
                          $newSample->oldColumn_batch_num=$samp['oldColumn_batch_num'];
                          $newSample->oldColumn_package_count=$samp['oldColumn_package_count'];
                          $newSample->testcategory_id=$samp['testcategory_id'];
                          $newSample->save(true); 
                          
              }    
              
              $analyses = $var['analyses'];
             
              foreach ($analyses as $anals){
                      $analysis_count++;
                      $newanalysis = new Restore_analysis();
                      $newanalysis->analysis_id=$anals['analysis_old_id'];
                      $newanalysis->rstl_id=$anals['rstl_id'];
                      $newanalysis->pstcanalysis_id=$anals['pstcanalysis_id'];
                      $newanalysis->sample_id =$anals['old_sample_id'];
                      $newanalysis->sample_code=$anals['sample_code'];
                      $newanalysis->testname=$anals['testname'];
                      $newanalysis->method=$anals['method'];
                      $newanalysis->references=$anals['references'];
                      $newanalysis->quantity=$anals['quantity'];
                      $newanalysis->fee=$anals['fee'];
                      $newanalysis->test_id=$anals['test_id'];
                      $newanalysis->cancelled=$anals['cancelled'];
                      $newanalysis->date_analysis=$anals['date_analysis'];
                      $newanalysis->user_id=$anals['user_id'];
                      $newanalysis->is_package=$anals['is_package'];
                      $newanalysis->oldColumn_deleted=$anals['oldColumn_deleted'];
                      $newanalysis->analysis_old_id=$anals['analysis_old_id'];
                      $newanalysis->oldColumn_taggingId=$anals['oldColumn_taggingId'];
                      $newanalysis->oldColumn_result=$anals['oldColumn_result'];
                      $newanalysis->oldColumn_package_count=$anals['oldColumn_package_count'];
                      $newanalysis->oldColumn_requestId=$anals['oldColumn_requestId'];
                      $newanalysis->request_id =  43;
                      $newanalysis->testcategory_id=$anals['testcategory_id'];
                      $newanalysis->sample_type_id=$anals['sample_type_id'];
                      $newanalysis->old_sample_id=$anals['old_sample_id'];
                      $newanalysis->save(true);
                   
                    }
            }
              $sql = "SET FOREIGN_KEY_CHECKS = 1;"; 

                $searchModel = new BackuprestoreSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                
                    $model = new Backuprestore();
                    $model->activity = "Restored data for the month of ".$month."-".$year;
                    $model->date = date('Y-M-d');
                    $model->data = $request_count."/".$request_count;
                    $model->status = "COMPLETED";
                    $model->month = $sample_count."/".$sample_count;
                    $model->year = $analysis_count."/".$analysis_count;
                     $model->year = $analysis_count."/".$analysis_count;
                    $model->save(false);


           //   Yii::$app->session->setFlash('success', ' Records Successfully Restored'.$request_count); 


           //   return $this->redirect(['/api/lab/index']);

              return $this->renderAjax('/lab/backup_restore', [
                 'model'=>$model,
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]);
     
     }

    public function actionRestore(){

      
                  //  $apiUrl="https://api.onelab.ph/api/web/v1/requests/restore?rstl_id=11&pp=1&page=".$x;   

                  $year = "2015";
                  $month_value = "01";
                 $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restore?rstl_id=11&reqds=".$year."-".$month_value."-01&reqde=".$year."-".$month_value."-31&pp=5&page=1";
  
                  
                //   https://api.onelab.ph/api/web/v1/requests/restore?rstl_id=11&reqds=2015-01-01&reqde=2015-02-01&pp=5&page=1
                //   $apiUrls = "https://eulimsapi.onelab.ph/api/web/v1/requests/restore?rstl_id=11&reqds=2015-01-01&reqde=2015-02-01&pp=5&page=1";
                    $curl = new curl\Curl();
                    $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
                    $responselab = $curl->get($apiUrl);
                    
                    $lab = Json::decode($responselab);
                 
                   // echo "<pre>";
                  print_r($lab);
                   // echo "</pre>";
                  // echo "huhu";

            //    echo  $apiUrl."<br>".$apiUrls;
                    exit;

                    $sql = "SET FOREIGN_KEY_CHECKS = 0;";
                    $Connection = Yii::$app->labdb;
                  
                   Yii::$app->labdb->createCommand('set foreign_key_checks=0')->execute();
                    foreach ($lab as $var)
                    {    
                                $newRequest = new Restore_request();    
                                $newRequest->request_id = $var['request_old_id'];
                                $newRequest->request_ref_num = $var['request_ref_num'];
                                $newRequest->request_datetime= $var['request_datetime'];
                                $newRequest->rstl_id= $var['rstl_id'];
                                $newRequest->lab_id= $var['lab_id'];
                                $newRequest->customer_id= $var['customer_id'];
                                $newRequest->payment_type_id= $var['payment_type_id'];
                                $newRequest->modeofrelease_ids= $var['modeofrelease_ids'];
                                $newRequest->discount = $var['discount'];
                                $newRequest->purpose_id= $var['purpose_id'];
                                $newRequest->conforme= $var['conforme'];
                                $newRequest->report_due= $var['report_due'];
                                $newRequest->total = $var['total'];
                                $newRequest->receivedBy = $var['receivedBy'];
                                $newRequest->recommended_due_date = $var['recommended_due_date'];
                                $newRequest->est_date_completion = $var['est_date_completion'];
                                $newRequest->items_receive_by = $var['items_receive_by'];
                                $newRequest->equipment_release_date = $var['equipment_release_date'];
                                $newRequest->certificate_release_date = $var['certificate_release_date'];
                                $newRequest->released_by = $var['released_by'];
                                $newRequest->posted = $var['posted'];
                                $newRequest->status_id = $var['status_id'];
                                $newRequest->selected = $var['selected'];
                                $newRequest->other_fees_id = $var['other_fees_id'];
                                $newRequest->request_type_id = $var['request_type_id'];
                                $newRequest->position = $var['position'];
                                $newRequest->completed = $var['completed'];
                                $newRequest->received_by = $var['received_by'];
                                $newRequest->payment_status_id = $var['payment_status_id'];
                                $newRequest->oldColumn_requestId= $var['oldColumn_requestId'];
                                $newRequest->oldColumn_sublabId= $var['oldColumn_sublabId'];
                                $newRequest->oldColumn_orId = $var['oldColumn_orId'];
                                $newRequest->oldColumn_completed= $var['oldColumn_completed'];
                                $newRequest->oldColumn_cancelled= $var['oldColumn_cancelled'];
                                $newRequest->oldColumn_create_time= $var['oldColumn_create_time'];
                                $newRequest->request_old_id= $var['request_old_id'];
                                $newRequest->created_at= $var['created_at'];
                                $newRequest->discount_id= $var['discount_id'];
                                $newRequest->customer_old_id= $var['customer_old_id'];
                                $newRequest->tmpCustomerID= $var['tmpCustomerID'];
                                $newRequest->save();
                    }
                                $sample = $var['sample'];
                                foreach ($sample as $samp){
                                  
                                    $newSample = new Restore_sample();
                                    $newSample->rstl_id=$samp['rstl_id'];
                                    $newSample->sample_id=$samp['sample_old_id'];
                                    $newSample->pstcsample_id=$samp['pstcsample_id'];
                                    $newSample->sampletype_id=$samp['sampletype_id'];
                                    $newSample->package_id=$samp['package_id'];
                                    $newSample->package_rate=$samp['package_rate'];
                                    $newSample->sample_code=$samp['sample_code'];
                                    $newSample->samplename=$samp['samplename'];
                                    $newSample->description=$samp['description'];
                                    $newSample->sampling_date=$samp['sampling_date'];
                                    $newSample->remarks=$samp['remarks'];
                                    $newSample->request_id=$samp['old_request_id'];
                                    $newSample->sample_month=$samp['sample_month'];
                                    $newSample->sample_year=$samp['sample_year'];
                                    $newSample->active=$samp['active'];
                                    $newSample->sample_old_id=$samp['sample_old_id'];
                                    $newSample->oldColumn_requestId=$samp['oldColumn_requestId'];
                                    $newSample->oldColumn_completed=$samp['oldColumn_completed'];
                                    $newSample->oldColumn_datedisposal=$samp['oldColumn_datedisposal'];
                                    $newSample->oldColumn_mannerofdisposal=$samp['oldColumn_mannerofdisposal'];
                                    $newSample->oldColumn_batch_num=$samp['oldColumn_batch_num'];
                                    $newSample->oldColumn_package_count=$samp['oldColumn_package_count'];
                                    $newSample->testcategory_id=$samp['testcategory_id'];
                                    $newSample->save(true);
                            
                        }    
                        
                        $analyses = $var['analyses'];
                        foreach ($analyses as $anals){
                             
                                $newanalysis = new Restore_analysis();
                                $newanalysis->analysis_id=$anals['analysis_old_id'];
                                $newanalysis->rstl_id=$anals['rstl_id'];
                                $newanalysis->pstcanalysis_id=$anals['pstcanalysis_id'];
                                $newanalysis->sample_id =$anals['old_sample_id'];
                                $newanalysis->sample_code=$anals['sample_code'];
                                $newanalysis->testname=$anals['testname'];
                                $newanalysis->method=$anals['method'];
                                $newanalysis->references=$anals['references'];
                                $newanalysis->quantity=$anals['quantity'];
                                $newanalysis->fee=$anals['fee'];
                                $newanalysis->test_id=$anals['test_id'];
                                $newanalysis->cancelled=$anals['cancelled'];
                                $newanalysis->date_analysis=$anals['date_analysis'];
                                $newanalysis->user_id=$anals['user_id'];
                                $newanalysis->is_package=$anals['is_package'];
                                $newanalysis->oldColumn_deleted=$anals['oldColumn_deleted'];
                                $newanalysis->analysis_old_id=$anals['analysis_old_id'];
                                $newanalysis->oldColumn_taggingId=$anals['oldColumn_taggingId'];
                                $newanalysis->oldColumn_result=$anals['oldColumn_result'];
                                $newanalysis->oldColumn_package_count=$anals['oldColumn_package_count'];
                                $newanalysis->oldColumn_requestId=$anals['oldColumn_requestId'];
                                $newanalysis->request_id =  43;
                                $newanalysis->testcategory_id=$anals['testcategory_id'];
                                $newanalysis->sample_type_id=$anals['sample_type_id'];
                                $newanalysis->old_sample_id=$anals['old_sample_id'];
                                $newanalysis->save(true);
                        }    
                        $sql = "SET FOREIGN_KEY_CHECKS = 1;"; 
                           
      

        Yii::$app->session->setFlash('success', ' Records Successfully Restored'); 
        return $this->redirect(['/api/lab/index']);
    }

    public function actionCustomer()
    {
        return $this->render('customers');
    }
}