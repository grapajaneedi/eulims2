<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\referral\ReferralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Referrals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referral-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Referral', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'referral_id',
            'referral_code',
            'referral_date',
            'referral_time',
            'receiving_agency_id',
            //'testing_agency_id',
            //'lab_id',
            //'sample_received_date',
            //'customer_id',
            //'payment_type_id',
            //'modeofrelease_id',
            //'purpose_id',
            //'discount_id',
            //'discount_amt',
            //'total_fee',
            //'report_due',
            //'conforme',
            //'received_by',
            //'bid',
            //'cancelled',
            //'create_time',
            //'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
