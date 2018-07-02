<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Op;
use yii\data\ActiveDataProvider;
use frontend\modules\finance\components\models\OpSearchNoneLab;
use common\models\finance\OpSearch;

class AccountingController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionOp()
    {
        $model =new Op();
        $searchModel = new OpSearchNoneLab();
        $Op_Query = Op::find()->where(['>', 'collectiontype_id',2]);
        $dataProvider = new ActiveDataProvider([
                'query' => $Op_Query,
                'pagination' => [
                    'pageSize' => 10,
                ],
        ]);
        return $this->render('op/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    public function actionOpLab()
    {
        $model =new Op();
        $searchModel = new OpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('op_lab/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
}
