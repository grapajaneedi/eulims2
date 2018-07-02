<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\BillingReceipt */

$this->title = 'Update Billing Receipt: ' . $model->billing_receipt_id;
$this->params['breadcrumbs'][] = ['label' => 'Billing Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->billing_receipt_id, 'url' => ['view', 'id' => $model->billing_receipt_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="billing-receipt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
