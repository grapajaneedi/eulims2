<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\finance\Collectiontype;
use common\models\finance\Paymentmode;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\Op */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\components\Functions;

$func= new Functions();
$this->title = 'Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Cashier', 'url' => ['/finance/cashier']];
$this->params['breadcrumbs'][] = 'Receipt';
$Header="Department of Science and Technology<br>";
$Header.="Receipt";
?>
<div class="orderofpayment-index">
    
  <div class="table-responsive">
    <?php 
    $Buttontemplate='{view}'; 
    ?>
      
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'responsive'=>false,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                
        ],
        'exportConfig'=>$func->exportConfig("Receipt", "receipt", $Header),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'or_number',
            [
               'attribute'=>'receiptDate',
               'filterType'=> GridView::FILTER_DATE_RANGE,
               'value' => function($model) {
                    return date_format(date_create($model->receiptDate),"m/d/Y");
                },
                'filterWidgetOptions' => ([
                     'model'=>$model,
                     'useWithAddon'=>true,
                     'attribute'=>'order_date',
                     'startAttribute'=>'createDateStart',
                     'endAttribute'=>'createDateEnd',
                     'presetDropdown'=>TRUE,
                     'convertFormat'=>TRUE,
                     'pluginOptions'=>[
                         'allowClear' => true,
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
            'payor',
            'total',
            [
                'attribute' => 'payment_mode_id',
                'label' => 'Payment Mode',
                'value' => function($model) {
                    return $model->paymentMode->payment_mode;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Paymentmode::find()->asArray()->all(), 'payment_mode_id', 'payment_mode'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Payment Mode', 'id' => 'grid-op-search-payment_mode_id']
            ],
            [
                'attribute' => 'collectiontype_id',
                'label' => 'Collection Type',
                'value' => function($model) {
                    return $model->collectiontype->natureofcollection;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Collectiontype::find()->asArray()->all(), 'collectiontype_id', 'natureofcollection'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Collection Type', 'id' => 'grid-op-search-collectiontype_id']
            ],
            [
                'attribute' => 'cancelled',
                'value' => function($model) {
                    return $model->cancelled == 0 ? "No" : "Yes";
                },
                'filter' => ['0'=>'No', '1'=>'Yes'],  
            ],
            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => $Buttontemplate,
                 'buttons'=>[
                    'view'=>function ($url, $model) {
                          return Html::a('View', ['/finance/cashier/view-receipt?receiptid='.$model->receipt_id], ['target'=>'_blank','class'=>'btn btn-primary']);
                    },
                  ],
            ],

        ],
    ]); ?>
     
  </div>
</div>

