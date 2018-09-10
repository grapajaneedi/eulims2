<?php

/*
 * Project Name: eulims_ * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 09 7, 18 , 4:38:40 PM * 
 * Module: BackupController * 
 */

namespace common\modules\system\controllers;

use Yii;
use yii\web\Controller;
/**
 * Description of BackupController
 *
 * @author OneLab
 */
class UtilitiesController extends Controller {
    public function actionBackupRestore()
    {
        return $this->render('backup_restore');
    }
    public function actionBackupLab(){
        return "Lab";
    }
    public function actionBackupFinance(){
        return "Finance";
    }
    public function actionBackupInventory(){
        return "Inventory";
    }
}
