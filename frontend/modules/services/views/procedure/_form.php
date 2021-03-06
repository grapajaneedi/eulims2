<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Procedure */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedure-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'procedure_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'procedure_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
