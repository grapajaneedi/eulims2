<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use \yii\helpers\ArrayHelper;
use common\models\system\Rstl;
use common\models\lab\Lab;
use common\models\lab\Request;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requests';
$this->params['breadcrumbs'][] = ['label' => 'Lab', 'url' => ['/lab']];
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
?>
<div class="request-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
        echo $func->GenerateStatusLegend("Legend/Status",false);
    ?>
    <p>
        <button type="button" onclick="LoadModal('Create Request','/lab/request/create')" class="btn btn-success"><i class="fa fa-book-o    "></i> Create Request</button>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'RequestGrid',
        'filterModel' => $searchModel,
        'containerOptions' => ['style' => 'overflow-x: none!important','class'=>'kv-grid-container'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => false,
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-book"></i>  Request',
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'request_ref_num',
            [
                'label'=>'Request Date',
                'attribute'=>'request_datetime',
                'filterType' => GridView::FILTER_DATE,
                'value'=>function($model){
                    return date('m/d/Y h:i:s A',$model->request_datetime);
                }
            ],
            'customer.customer_name',
            [
                'attribute' => 'rstl_id', 
                'label'=>'RSTL',
                'vAlign' => 'middle',
                'width' => '180px',
                'value' => function ($model, $key, $index, $widget) { 
                    return Html::a($model->rstl->name,  
            '#', 
            ['title' => 'View author detail', 'onclick' => 'alert("This will open the author page.\n\nDisabled for this demo!")']);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Rstl::find()->orderBy('region_id')->asArray()->all(), 'rstl_id', 'name'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select RSTL'],
                'format' => 'raw'
            ],
            [
                'attribute' => 'lab_id', 
                'label'=>'Laboratory',
                'vAlign' => 'middle',
                'width' => '180px',
                'value' => function ($model, $key, $index, $widget) { 
                    return Html::a($model->lab->labname,  
            '#', 
            ['title' => 'View author detail', 'onclick' => 'alert("This will open the author page.\n\nDisabled for this demo!")']);
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Lab::find()->orderBy('labname')->asArray()->all(), 'lab_id', 'labname'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Laboratory'],
                'format' => 'raw'
            ],
            [
            //'class' => 'yii\grid\ActionColumn'
            'class' => kartik\grid\ActionColumn::className(),
            'template' => "{view}{update}{delete}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/lab/request/view?id=' . $model->request_id, 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Request")]);
                    },
                    'update' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => '/lab/request/update?id=' . $model->request_id, 'onclick' => 'LoadModal(this.title, this.value);', 'class' => 'btn btn-success', 'title' => Yii::t('app', "Update Request")]);
                    }
                ],
            ],
        ],
]); ?>
</div>
