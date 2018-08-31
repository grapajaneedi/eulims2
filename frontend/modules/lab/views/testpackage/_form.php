<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\testpackage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testpackage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lab_sampletype_id')->textInput() ?>

    <?= $form->field($model, 'package_rate')->textInput() ?>

    <?= $form->field($model, 'testname_methods')->textInput() ?>

    <?= $form->field($model, 'added_by')->textInput() ?>

    <div class="form-group pull-right">
    <?php if(Yii::$app->request->isAjax){ ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <?php } ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
