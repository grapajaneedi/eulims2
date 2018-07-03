<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\finance\BillingReceiptSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="billing-receipt-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'billing_receipt_id') ?>

    <?= $form->field($model, 'soa_date') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'billing_id') ?>

    <?php // echo $form->field($model, 'receipt_id') ?>

    <?php // echo $form->field($model, 'soa_number') ?>

    <?php // echo $form->field($model, 'previous_balance') ?>

    <?php // echo $form->field($model, 'current_amount') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
