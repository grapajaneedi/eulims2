<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Functions;
use kartik\money\MaskMoney;
use kartik\date\DatePicker;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Billing */
/* @var $form yii\widgets\ActiveForm */
$func=new Functions();
$js=<<<SCRIPT
    function getKeys(dkeys){
        var SearchFieldsTable = $(".kv-grid-table>tbody");
        var trows = SearchFieldsTable[0].rows;
        var Total=0.00;
        var amt=0.00;
        $.each(trows, function (index, row) {
            var data_key=$(row).attr("data-key");
            for (i = 0; i < dkeys.length; i++) { 
                if(data_key==dkeys[i]){
                    amt=StringToFloat(trows[index].cells[4].innerHTML);
                    Total=Total+parseFloat(amt);
                }
            }
        }); 
        $("#billing-amount-disp").val(Total);
        $("#billing-amount").val(Total);
        $("#billing-amount-disp").maskMoney('mask', Total);
    }
   $(".kv-row-checkbox").change(function(){
       var keys=$("#OPGrid").yiiGridView("getSelectedRows");
       getKeys(keys);
   });    
        
SCRIPT;
$this->registerJs($js);
?>

<div class="billing-form" style="padding-top: 0px;margin-top: 0px">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'receipt_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'soa_number')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'billing_date')->hiddenInput()->label(false) ?>
    <div class="row" style="padding-top: 0px;margin-top: 0px">
        <div class="col-md-6">
         <?= $form->field($model, 'invoice_number')->textInput(['readonly'=>true]) ?>
        </div>
        <div class="col-md-6">
        <label class="control-label" for="billing-invoice_number">Customer</label>
        <?php 
        echo $func->GetCustomerList($form, $model)
        ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
           <label class="control-label" for="billing-invoice_number">Invoice Date</label>
        <?php 
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'billing_date',
                'readonly'=>true,
                //'disabled'=>true,
                'options' => ['placeholder' => 'Select Date'],
                'value'=>function($model){
                     return date("m/d/Y",$model->billing_date);
                },
                'pluginOptions' => [
                    'autoclose' => false,
                    'removeButton' => false,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); 
        ?>
        </div>
        <div class="col-md-6">
            <label class="control-label" for="billing-invoice_number">Due Date</label>
        <?php 
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'due_date',
                'readonly'=>true,
                //'disabled'=>true,
                'options' => ['placeholder' => 'Select Date'],
                'value'=>function($model){
                     return date("m/d/Y",$model->due_date);
                },
                'pluginOptions' => [
                    'autoclose' => false,
                    'removeButton' => false,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); 
        ?>
        </div>
    </div>
    <hr style="margin-bottom: 10px;margin-top: 10px">
    <div class="row">
        <div class="col-md-12">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id'=>'OPGrid',
        'pjax'=>true,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'containerOptions'=>['style'=>'overflow: auto;height: 200px'],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'toolbar'=>[],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
               // 'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
               'footer'=>false   
            ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'class'=>'kartik\grid\CheckboxColumn',
            ],
            'transactionnum',
            'order_date',
            [
                'attribute'=>'total_amount',
                'hAlign' => 'right',
                'contentOptions' => ['class' => 'op-amount'],
                'label'=>'Amount',
                'value'=>function($model){
                    return number_format($model->total_amount,2);
                }
            ],
        ],
    ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            
        </div>
        <div class="col-md-4">
    <?php
    echo $form->field($model, 'amount')->widget(MaskMoney::classname(), [
         'readonly'=>true,
         'options'=>[
             'style'=>'text-align: right'
         ],
         'pluginOptions' => [
            'prefix' => '₱ ',
            'allowNegative' => false,
         ]
        ])->label(false);
    ?>
        </div>
    </div>
   <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id'=>'btnCreateBI','disabled'=>false]) ?>
            <button type="reset" class="btn btn-danger">Reset</button>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
