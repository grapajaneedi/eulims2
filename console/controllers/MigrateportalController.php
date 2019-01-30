<?php

namespace console\controllers;
// namespace app\commands;

use Yii;
use \yii\console\Controller;
use \common\models\lab\Jobportal;
use \common\components\Functions;

/**
 * This is an example...


**/

class MigrateportalController extends Controller
{

 	public $message;

    public function actionIndex()
    {

        //get the job queries based on chrono. order but only one which would appear the next job to get
        $job = Jobportal::find()->orderBy(["job_id"=>SORT_ASC])->where(['isdone'=>0])->one();

        if($job){
             $job->isdone=1; //initially take the job prematurely so that the cron job wont pick it up again while running
             $job->remarks= date("Y-m-d")." (still working on)"; //save remarks
             $job->save(false);
            echo "starting job \n";
            $func = new Functions;
            $Connection= Yii::$app->labdb;
            $Transaction =$Connection->beginTransaction();
            //job_type = 0  is for migration to migrationportal, 1= automated linking, 2 = posting the processed tbl to the live yii2
            switch ($job->job_type) {
                case '0':
                        try {
                            $func->ExecuteStoredProcedure("spTransferPullData(:param_Rstl_ID)", [':param_Rstl_ID'=> $job->rstl_id], $Connection); 
                            $Transaction->commit();
                            $job->remarks= date("Y-m-d")." (Success)"; //save remarks
                            if($job->save(false)){ 
                            //if the cron successfully finish the job then create new job for DB linking 
                                $newjob = new Jobportal;
                                $newjob->rstl_id = $job->rstl_id;
                                $newjob->region_initial=$job->region_initial;
                                $newjob->job_type=1;
                                $newjob->save(false);
                            }
                        } catch (Exception $e) {
                            $Transaction->rollback();
                            $job->remarks= date("Y-m-d")." (Fail)"; //save remarks
                            $job->save(false);
                        }

                    break;
                case '1':
                        try {
                            $func->ExecuteStoredProcedure("spMigrate_EULIMS_LAB_Final(:param_Rstl_ID,:param_Region_Initial)", [':param_Rstl_ID'=> $job->rstl_id,'param_Region_Initial'=>$job->region_initial], $Connection); 
                            $Transaction->commit();
                            $job->remarks= date("Y-m-d")." (Success)"; //save remarks
                            if($job->save(false)){
                                 //if the cron successfully finish the job then create new job for posting DB 
                                $newjob = new Jobportal;
                                $newjob->rstl_id = $job->rstl_id;
                                $newjob->region_initial=$job->region_initial;
                                $newjob->job_type=2;
                                $newjob->save(false);
                            }

                        } catch (Exception $e) {
                            $Transaction->rollback();
                            $job->remarks= date("Y-m-d")." (Fail)"; //save remarks
                            $job->save(false);
                        }
                     
                    break;

                case '2':
                        try {
                            $func->ExecuteStoredProcedure("spTransferPostData(:param_Rstl_ID)", [':param_Rstl_ID'=> $job->rstl_id], $Connection); 
                            $Transaction->commit();
                            $job->remarks= date("Y-m-d")." (Success)"; //save remarks
                            $job->save(false);
                        } catch (Exception $e) {
                            $Transaction->rollback();
                            $job->remarks= date("Y-m-d")." (Fail)"; //save remarks
                            $job->save(false);
                        }

                    break;

                default:
                    # code...
                    break;
            }


             echo "ending job";



        }else{
            echo "no pending job.";
        }
    }
    
    public function actionCreate($message = 'hello world')
    {
        echo $message . "\n";
    }

}