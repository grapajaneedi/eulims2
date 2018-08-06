<?php

namespace frontend\modules\help\controllers;

class FaqsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionTopics()
    {
        return $this->render('topics');
    }

}
