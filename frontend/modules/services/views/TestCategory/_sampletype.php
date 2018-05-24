<?php

use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel common\models\services\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$dataProvider = new ArrayDataProvider([
    'allModels' => $model->testcategory_id,
    'key' => 'sample_type_id'
]);
    GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'testcategory_id',
            // 'fee',
            // 'duration',
            // 'test_category_id',
            // 'sample_type_id',
            // 'lab_id',

          
        ],
    ]); ?>
</div>
