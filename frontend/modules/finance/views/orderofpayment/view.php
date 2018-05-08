<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Orderofpayment */

$this->title = $model->orderofpayment_id;
$this->params['breadcrumbs'][] = ['label' => 'Orderofpayments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orderofpayment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->orderofpayment_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->orderofpayment_id], [
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
           // 'orderofpayment_id',
           // 'rstl_id',
            'transactionnum',
            'collectiontype_id',
            'order_date',
            'customer.customer_name',
          //  'amount',
           // 'purpose',
            //'created_receipt',
        ],
    ]) ?>

</div>
