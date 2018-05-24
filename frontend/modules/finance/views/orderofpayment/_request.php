<?php
use yii\helpers\Html;
use kartik\grid\GridView;

$js=<<<SCRIPT
   $(".kv-row-checkbox").click(function(){
       // alert(this.value);
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
        'request_datetime',
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
    ]); ?>

