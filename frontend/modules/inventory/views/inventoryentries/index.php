<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use common\components\Functions;
use common\models\inventory\Products;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel common\models\inventory\InventoryEntriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$func= new Functions();
$Header="Department of Science and Technology<br>";
$Header.="Inventory Entries";
$this->title = 'Inventory Entries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-entries-index">

    <div class="table-responsive">
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                 'before'=>"<button type='button' onclick='LoadModal(\"Create New Entry\",\"create\",true,\"900\")' class=\"btn btn-success\"><i class=\"fa fa-plus-o\"></i> Create New Entry</button>",
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'exportConfig'=>$func->exportConfig("Inventory Entries", "inventory_entries", $Header),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'inventory_transactions_id',
            // 'transaction_type_id',
            // 'rstl_id',
            [
                'attribute' => 'product_id',
                'label' => 'Product',
                'value' => function($model) {
                    return $model->product->product_name;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Products::find()->asArray()->all(), 'product_id', 'product_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Products', 'id' => 'grid-product-search']
            ],
            //'manufacturing_date',
                 
            'expiration_date',
            //'created_by',
            //'suppliers_id',
            //'po_number',
            'quantity',
            'amount',
            //'total_amount',
            //'Image1',
            //'Image2',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
</div>