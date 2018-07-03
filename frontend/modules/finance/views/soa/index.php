<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\finance\BillingReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Statement of Accounts';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance']];
$this->params['breadcrumbs'][] = ['label' => 'Billing', 'url' => ['/finance/billing']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-receipt-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Statement of Account', ['value'=>'/finance/soa/create','onclick'=>'ShowModal(this.title,this.value)', 'class' => 'btn btn-success','title' => Yii::t('app', "Create Statement of Account"),'id'=>'btnSOA']); ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => "",
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'billing_receipt_id',
            'soa_date',
            'customer_id',
            'user_id',
            'billing_id',
            // 'receipt_id',
            // 'soa_number',
            // 'previous_balance',
            // 'current_amount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
