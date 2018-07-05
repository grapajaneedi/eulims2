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
Yii::$app->basePath
?>
<div class="billing-receipt-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Statement of Account', ['value'=>'/finance/soa/create','onclick'=>'ShowModal(this.title,this.value)', 'class' => 'btn btn-success','title' => Yii::t('app', "Create Statement of Account"),'id'=>'btnSOA']); ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>false,
        'hover' => true,
        'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => "",
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'attribute'=>'soa_date',
                'label'=>'Date',
                'hAlign' => 'center',
                'value'=>function($model){
                    return date("m/d/Y",strtotime($model->soa_date));
                }
            ],
            [
                'attribute'=>'soa_number',
                'hAlign' => 'center',
            ],
            [
                'attribute'=>'customer_id',
                'hAlign' => 'right',
                'pageSummary'=>'TOTAL'
            ],
            [
                'attribute'=>'previous_balance',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
                'pageSummary' => true,
            ],
            [
                'attribute'=>'current_amount',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
                'pageSummary' => true,
            ],
            [
                'attribute'=>'total_amount',
                'label'=>'Total',
                'hAlign'=>'right',
                'format' => ['decimal', 2],
                'pageSummary' => true,
            ],

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>
