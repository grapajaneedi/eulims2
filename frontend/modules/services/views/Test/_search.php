<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\services\TestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'test_id') ?>

    <?= $form->field($model, 'agency_id') ?>

    <?= $form->field($model, 'testname') ?>

    <?= $form->field($model, 'method') ?>

    <?= $form->field($model, 'references') ?>

    <?php // echo $form->field($model, 'fee') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'test_category_id') ?>

    <?php // echo $form->field($model, 'sample_type_id') ?>

    <?php // echo $form->field($model, 'lab_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
