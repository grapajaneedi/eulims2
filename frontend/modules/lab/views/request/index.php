<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use \yii\helpers\ArrayHelper;
use common\models\system\Rstl;
use common\models\lab\Lab;
use common\models\lab\Request;
use common\components\Functions;
use common\models\lab\Customer;

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
            [
                'attribute' => 'customer_id', 
                'label'=>'Customer',
                'vAlign' => 'middle',
                'width' => '180px',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->customer->customer_name;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Customer::find()->orderBy('customer_name')->asArray()->all(), 'customer_id', 'customer_name'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Customer'],
                'format' => 'raw'
            ],      
            [
                'label'=>'Total',
                'attribute'=>'total',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
            ],
            [
                'label'=>'Report Due',
                'attribute'=>'report_due',
                'hAlign'=>'center'
            ],
            [
                'label'=>'Analyses Status',
                'attribute'=>'status_id',
                'hAlign'=>'center',
                'format'=>'raw',
                'value'=>function($model){
                    return "<button class='btn ".$model->status->class." btn-block'>".$model->status->status."</button>";
                }
            ],
            [
                'label'=>'Report Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value'=>function($model){
                    if($model->testreports){
                        return "<button class='btn btn-success btn-block'>View</button>";
                    }else{
                        return "<button class='btn btn-default btn-block'>None</button>";
                    }
                    
                }
            ],
            [
                'label'=>'Payment Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value'=>function($model){
                    $Obj=$model->getPaymentStatusDetails($model->request_id);
                    if($Obj){
                       return "<button class='btn ".$Obj[0]['class']." btn-block'>".$Obj[0]['payment_status']."</button>"; 
                    }else{
                       return "<button class='btn btn-primary btn-block'>Unpaid</button>"; 
                    }
                   //
                }
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
