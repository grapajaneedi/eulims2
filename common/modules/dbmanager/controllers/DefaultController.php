<?php

namespace common\modules\dbmanager\controllers;

use yii\web\Controller;
use common\modules\dbmanager\models\BackupModel;
/**
 * Default controller for the `dbmanager` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //$backup =\Yii::$app->backup; 
        //$file = $backup->create();
        //echo $file;
        //exit;
       
        //echo "<pre>";
        //var_dump($dbs['backup']['databases']);
        //echo "</pre>";
        $model=new BackupModel();
        $model->database='all';
        $model->extension='tar';
        $model->backupdatabase=1;
        $model->download=1;
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    public function actionCreateBackup(){
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
        //$backup =\Yii::$app->backup; 
        //$file = $backup->create();
        //\Yii::$app->session->setFlash('success', 'Backup created Successfully!');
        //$this->redirect("/dbmanager");
    }
}
