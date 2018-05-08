<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Request', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'request_id',
            'request_ref_num',
            'request_datetime:datetime',
            'rstl_id',
            'lab_id',
            // 'customer_id',
            // 'payment_type_id',
            // 'modeofrelease_id',
            // 'discount',
            // 'discount_id',
            // 'purpose_id',
            // 'or_id',
            // 'total',
            // 'report_due',
            // 'conforme',
            // 'receivedBy',
            // 'created_at',
            // 'posted',
            // 'status_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
