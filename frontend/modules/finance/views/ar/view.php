<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Billing */

$this->title = $model->billing_id;
$this->params['breadcrumbs'][] = ['label' => 'Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->billing_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->billing_id], [
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
            'billing_id',
            'invoice_number',
            'user_id',
            'customer_id',
            'soa_number',
            'billing_date',
            'due_date',
            'receipt_id',
            'amount',
        ],
    ]) ?>

</div>
