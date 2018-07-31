<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
use \yii\helpers\ArrayHelper;
use common\models\system\Rstl;
use kartik\widgets\DatePicker;
use common\models\lab\Lab;
use common\models\lab\Request;
use common\components\Functions;
use common\models\lab\Customer;
use yii\bootstrap\Modal;
use common\models\finance\Paymentitem;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requests';
$this->params['breadcrumbs'][] = ['label' => 'Lab', 'url' => ['/lab']];
$this->params['breadcrumbs'][] = $this->title;
$func=new Functions();
$Header="Department of Science and Technology<br>";
$Header.="Laboratory Request";
if(Yii::$app->user->can('allow-cancel-request')){
    $Button="{view}{update}{delete}";
}else{
    $Button="{view}{update}";
}
///$Paymentitem= Paymentitem::find()->where(['request_id'=>$model->request_id])
$gg = 1;

?>
<div class="request-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
        echo $func->GenerateStatusLegend("Legend/Status",false);
    ?>
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
            'before'=>"<button type='button' onclick='LoadModal(\"Create Request\",\"/lab/request/create\")' class=\"btn btn-success\"><i class=\"fa fa-book-o\"></i> Create Request</button>",
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'rowOptions' => function($model){
            $Obj=$model->getPaymentStatusDetails($model->request_id);
            $class=$Obj[0]['class'];
            $objClass= explode('-', $class);
            return ['class'=>$objClass[1]];
        },
        'exportConfig'=>$func->exportConfig("Laboratory Request", "laboratory request", $Header),
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'request_ref_num',
            [
                'label'=>'Request Date',
                'attribute'=>'request_datetime',
                'value'=>function($model){
                    return date('d/m/Y H:i:s',strtotime($model->request_datetime));
                },
                'filter'=>DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'request_datetime',
                    'value' => date('d-M-Y', strtotime('+2 days')),
                    'options' => ['placeholder' => 'Select date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]),
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

                    $tagging= Tagging::find()->where(['user_id'=> Yii::$app->user->id])->count();


                    return "<span class='badge ".$model->status->class." btn-block' style='width:80px!important;height:20px!important;'>".$model->status->status."</span>";
                }
            ],
            [
                'label'=>'Report Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value'=>function($model){
                    if($model->testreports){
                        return "<span class='badge badge-success' style='width:80px!important;height:20px!important;'>View</span>";
                    }else{
                        return "<span class='badge badge-default' style='width:80px!important;height:20px!important;'>View</span>";
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
                       return "<span class='badge ".$Obj[0]['class']."' style='width:80px!important;height:20px!important;'>".$Obj[0]['payment_status']."</span>"; 
                    }else{
                       return "<span class='badge badge-primary' style='width:80px!important;height:20px!important;'>Unpaid</span>";
                    }
                   //
                }
            ],
            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => $Button,
                'buttons' => [
                    
                    'view' => function ($url, $model){
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => '/lab/request/view?id=' . $model->request_id,'onclick'=>'location.href=this.value', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Request")]);
                    },
                    'update' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => '/lab/request/update?id=' . $model->request_id, 'onclick' => 'LoadModal(this.title, this.value);', 'class' => 'btn btn-success', 'title' => Yii::t('app', "Update Request")]);
                    },
                    'delete' => function ($url, $model) { //Cancel
                        if($model->IsRequestHasOP()){
                            if($model->IsRequestHasReceipt()){
                                return Html::button('<span class="glyphicon glyphicon-ban-circle"></span>', ['value' => '/lab/cancelrequest/create?req=' . $model->request_id,'onclick' => 'LoadModal(this.title, this.value,true,"420px");', 'class' => 'btn btn-danger', 'title' => Yii::t('app', "Cancel Request")]);
                            }else{
                                return Html::button('<span class="glyphicon glyphicon-ban-circle"></span>', ['class' => 'btn btn-danger','disabled'=>true, 'title' => Yii::t('app', "Cancel Request")]);
                            }
                        }else{
                            return Html::button('<span class="glyphicon glyphicon-ban-circle"></span>', ['value' => '/lab/cancelrequest/create?req=' . $model->request_id,'onclick' => 'LoadModal(this.title, this.value,true,"420px");', 'class' => 'btn btn-danger', 'title' => Yii::t('app', "Cancel Request")]);
                        }
                    }
                ],
            ],
        ],
]); ?>
</div>
