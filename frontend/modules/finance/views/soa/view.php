<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\BillingReceipt */

$this->title = $model->billing_receipt_id;
$this->params['breadcrumbs'][] = ['label' => 'Billing Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-receipt-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->billing_receipt_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->billing_receipt_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'billing_receipt_id',
            'soa_date',
            'customer_id',
            'user_id',
            'billing_id',
            'receipt_id',
            'soa_number',
            'previous_balance',
            'current_amount',
        ],
    ]) ?>

</div>
