<?php

namespace frontend\modules\finance\controllers;

class BillingController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionManager(){
        return $this->render('manager');
    }
    public function actionClient(){
        return $this->render('client/index');
    }
    public function actionInvoices(){
        return $this->render('invoices');
    }
    public function actionAr(){
        return $this->render('ar');
    }
    public function actionReports(){
        return $this->render('reports');
    }
}
