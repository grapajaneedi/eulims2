<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */

$this->title = $model->request_id;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->request_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->request_id], [
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
            'request_id',
            'request_ref_num',
            'request_datetime:datetime',
            'rstl_id',
            'lab_id',
            'customer_id',
            'payment_type_id',
            'modeofrelease_id',
            'discount',
            'discount_id',
            'purpose_id',
            'or_id',
            'total',
            'report_due',
            'conforme',
            'receivedBy',
            'created_at',
            'posted',
            'status_id',
        ],
    ]) ?>

</div>
