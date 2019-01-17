<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use common\models\inventory\InventoryWithdrawaldetails;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->inventoryEntries,
        'key' => 'inventory_transactions_id'
    ]);
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_dataInventoryWithdrawaldetails', ['model' => $model->withdrawdetails]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        
        [
                'attribute' => 'suppliers_id',
                'label' => 'Supplier',
                'value' => function($model){                   
                    return $model->suppliers->suppliers;                
                },
        ],
        [
                'attribute' => 'created_at',
                'label' => 'Transaction Date',
                'value' => function($model){                   
                    return date('Y-m-d', ($model->created_at));                
                },
        ],               
         [
             'attribute' => 'po_number',  
             'pageSummary' => '<span style="float:right;">Total:</span>',
         ],
         [
           'attribute' => 'quantity',   
           'format' => ['decimal', 2],
            'pageSummary' => true  
         ],
         [
                'attribute' => 'withdrawdetails',
                'label' => 'Withdrawn',
                'value' => function($model){  


                $withdrawn = InventoryWithdrawaldetails::find()->where(['inventory_transactions_id'=>$model->inventory_transactions_id])->sum('quantity');


                    return $withdrawn;                
                },
                'format' => ['decimal', 2],
                'pageSummary' => true  

        ],
         [
           'attribute' => 'amount',   
           'format' => ['decimal', 2],
            'pageSummary' => true  
         ],
         [
           'attribute' => 'total_amount',   
           'format' => ['decimal', 2],
            'pageSummary' => true  
         ],
        
    ];
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'containerOptions' => ['style' => 'overflow: auto'],
        'pjax' => true,
        'beforeHeader' => [
            [
                'options' => ['class' => 'skip-export']
            ]
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'showPageSummary' => true,
        'persistResize' => false,
    ]);
