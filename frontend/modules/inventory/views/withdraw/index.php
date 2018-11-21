<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\inventory\InventoryWithdrawalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventory Withdrawals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-withdrawal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Inventory Withdrawal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'inventory_withdrawal_id',
            'created_by',
            'withdrawal_datetime',
            'lab_id',
            'total_qty',
            //'total_cost',
            //'remarks:ntext',
            //'inventory_status_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
