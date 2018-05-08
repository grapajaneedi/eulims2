<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\finance\Collectiontype;
use common\models\lab\Customer;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Orderofpayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orderofpayment-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="alert alert-info" style="background: #d9edf7 !important;margin-top: -20px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d">Fields with <i class="fa fa-asterisk text-danger"></i> are required.</p>
     
    </div>
   <?php 
       
	echo $form->field($model, 'collectiontype_id')->widget(Select2::classname(), [
    	'data' => ArrayHelper::map(Collectiontype::find()->all(), 'collectiontype_id', 'natureofcollection'),
    	'language' => 'en',
    	'options' => ['placeholder' => 'Select Collection Type ...'],
    	'pluginOptions' => [
      	  'allowClear' => true
    	],
	])->label('<label class="required">*</label>'.'Collection Type');
    ?>
  
    <?php
    echo $form->field($model, 'order_date')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Select Date ...'],
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'autoclose'=>true
        ]
    ])->label('<label class="required">*</label>'.'Date');
    ?>
    
    <?php
        echo $form->field($model, 'customer_id')->widget(Select2::classname(), [
    	'data' => ArrayHelper::map(Customer::find()->all(), 'customer_id', 'customer_name'),
    	'language' => 'en',
    	'options' => ['placeholder' => 'Select a customer ...'],
    	'pluginOptions' => [
      	  'allowClear' => true
    	],
	])->label('<label class="required">*</label>'.'Customer Name');
     ?>

    <?= $form->field($model, 'amount')->textInput(['type'=>'number'])->label('<label class="required">*</label>'.'Amount'); ?>

    <?= $form->field($model, 'purpose')->textarea(['maxlength' => true])->label('<label class="required">*</label>'.'Purpose/For payment of'); ?>

   
    

    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
