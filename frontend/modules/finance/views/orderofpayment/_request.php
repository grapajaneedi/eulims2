<?php
use yii\helpers\Html;
use kartik\grid\GridView;
?>

 <?php 
    $gridColumn = [
        [
            'class' => '\kartik\grid\SerialColumn',
            
         ],
         [
            'class' => '\kartik\grid\CheckboxColumn',
           
         ],
        'request_ref_num',
        'request_datetime',
    ];
?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax'=>true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        
        'responsive'=>true,
        'striped'=>true,
        'hover'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title">Request</h3>',
            'type'=>'primary',
            //'footer'=> false,
         ],
         'columns' =>$gridColumn,
    ]); ?>

