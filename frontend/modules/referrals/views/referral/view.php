<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Referral */

$this->title = $model->referral_id;
$this->params['breadcrumbs'][] = ['label' => 'Referrals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referral-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->referral_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->referral_id], [
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
            'referral_id',
            'referral_code',
            'referral_date',
            'referral_time',
            'receiving_agency_id',
            'testing_agency_id',
            'lab_id',
            'sample_received_date',
            'customer_id',
            'payment_type_id',
            'modeofrelease_id',
            'purpose_id',
            'discount_id',
            'discount_amt',
            'total_fee',
            'report_due',
            'conforme',
            'received_by',
            'bid',
            'cancelled',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
