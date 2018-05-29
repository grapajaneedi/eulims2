<?php
use kartik\grid\GridView;

$js=<<<SCRIPT
   $(".kv-row-checkbox").click(function(){
       // alert(this.value);
        var keys = $('#grid').yiiGridView('getSelectedRows');
        $("#orderofpayment-requestids").val(keys.join());
      
   });    
   $(".select-on-check-all").change(function(){
        var keys = $('#grid').yiiGridView('getSelectedRows');
        $("#orderofpayment-requestids").val(keys.join());
   });
SCRIPT;
$this->registerJs($js);
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
        [
            'attribute'=>'request_datetime',
            'pageSummary' => '<span style="float:right;">Total</span>',
        ],
        [
            'attribute'=>'total',
            'enableSorting' => false,
            'contentOptions' => [
                'style'=>'max-width:80px; overflow: auto; white-space: normal; word-wrap: break-word;'
            ],
            'hAlign' => 'right', 
            'vAlign' => 'middle',
            'width' => '7%',
            'format' => ['decimal', 2],
            'pageSummary' => true
        ],
    ];
?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'grid',
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
         'showPageSummary' => true,
    ]); ?>

