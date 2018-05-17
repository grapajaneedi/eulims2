<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Lab */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lab-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
        <?php
        echo $form->field($model, 'lab_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Lab::find()->asArray()->all(), 'lab_id', 'labname'),
            'language' => 'de',
            'options' => ['placeholder' => 'Select a Laboratory'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'labcode')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'labcount')->textInput() ?>
        </div>
         <div class="col-md-6">
    <?= $form->field($model, 'nextrequestcode')->textInput(['maxlength' => true]) ?>
        </div>
     </div>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'active')->checkbox() ?>
        </div>
    </div>
     <div style="position:absolute;right:18px;bottom:10px;">
         <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
    <?php ActiveForm::end(); ?>

</div>
