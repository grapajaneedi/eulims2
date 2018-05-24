<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="analysis-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_analysis')->textInput() ?>

    <?= $form->field($model, 'rstl_id')->textInput() ?>

    <?= $form->field($model, 'pstcanalysis_id')->textInput() ?>

    <?= $form->field($model, 'request_id')->textInput() ?>

    <?= $form->field($model, 'sample_id')->textInput() ?>

    <?= $form->field($model, 'sample_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'testname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'references')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_id')->textInput() ?>

    <?= $form->field($model, 'cancelled')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
