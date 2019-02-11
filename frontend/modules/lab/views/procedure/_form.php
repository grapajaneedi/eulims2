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

    <?= $form->field($model, 'testname_id')->textInput() ?>

    <?= $form->field($model, 'testname_method_id')->textInput() ?>

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
