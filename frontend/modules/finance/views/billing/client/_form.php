<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\checkbox\CheckboxX;
use common\components\Functions;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\finance\client */
/* @var $form yii\widgets\ActiveForm */
$func=new Functions();
$rstl_id= \Yii::$app->user->identity->profile->rstl_id;
$customerList=$func->GetCustomerClientList($rstl_id);
$JS=<<<SCRIPT
   $("#client-customer_id").change(function(){
        $.get("/ajax/getcustomerhead", {
           id: this.value
        }, function(customer){
           if(customer){
                $("#client-company_name").val(customer.head);
           }
        });
   }); 
SCRIPT;
$this->registerJs($JS);
?>
<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'client_id')->hiddenInput()->label(false) ?>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'account_number')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'signature_date')->widget(DatePicker::classname(),[
                'readonly'=>true,
                'value'=>function($model){
                     return date("m/d/Y",$model->signature_date);
                },
                'pluginOptions' => [
                    'autoclose' => false,
                    'removeButton' => false,
                    'format' => 'yyyy-mm-dd'
                ]
            ])->label("Signature Date");
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php 
            if($model->isNewRecord){
                echo $form->field($model, 'customer_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map($customerList, 'customer_id', 'customer_name'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select Customer'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label("Customer"); 
            }else{
                echo $func->GetCustomerList($form, $model, false,'Customer');  
            }
            ?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true])->label("Head") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php
                echo $form->field($model, 'signed')->widget(CheckboxX::classname(), [
                    'autoLabel'=>true,
                    'pluginOptions'=>['threeState'=>false]
                ])->label(false);
            ?>
        </div>
        <div class="col-md-6">
            <?php
                echo $form->field($model, 'active')->widget(CheckboxX::classname(), [
                    'autoLabel'=>true,
                    'pluginOptions'=>['threeState'=>false]
                ])->label(false);
            ?>
        </div>
    </div>
    <div class="row pull-right" style="padding-right: 15px">
        <?= Html::submitButton($model->isNewRecord ? 'Add Client' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button style='margin-left: 5px' type='button' class='btn btn-secondary pull-left-sm' data-dismiss='modal'>Cancel</button>
    </div>
    <?php ActiveForm::end(); ?>
    </div>

</div>
