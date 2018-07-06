<?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use common\components\Functions;
use yii\helpers\ArrayHelper;
use kartik\helpers\Html;
use kartik\money\MaskMoney;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\BillingReceipt */
/* @var $form yii\widgets\ActiveForm */

$func=new Functions();
$rstl_id=$GLOBALS['rstl_id'];
$ClientList=$func->GetClientList($rstl_id);
$customerJS=<<<SCRIPT
    function() { 
        $("#BIGridContainer").html("");  
    }   
SCRIPT;
$js=<<<SCRIPT
    $("#soaform-customer_id").change(function(){
        $.post("/ajax/getsoabalance", {
            customer_id: this.value,
        }, function(result){
           if(result){
                $("#soaform-previous_balance").val(result);
                $("#soaform-previous_balance-disp").val(result);
                $("#soaform-previous_balance-disp").maskMoney('mask',result);
                var c_amount=$("#soaform-current_amount").val();
                var tot=c_amount+parseFloat(result);
                $("#createSOA").prop('disabled',tot<=0);
           }
        });
        $.get("/finance/soa/getbigrid", {
            id: this.value
        }, function(result){
           if(result){
              $("#BIGridContainer").html(result); 
           }
        });
    });     
SCRIPT;
$this->registerJs($js);
?>

<div class="billing-receipt-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'active')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'payment_amount')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'bi_ids')->hiddenInput()->label(false) ?>
    <div class="row">
        <div class="col-md-6">
        <?php
             echo $form->field($model, 'soa_date')->widget(DatePicker::classname(), [
             'options' => ['placeholder' => 'Select Date ...',
             'autocomplete'=>'off'],
             'type' => DatePicker::TYPE_COMPONENT_APPEND,
                 'pluginOptions' => [
                     'format' => 'yyyy-mm-dd',
                     'todayHighlight' => true,
                     'autoclose'=>true,   
                 ]
             ]);
        ?>
        </div>
        <div class="col-md-6">
        <?php
             echo $form->field($model, 'payment_due_date')->widget(DatePicker::classname(), [
             'options' => ['placeholder' => 'Select Date ...',
             'autocomplete'=>'off'],
             'type' => DatePicker::TYPE_COMPONENT_APPEND,
                 'pluginOptions' => [
                     'format' => 'yyyy-mm-dd',
                     'todayHighlight' => true,
                     'autoclose'=>true,   
                 ]
             ]);
        ?>
        </div>
    </div>
     <div class="row">
        <div class="col-md-6">
            <?php 
                echo $form->field($model, 'customer_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($ClientList, 'customer_id', 'customer_name'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select Customer ...'],
                //'pluginEvents' => [
                //    "select2:select" => $customerJS,
                //],
                'pluginOptions' => [
                  'allowClear' => true
                ],
                ])->label("Customer");
               
               
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'soa_number')->textInput(['maxlength' => true,'disabled'=>true]) ?>
        </div>
    </div>
    <div class="row">
        <div id="BIGridContainer" class="col-md-12">
             <?php
             echo GridView::widget([
                 'dataProvider' => $dataProvider,
                 'id' => 'BIGrid',
                 'pjax' => true,
                 'bordered' => true,
                 'striped' => true,
                 'condensed' => true,
                 'responsive' => false,
                 'hover' => true,
                 'containerOptions' => ['style' => 'overflow: auto;height: 200px'],
                 'pjaxSettings' => [
                     'options' => [
                         'enablePushState' => false,
                     ]
                 ],
                 'toolbar' => [],
                 'panel' => [
                     'type' => GridView::TYPE_PRIMARY,
                     'footer' => false
                 ],
                 'columns' => [
                     ['class' => 'kartik\grid\SerialColumn'],
                     [
                         'class' => 'kartik\grid\CheckboxColumn',
                     ],
                     [
                         'attribute' => 'invoice_number',
                         'label' => 'BI #',
                         'hAlign' => 'center',
                     ],
                     [
                         'attribute' => 'billing_date',
                         'hAlign' => 'center',
                     ],
                     [
                         'attribute' => 'due_date',
                         'hAlign' => 'center',
                     ],
                     [
                         'attribute' => 'amount',
                         'hAlign' => 'right',
                         'contentOptions' => ['class' => 'bi-amount'],
                         'label' => 'Amount',
                         'value' => function($model) {
                             return number_format($model->amount, 2);
                         }
                     ],
                 ],
             ]);
             ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
        <?php
            echo $form->field($model, 'previous_balance')->widget(MaskMoney::classname(), [
            'readonly'=>true,
            'options'=>[
                'style'=>'text-align: right'
            ],
            'pluginOptions' => [
               'prefix' => '₱ ',
               'allowNegative' => false,
            ]
           ])->label("Previous Balance");
        ?>
        </div>
        <div class="col-md-4">
        <?php
            echo $form->field($model, 'current_amount')->widget(MaskMoney::classname(), [
            'readonly'=>true,
            'options'=>[
                'style'=>'text-align: right'
            ],
            'pluginOptions' => [
               'prefix' => '₱ ',
               'allowNegative' => false,
            ]
           ])->label("Current Amount");
        ?>
        </div>
        <div class="col-md-4">
        <?php
            echo $form->field($model, 'total_amount')->widget(MaskMoney::classname(), [
            'readonly'=>true,
            'options'=>[
                'style'=>'text-align: right'
            ],
            'pluginOptions' => [
               'prefix' => '₱ ',
               'allowNegative' => false,
            ]
           ])->label("Total Amount");
        ?>
        </div>
    </div>
    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create SOA' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id'=>'createSOA','disabled'=>true]) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
