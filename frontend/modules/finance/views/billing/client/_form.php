<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\lab\Customer;
use kartik\select2\Select2;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model common\models\finance\client */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'client_id')->hiddenInput()->label(false) ?>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'account_number')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'signature_date')->textInput(['readonly'=>true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'customer_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Customer::find()->all(), 'customer_id', 'customer_name'),
                'language' => 'en',
                'options' => ['placeholder' => 'Select Customer'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
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
