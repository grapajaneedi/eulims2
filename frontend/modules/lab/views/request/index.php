<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use \yii\helpers\ArrayHelper;
use common\models\system\Rstl;
use common\models\lab\Lab;
use common\models\lab\Request;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requests';
$this->params['breadcrumbs'][] = ['label' => 'Lab', 'url' => ['/lab']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="request-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Create Request', ['create'], ['class' => 'btn btn-success']) ?>
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
            // 'customer_id',
            // 'payment_type_id',
            // 'modeofrelease_id',
            // 'discount',
            // 'discount_id',
            // 'purpose_id',
            // 'or_id',
            // 'total',
            // 'report_due',
            // 'conforme',
            // 'receivedBy',
            // 'created_at',
            // 'posted',
            // 'status_id',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>
