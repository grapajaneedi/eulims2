<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\finance\BillingReceipt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="billing-receipt-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'billing_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'receipt_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
    
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'soa_date')->textInput() ?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'soa_number')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'customer_id')->textInput() ?>
        </div>
        <div class="col-md-6">
     <?= $form->field($model, 'previous_balance')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'current_amount')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
    
        </div>
    </div>
    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create SOA' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id'=>'createSOA']) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
