<?php 

namespace frontend\modules\api\controllers;
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

set_time_limit(2000);

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
		$searchModel = new BackuprestoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Backuprestore();
        	 
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
        $br = Backuprestore::find()->where([ 'monthyear'=> $month_value.$year])->one();

       if ($br) {
            $message = "The month you have selected has been succesfully restored.";
            return Json::encode([
                'message'=>$message,
            
            ]);
            exit;
            }

        for($month=1;$month < 13;$month++){

            if ($month>9){
                $start = $year."-".$month;
                $end = $year."-".$month;
            }else{
                $start = $year."-"."0".$month;
                $end = $year."-"."0".$month;
            }
          
            
            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
    
            $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&reqds=".$start."&reqde=".$end;
                
            $curl = curl_init();
                    
            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
            curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
            $response = curl_exec($curl);
                
            $data = json_decode($response, true);
              
              /*echo "<pre>";
              print_r($data);
              echo "</pre>";
              exit;*/
           
            $sql = "SET FOREIGN_KEY_CHECKS = 0;";
            $connection = Yii::$app->labdb;
            
            $request_count = 0;
            $sample_count = 0;
            $analysis_count = 0;
            $samplenum = 0;
            $analysesnum = 0;
    
             //Yii::$app->labdb->createCommand('set foreign_key_checks=0')->execute();
                $transaction = $connection->beginTransaction();
                $connection->createCommand('set foreign_key_checks=0')->execute();
                
            //ADD CODE FOR CUSTOMERS HERE
            
            try {
              foreach ($data as $request)
              {    
                          $newRequest = new Restore_request();    
                          $newRequest->request_id = $request['request_old_id'];
                          $newRequest->request_ref_num = $request['request_ref_num'];
                          $newRequest->request_datetime= $request['request_datetime'];
                          $newRequest->rstl_id= $request['rstl_id'];
                          $newRequest->lab_id= $request['lab_id'];
                          $newRequest->customer_id= $request['customer_id'];
                          $newRequest->payment_type_id= $request['payment_type_id'];
                          $newRequest->modeofrelease_ids= $request['modeofrelease_ids'];
                          $newRequest->discount = $request['discount'];
                          $newRequest->purpose_id= $request['purpose_id'];
                          $newRequest->conforme= $request['conforme'];
                          $newRequest->report_due= $request['report_due'];
                          $newRequest->total = $request['total'];
                          $newRequest->receivedBy = $request['receivedBy'];
                          $newRequest->recommended_due_date = $request['recommended_due_date'];
                          $newRequest->est_date_completion = $request['est_date_completion'];
                          $newRequest->items_receive_by = $request['items_receive_by'];
                          $newRequest->equipment_release_date = $request['equipment_release_date'];
                          $newRequest->certificate_release_date = $request['certificate_release_date'];
                          $newRequest->released_by = $request['released_by'];
                          $newRequest->posted = $request['posted'];
                          $newRequest->status_id = $request['status_id'];
                          $newRequest->selected = $request['selected'];
                          $newRequest->other_fees_id = $request['other_fees_id'];
                          $newRequest->request_type_id = $request['request_type_id'];
                          $newRequest->position = $request['position'];
                          $newRequest->completed = $request['completed'];
                          $newRequest->received_by = $request['received_by'];
                          $newRequest->payment_status_id = $request['payment_status_id'];
                          $newRequest->oldColumn_requestId= $request['oldColumn_requestId'];
                          $newRequest->oldColumn_sublabId= $request['oldColumn_sublabId'];
                          $newRequest->oldColumn_orId = $request['oldColumn_orId'];
                          $newRequest->oldColumn_completed= $request['oldColumn_completed'];
                          $newRequest->oldColumn_cancelled= $request['oldColumn_cancelled'];
                          $newRequest->oldColumn_create_time= $request['oldColumn_create_time'];
                          $newRequest->request_old_id= $request['request_old_id'];
                          $newRequest->created_at= $request['created_at'];
                          $newRequest->discount_id= $request['discount_id'];
                          $newRequest->customer_old_id= $request['customer_old_id'];
                          $newRequest->tmpCustomerID= $request['tmpCustomerID'];
                          $newRequest->save();
                          $request_count++;
                          
                          foreach ($request['sample'] as $samp){
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
                 
                        foreach ($samp['analyses'] as $anals){
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
                    $samplenum = $samplenum + $request['countSample'];
                    $analysesnum = $analysesnum + $request['countAnalysis'];
                    
                }
        
                    Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$month.' '.$year); 
                    $transaction->commit();
                    
                    $sql = "SET FOREIGN_KEY_CHECKS = 1;";
                    
                    $model->activity = "Restored data for the month of ".$month."-".$year;
                    $model->date = date('Y-M-d');
                    $model->data = count($data)."/".$request_count;
                    $model->status = "COMPLETED";
                    $model->month = $sample_count."/".$samplenum;
                    $model->monthyear = $month_value.$year;
                
                    $model->year = $analysis_count."/".$analysesnum;
                    Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$month.' '.$year); 
                    $model->save(false);
            
            } catch (\Exception $e) {
               
              
                $message = "There was a problem connecting to the server. Please try again.";
                return Json::encode([
                    'message'=>$message,
                
                ]);
                exit;
    
                $transaction->rollBack();
               return $this->renderAjax('/lab/backup_restore', [
                'model'=>$model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
            } catch (\Throwable $e) {
                $message = "There was a problem connecting to the server. Please try again.";
                return Json::encode([
                    'message'=>$message,
                
                ]);
                exit;
                $transaction->rollBack();
               return $this->renderAjax('/lab/backup_restore', [
                'model'=>$model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
            }
        }
      
        
        $message = "Data has been successfully restored.";
        return Json::encode([
            'message'=>$message,
        
        ]);
        exit;
              return $this->renderAjax('/lab/backup_restore', [
                 'model'=>$model,
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]);
     
     }

     public function actionResyear(){	

    
        // for ($i = 1; $i < 11; $i++) {
        //         $message = $i;

        //         return Json::encode([
        //             'message'=>$message,
                
        //         ]);
        // } 

       

        // exit;

		$searchModel = new BackuprestoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Backuprestore();
        	 
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
        $br = Backuprestore::find()->where([ 'monthyear'=> $month_value.$year])->one();

       if ($br) {
            $message = "The month you have selected has been succesfully restored.";
            return Json::encode([
                'message'=>$message,
            
            ]);
            exit;
            }

        $start = $year."-".$month_value;
        $end = $year."-".$month_value;
		
        $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;

        $apiUrl="https://eulimsapi.onelab.ph/api/web/v1/requests/restore?rstl_id=".Yii::$app->user->identity->profile->rstl_id."&reqds=".$start."&reqde=".$end;
            
        $curl = curl_init();
				
		curl_setopt($curl, CURLOPT_URL, $apiUrl);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //additional code
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); //additional code
		curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY); //additional code
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($curl);
			
		$data = json_decode($response, true);
		  
		  /*echo "<pre>";
		  print_r($data);
		  echo "</pre>";
		  exit;*/
       
        $sql = "SET FOREIGN_KEY_CHECKS = 0;";
        $connection = Yii::$app->labdb;
        
        $request_count = 0;
        $sample_count = 0;
        $analysis_count = 0;
		$samplenum = 0;
		$analysesnum = 0;

         //Yii::$app->labdb->createCommand('set foreign_key_checks=0')->execute();
			$transaction = $connection->beginTransaction();
			$connection->createCommand('set foreign_key_checks=0')->execute();
            
        //ADD CODE FOR CUSTOMERS HERE
        
		try {
          foreach ($data as $request)
          {    
                      $newRequest = new Restore_request();    
                      $newRequest->request_id = $request['request_old_id'];
                      $newRequest->request_ref_num = $request['request_ref_num'];
                      $newRequest->request_datetime= $request['request_datetime'];
                      $newRequest->rstl_id= $request['rstl_id'];
                      $newRequest->lab_id= $request['lab_id'];
                      $newRequest->customer_id= $request['customer_id'];
                      $newRequest->payment_type_id= $request['payment_type_id'];
                      $newRequest->modeofrelease_ids= $request['modeofrelease_ids'];
                      $newRequest->discount = $request['discount'];
                      $newRequest->purpose_id= $request['purpose_id'];
                      $newRequest->conforme= $request['conforme'];
                      $newRequest->report_due= $request['report_due'];
                      $newRequest->total = $request['total'];
                      $newRequest->receivedBy = $request['receivedBy'];
                      $newRequest->recommended_due_date = $request['recommended_due_date'];
                      $newRequest->est_date_completion = $request['est_date_completion'];
                      $newRequest->items_receive_by = $request['items_receive_by'];
                      $newRequest->equipment_release_date = $request['equipment_release_date'];
                      $newRequest->certificate_release_date = $request['certificate_release_date'];
                      $newRequest->released_by = $request['released_by'];
                      $newRequest->posted = $request['posted'];
                      $newRequest->status_id = $request['status_id'];
                      $newRequest->selected = $request['selected'];
                      $newRequest->other_fees_id = $request['other_fees_id'];
                      $newRequest->request_type_id = $request['request_type_id'];
                      $newRequest->position = $request['position'];
                      $newRequest->completed = $request['completed'];
                      $newRequest->received_by = $request['received_by'];
                      $newRequest->payment_status_id = $request['payment_status_id'];
                      $newRequest->oldColumn_requestId= $request['oldColumn_requestId'];
                      $newRequest->oldColumn_sublabId= $request['oldColumn_sublabId'];
                      $newRequest->oldColumn_orId = $request['oldColumn_orId'];
                      $newRequest->oldColumn_completed= $request['oldColumn_completed'];
                      $newRequest->oldColumn_cancelled= $request['oldColumn_cancelled'];
                      $newRequest->oldColumn_create_time= $request['oldColumn_create_time'];
                      $newRequest->request_old_id= $request['request_old_id'];
                      $newRequest->created_at= $request['created_at'];
                      $newRequest->discount_id= $request['discount_id'];
                      $newRequest->customer_old_id= $request['customer_old_id'];
                      $newRequest->tmpCustomerID= $request['tmpCustomerID'];
                      $newRequest->save();
                      $request_count++;
					  
                      foreach ($request['sample'] as $samp){
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
             
					foreach ($samp['analyses'] as $anals){
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
				$samplenum = $samplenum + $request['countSample'];
				$analysesnum = $analysesnum + $request['countAnalysis'];
				
            }
	
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$month.' '.$year); 
                $transaction->commit();
				
				$sql = "SET FOREIGN_KEY_CHECKS = 1;";
                
				$model->activity = "Restored data for the month of ".$month."-".$year;
				$model->date = date('Y-M-d');
				$model->data = count($data)."/".$request_count;
				$model->status = "COMPLETED";
                $model->month = $sample_count."/".$samplenum;
                $model->monthyear = $month_value.$year;
			
                $model->year = $analysis_count."/".$analysesnum;
                Yii::$app->session->setFlash('success', ' Records Successfully Restored for '.$month.' '.$year); 
				$model->save(false);
		
		} catch (\Exception $e) {
           
          
            $message = "There was a problem connecting to the server. Please try again.";
            return Json::encode([
                'message'=>$message,
            
            ]);
            exit;

            $transaction->rollBack();
           return $this->renderAjax('/lab/backup_restore', [
            'model'=>$model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		} catch (\Throwable $e) {
            $message = "There was a problem connecting to the server. Please try again.";
            return Json::encode([
                'message'=>$message,
            
            ]);
            exit;
            $transaction->rollBack();
           return $this->renderAjax('/lab/backup_restore', [
            'model'=>$model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }
        
        $message = "Data has been successfully restored.";
        return Json::encode([
            'message'=>$message,
        
        ]);
        exit;
              return $this->renderAjax('/lab/backup_restore', [
                 'model'=>$model,
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]);
     
     }


    public function actionCustomer()
    {
        return $this->render('customers');
    }
}