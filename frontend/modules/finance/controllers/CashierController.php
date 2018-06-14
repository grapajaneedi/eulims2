<?php

namespace frontend\modules\finance\controllers;

class CashierController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
