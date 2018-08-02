<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\finance\Client;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\components\Functions;

/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\clientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'On Account';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance/']];
$this->params['breadcrumbs'][] = ['label' => 'Billing', 'url' => ['/finance/billing/']];
$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->user->can('allow-on-account-delete')){
    $Buttontemplate='{view}{update}{delete}';
}else{
    $Buttontemplate='{view}{update}';
}
$func= new Functions();
$rstlID=$GLOBALS['rstl_id'];
?>
<div class="client-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
            'heading' => '<i class="fa fa-users"></i>  Manage On Account',
            'before'=>Html::tag('button','Add On Account', ['title'=>'Add On Account','value'=>'/finance/billing/clientcreate','class' => 'btn btn-success','onclick'=>'LoadModal(this.title, this.value)']),
        ],
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,
              ],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'account_number', 
                'label'=>'On Account #',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->account_number;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Client::find()->orderBy('account_number')->asArray()->all(), 'account_number', 'account_number'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Account #'],
                'format' => 'raw'
            ],
            [
                'attribute' => 'customer_id', 
                'label'=>'Customer',
                'value' => function ($model, $key, $index, $widget) { 
                    return $model->customer ? $model->customer->customer_name : '';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map($func->GetClientList($rstlID), 'customer_id', 'customer_name'), 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Select Customer'],
                'format' => 'raw'
            ],
            [
                'attribute'=>'company_name',
                'label'=>'Head'
            ],            
            [
               'attribute'=>'signature_date',
               'filterType'=> GridView::FILTER_DATE_RANGE,
               'value' => function($model) {
                    return date_format(date_create($model->signature_date),"m/d/Y");
                },
                'filterWidgetOptions' => ([
                     'model'=>$model,
                     'useWithAddon'=>true,
                     'attribute'=>'signature_date',
                     'startAttribute'=>'StartDate',
                     'endAttribute'=>'EndDate',
                     'presetDropdown'=>TRUE,
                     'convertFormat'=>TRUE,
                     'pluginOptions'=>[
                        'allowClear' => true,
                        'todayHighlight' => true,
                        'cancel'=>'Clear',
                        'locale'=>[
                            'format'=>'Y-m-d',
                            'separator'=>' to ',
                        ],
                         'opens'=>'left',
                      ],
                      'pluginEvents'=>[
                        "cancel.daterangepicker" => "function(ev, picker) {
                        picker.element[0].children[1].textContent = '';
                        $(picker.element[0].nextElementSibling).val('').trigger('change');
                        }",
                        
                        'apply.daterangepicker' => 'function(ev, picker) { 
                        var val = picker.startDate.format(picker.locale.format) + picker.locale.separator +
                        picker.endDate.format(picker.locale.format);

                        picker.element[0].children[1].textContent = val;
                        $(picker.element[0].nextElementSibling).val(val);
                        }',
                      ] 
                ]),        
               
            ],
            // 'signed',
            // 'active',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => $Buttontemplate,
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => Url::to(['/finance/billing/clientview/','id'=>$model->client_id]), 'onclick' => 'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "View Client")]);
                    },
                    'update' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to(['/finance/billing/clientupdate/','id'=>$model->client_id]), 'onclick' => 'LoadModal(this.title, this.value);', 'class' => 'btn btn-success', 'title' => Yii::t('app', "Update Client")]);
                    },
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['clientdelete', 'id' => $model->client_id], [
                        "class" => "btn btn-danger",
                        "data" => [
                            "confirm" => "Are you absolutely sure you want to remove this Account</strong>?",
                            "method" => "post",
                        ],
                    ]);
                    }
                ],
            ],
    ],
    ]); ?>
</div>
