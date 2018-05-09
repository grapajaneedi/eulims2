<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Collectiontype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="collectiontype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'collectiontype_id')->textInput() ?>

    <?= $form->field($model, 'natureofcollection')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

   
    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
